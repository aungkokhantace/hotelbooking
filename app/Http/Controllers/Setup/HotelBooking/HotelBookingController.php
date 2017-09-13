<?php

namespace App\Http\Controllers\Setup\HotelBooking;

use App\Core\Check;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use App\Payment\PaymentUtility;
use App\Setup\BookingPaymentStripe\BookingPaymentStripe;
use App\Setup\BookingPaymentStripe\BookingPaymentStripeRepository;
use App\Setup\Hotel\HotelRepository;

use App\Setup\Booking\BookingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Setup\Booking\Booking;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class HotelBookingController extends Controller
{
    private $repo;

    public function __construct(BookingRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            //Get Login User Info
            $user               = $this->repo->getUserObjs();
            $id                 = $user->id;
            $role               = $user->role_id;
            $email              = $user->email;
            if ($role == 3) {
                //Get Hotel ID
                $hotelRepo      = new HotelRepository();
                $hotel          = $hotelRepo->getHotelByAdminId($id);
                $hotel_id       = $hotel->id;
                $bookings       = $this->repo->getBookingByHotelId($hotel_id);
            } else {
                $bookings       = $this->repo->getObjs();
            }
            if(isset($bookings) && !empty($bookings)){
                foreach($bookings as $b){
                    switch($b->status){
                        case 2:
                            $b->status_text = 'Confirm';
                            break;
                        case 3:
                            $b->status_text = 'Cancel by Customer';
                            break;
                        case 4:
                            $b->status_text = 'Cancel by Admin';
                            break;
                        case 5:
                            $b->status_text = 'Complete';
                            break;
                        case 7:
                            $b->status_text = 'Refund by System';
                            break;
                        case 8:
                            $b->status_text = 'Refund by Admin';
                            break;
                        default:
                            $b->status_text = '';
                    }
                }
            }
            return view('backend.booking.index')->with('bookings',$bookings);
        }
        return redirect('/');
    }

    public function detail($id)
    {
        if(Auth::guard('User')->check()){
            //Get Login User Info
            $user                       = $this->repo->getUserObjs();
            $u_id                       = $user->id;
            $role                       = $user->role_id;
            $email                      = $user->email;
            if ($role == 3) {
                //Check User has permission to edit
                //Get Hotel ID
                $hotelRepo              = new HotelRepository();
                $hotel                  = $hotelRepo->getHotelByAdminId($u_id);
                $h_id                   = $hotel->id;
                $checkPermission        = $this->repo->checkHasPermission($id,$h_id);
                if ($checkPermission == false) {
                    return redirect('unauthorize');
                    exit();
                }
            }
            $booking                    = $this->repo->getBookingById($id);
            $b_check_out                = Carbon::parse($booking->check_out_date);
            $pay_date                   = Carbon::today();
            $booking->can_refund        = 0;
            if($pay_date <= $b_check_out && $booking->status == 5){
                $booking->can_refund    = 1;
            }

            return view('backend.booking.booking')->with('booking',$booking);
        }
        return redirect('/');
    }

    public function refundByHotelAdmin(){
        try{
            $b_id                   = Input::get('b_num');
            $refund_percentage      = Input::get('refund_percentage');

            $booking                = Booking::find($b_id);
            $b_check_out            = Carbon::parse($booking->check_out_date);
            $pay_date               = Carbon::today();

            //Declare Repository
            $paymentStripeRepo      = new BookingPaymentStripeRepository();
            DB::beginTransaction();
            if($pay_date <= $b_check_out && $booking->status == 5){
                /* Refund */
                $booking->status                = 8;
                $result                         = $this->repo->changeBookingStatus($booking);

                /* Change Booking Status */
                if($result['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->error('Refund Operation is unsuccessful.')->persistent('Close');
                    return redirect()->back();
                }
                else{
                    $stripePayment = $paymentStripeRepo->getStripePaymentId($b_id);
                    if(isset($stripePayment) && count($stripePayment) > 0){
                        $stripePaymentId            = $stripePayment->stripe_payment_id;
                        if($refund_percentage == 100) {
                            $refund_amount = $stripePayment->stripe_payment_amt;
                        }
                        else{
                            $refund_amount = $stripePayment->stripe_payment_amt / 2;
                        }
                        $original_amt               = $stripePayment->stripe_payment_amt;
                        $amount                     = $original_amt-$refund_amount;
                        $stripeId                   = $stripePayment->id;
                        $customer_id                = $stripePayment->stripe_user_id;

                        /* Refund Payment By hotel admin bcz customer want to pay with cash */
                        $stripePaymentObj           = new PaymentUtility();
//                        $refundResult['aceplusStatusCode'] = ReturnMessage::OK;
//                        $refundResult['stripe']['stripe_payment_id'] = 'ch_1AyCqZKi85kjRqY0eqnAMBY4';
                        $refundResult               = $stripePaymentObj->refundPaymentByHotelAdmin($customer_id,$refund_amount,$stripePaymentId);
                        if($refundResult['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            alert()->error('Refund Operation is unsuccessful.')->persistent('Close');
                            return redirect()->back();
                        }
                        else{
                            /* Change Booking Payment Stripe Status */
                            $stripe                     = BookingPaymentStripe::find($stripeId);
                            $stripe->status             = 4;
                            $stripe->stripe_payment_id  = $refundResult['stripe']['stripe_payment_id'];
                            $stripe->stripe_payment_amt = $amount;
                            $updateResult               = $paymentStripeRepo->update($stripe);

                            /* Change Booking Payment Stripe Status */
                            if($updateResult['aceplusStatusCode'] != ReturnMessage::OK){
                                DB::rollback();
                                alert()->error('Refund Operation is unsuccessful.')->persistent('Close');
                                return redirect()->back();
                            }
                            else{
                                DB::commit();
                                alert()->success('Refund Operation is successful.')->persistent('Close');
                                return redirect()->action('Setup\HotelBooking\HotelBookingController@index');
                            }
                        }
                    }
                    else{
                        DB::rollback();
                        alert()->warning("Oppp!!!There\'s no payment for this booking.")->persistent('Close');
                        return redirect()->back();
                    }
                }
                /* Refund */
            }
        }
        catch(\Exception $e){
            DB::rollback();
            $currentUser    = Utility::getCurrentUserID();
            $date           = date("Y-m-d H:i:s");
            $message        = '['. $date .'] '. 'error: ' . 'Hotel Admin - '.$currentUser.
                              ' refund the payment amount and got error -------'.$e->getMessage(). ' ----- line ' .
                              $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::create($date,$message);
            alert()->error('Refund Operation is unsuccessful.')->persistent('Close');
            return redirect()->back();
        }

    }
}
