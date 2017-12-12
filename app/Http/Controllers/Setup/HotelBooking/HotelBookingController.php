<?php

namespace App\Http\Controllers\Setup\HotelBooking;

use App\Core\Check;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use App\Payment\PaymentUtility;
use App\Setup\BookingPayment\BookingPayment;
use App\Setup\BookingPayment\BookingPaymentRepository;
use App\Setup\BookingPaymentStripe\BookingPaymentStripe;
use App\Setup\BookingPaymentStripe\BookingPaymentStripeRepository;
use App\Setup\BookingRoom\BookingRoomRepository;
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
            $bPaymentRepo           = new BookingPaymentRepository();
            $bRoomRepo              = new BookingRoomRepository();
            DB::beginTransaction();
            if($pay_date <= $b_check_out && $booking->status == 5){
                /* Refund */
                $booking->status                                = 8;
                $result                                         = $this->repo->changeBookingStatus($booking);
                // dd($result);
                /* Change Booking Status */
                if($result['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->error('Refund Operation is unsuccessful.')->persistent('Close');
                    return redirect()->back();
                }

                /* Get Booking Rooms and update status */
                $b_rooms                                        = $bRoomRepo->getActiveBookingRoom($b_id);
                if(isset($b_rooms) && count($b_rooms) > 0){
                    foreach($b_rooms as $b_room){
                        $b_room->status                         = 8;
                        $bRoomRes                               = $bRoomRepo->updateBookingRoom($b_room);
                        // dd($bRoomRes);
                        if($bRoomRes['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            alert()->error('Refund Operation is unsuccessful.')->persistent('Close');
                            return redirect()->back();
                        }
                    }
                }
                
                /* START booking payment */
                $oldBookPayment                                  = $bPaymentRepo->getObjsByBookingId($b_id);
                $newBookPayment                                  = new BookingPayment();
                $newBookPayment->payment_amount_wo_tax           = $oldBookPayment->payment_amount_wo_tax;
                $newBookPayment->payment_amount_w_tax            = $oldBookPayment->payment_amount_w_tax;
                $newBookPayment->description                     = "";
                $newBookPayment->booking_id                      = $b_id;
                $newBookPayment->payment_gateway_tax_amt         = $oldBookPayment->payment_gateway_tax_amt;
                $newBookPayment->status                          = 8;
                $newBookPayment->total_government_tax_amt        = $oldBookPayment->total_government_tax_amt;
//                $newBookPayment->total_government_tax_percentage = $oldBookPayment->$service_tax_amt;
                $newBookPayment->total_service_tax_amt           = $oldBookPayment->total_service_tax_amt;
//                $newBookPayment->total_service_tax_percentage    = $oldBookPayment->total_service_tax_percentage;
                $newBookPayment->total_payable_amt               = $oldBookPayment->total_payable_amt;
                $newBookPayment->payment_reference_no            = null;
                $bookPaymentResult                               = $bPaymentRepo->createBookingPayment($newBookPayment);
                // dd($bookPaymentResult);
                if($bookPaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->error('Refund Operation is unsuccessful.')->persistent('Close');
                    return redirect()->back();
                }
                /* END booking payment */

                $stripePayment                  = $paymentStripeRepo->getStripePaymentId($b_id);
                if(isset($stripePayment) && count($stripePayment) > 0){
                    $stripePaymentId            = $stripePayment->stripe_payment_id;
                    if($refund_percentage == 100) {
                        $refund_amount          = $stripePayment->stripe_payment_amt;
                    }
                    else{
                        $refund_amount          = $stripePayment->stripe_payment_amt / 2;
                    }
                    $original_amt               = $stripePayment->stripe_payment_amt;
                    $amount                     = $original_amt-$refund_amount;
                    $stripeId                   = $stripePayment->id;
                    $customer_id                = $stripePayment->stripe_user_id;

                    /* Refund Payment By hotel admin bcz customer want to pay with cash */
                    $stripePaymentObj           = new PaymentUtility();
                    $refundResult               = $stripePaymentObj->refundPaymentByHotelAdmin($customer_id,$refund_amount,$stripePaymentId);

                    /*
                    $refundResult['aceplusStatusCode'] = ReturnMessage::OK;
                    $refundResult['stripe']['stripe_user_id'] = 'cus_BgOILsMt1tGZOu';
                    $refundResult['stripe']['stripe_payment_id'] = 'ch_1BJ1VtHE4WclBNuJN6GKXOP7';
                    $refundResult['stripe']['stripe_payment_amt'] = 84.8;
                    $refundResult['stripe']['stripe_balance_transaction'] = 'txn_1BJ1jCHE4WclBNuJmq9E5D4a';
                    $refundResult['stripe']['stripe_refund_status'] = 'succeeded';*/
                    if($refundResult['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Refund Operation is unsuccessful.')->persistent('Close');
                        return redirect()->back();
                    }
                    
                    $refund_balance_transaction             = $refundResult['stripe']['stripe_balance_transaction'];
                    $stripeBalanceRes                       = $stripePaymentObj->retrieveBalance($refund_balance_transaction);

                    /*
                    $stripeBalanceRes['aceplusStatusCode'] = ReturnMessage::OK;
                    $stripeBalanceRes['stripe']['stripe_balance_transaction'] = 'txn_1BJ1jCHE4WclBNuJmq9E5D4a';
                    $stripeBalanceRes['stripe']['stripe_payment_id'] = 're_1BJ1jCHE4WclBNuJCyjQKLxu';
                    $stripeBalanceRes['stripe']['stripe_payment_amt'] = -84.8;
                    $stripeBalanceRes['stripe']['stripe_payment_fee'] = -2.76;
                    $stripeBalanceRes['stripe']['stripe_payment_net'] = -82.04;*/
                    
                    if($stripeBalanceRes['aceplusStatusCode'] != ReturnMessage::OK){
                        // shouldn't rollback, write log or do something bcz refundPayment method is already executed.
                        DB::rollback();
                        alert()->error('Refund Operation is unsuccessful.')->persistent('Close');
                        return redirect()->back();
                    }

                    // Get Booking Payment Id
                    $new_b_payment_id                               = $bookPaymentResult['object']->id;

                    // Get booking_payment_stripe info
                    $stripe                                         = BookingPaymentStripe::find($stripeId);
                    $stripe_email                                   = $stripe->email;
                    $stripe_booking_id                              = $stripe->booking_id;

                    $stripe_payment_amt                             = $stripeBalanceRes['stripe']['stripe_payment_amt'];
                    $stripe_payment_fee                             = $stripeBalanceRes['stripe']['stripe_payment_fee'];
                    $stripe_payment_net                             = $stripeBalanceRes['stripe']['stripe_payment_net'];
                    $stripe_balance_transaction                     = $stripeBalanceRes['stripe']['stripe_balance_transaction'];
                    
                    /* Create Stripe Payment */
                    $newStripePayment                               = new BookingPaymentStripe();
                    $newStripePayment->stripe_user_id               = $customer_id;
                    $newStripePayment->stripe_payment_id            = $stripePaymentId;
                    $newStripePayment->stripe_balance_transaction   = $stripe_balance_transaction;
                    $newStripePayment->stripe_payment_amt           = $stripe_payment_amt;
                    $newStripePayment->stripe_payment_net           = $stripe_payment_net;
                    $newStripePayment->stripe_payment_fee           = $stripe_payment_fee;
                    $newStripePayment->status                       = 4; // refund status
                    $newStripePayment->email                        = $stripe_email;
                    $newStripePayment->booking_id                   = $stripe_booking_id;
                    $newStripePayment->booking_payment_id           = $new_b_payment_id;
                    $newStripePaymentRes                            = $paymentStripeRepo->createBookingPaymentStripe($newStripePayment);
                    /* Change Booking Payment Stripe Status */
                    /*
                    $stripe                     = BookingPaymentStripe::find($stripeId);
                    $stripe->status             = 4;
                    $stripe->stripe_payment_id  = $refundResult['stripe']['stripe_payment_id'];
                    $stripe->stripe_payment_amt = $amount;
                    $updateResult               = $paymentStripeRepo->update($stripe);*/

                    /* Change Booking Payment Stripe Status */
                    if($newStripePaymentRes['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Refund Operation is unsuccessful.')->persistent('Close');
                        return redirect()->back();
                    }

                    //if admin refund the booking was successful, then create date and message for refund booking success log
                    $currentUser = Utility::getCurrentUserID(); //get currently logged in customer
                    $date     = date('Y-m-d H:i:s');
                    $message  = '['. $date .'] '. 'info: ' . 'Admin '. $currentUser.' refund booking no. = '.$booking->booking_no.' is successful'. PHP_EOL;
                    LogCustom::create($date,$message);
                    
                    DB::commit();
                    alert()->success('Refund Operation is successful.')->persistent('Close');
                    return redirect()->action('Setup\HotelBooking\HotelBookingController@index');
                    
                    
                }
                else{
                    //create RefundByHotelAdmin error log
                    $currentUser                        = Utility::getCurrentUserID();
                    $date                               = date("Y-m-d H:i:s");
                    $errorMessage                       = "No payment for this booking.";

                    $message                            = '['. $date .'] '. 'error: ' . 'Admin - '.$currentUser.
                        ' refund by hotel admin and got error : '.$errorMessage. PHP_EOL;
                    LogCustom::create($date,$message);

                    DB::rollback();
                    alert()->warning("Oppp!!!There\'s no payment for this booking.")->persistent('Close');
                    return redirect()->back();
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
