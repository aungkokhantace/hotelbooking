<?php

namespace App\Http\Controllers\Frontend;

use App\Core\Check;
use App\Core\Config\Config;
use App\Core\Config\ConfigRepository;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use App\Payment\PaymentUtility;
use App\Setup\Amenities\AmenitiesRepository;
use App\Setup\Booking\Booking;
use App\Setup\Booking\BookingRepositoryInterface;
use App\Setup\Booking\CommunicationRepository;
use App\Setup\BookingPayment\BookingPayment;
use App\Setup\BookingPayment\BookingPaymentRepository;
use App\Setup\BookingPaymentStripe\BookingPaymentStripe;
use App\Setup\BookingPaymentStripe\BookingPaymentStripeRepository;
use App\Setup\BookingRequest\BookingRequestRepository;
use App\Setup\BookingRoom\BookingRoom;
use App\Setup\BookingRoom\BookingRoomRepository;
use App\Setup\BookingSpecialRequest\BookingSpecialRequest;
use App\Setup\BookingSpecialRequest\BookingSpecialRequestRepository;
use App\Setup\CoreSettings\CoreSettingRepository;
use App\Setup\Customer\CustomerRepository;
use App\Setup\Facilities\FacilitiesRepository;
use App\Setup\Hotel\Hotel;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelConfig\HotelConfigRepository;
use App\Setup\HotelFacility\HotelFacilityRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\Room\RoomRepository;
use App\Setup\RoomAvailablePeriod\RoomAvailablePeriodRepository;
use App\Setup\RoomDiscount\RoomDiscountRepository;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Faker\Provider\fr_CH\Payment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use PDF;
use Mail;

class BookingController extends Controller
{
    private $repo;
    private $stripe_fee_percent;
    private $stripe_fee_cents;
    public function __construct(BookingRepositoryInterface $repo){
        $this->repo                     = $repo;
        /* Stripe transaction fee is 2.9%+30 cents */
        $this->stripe_fee_percent       = 0.029; //2.9%
        $this->stripe_fee_cents         = 0.3;  //30 cents
    }

    public function booking_list(){
        if (Auth::guard('Customer')->check()) {
            $id                 = Utility::getCurrentCustomerID();
            $customerRepo       = new CustomerRepository();
            $customer           = $customerRepo->getObjByID($id);
            $bookings           = $this->repo->getBookingByCustomerId($id);
            $booking_room       = $this->repo->getBookingRoomByCustomerId($id);
            $booking_cancel     = array();

            foreach($bookings as $b){
                $count = 0;

                foreach($booking_room as $b_room){
                    if($b->id == $b_room->booking_id){
                        $count = $count+1;
                    }
                }
                $b->number_of_room = $count;
                /*
                 * status 1 is no use
                if($b->status == 1){
                    $b->status_txt      = "Pending";
                    $b->button_status   = "BOOKING PAYMENT";
                }*/
                if($b->status == 2){
                    $b->status_txt      = "Confirm";
                    $b->button_status   = "MANAGE BOOKING";
                }
                if($b->status == 3){
                    $b->status_txt      = "Cancel";
                    $b->button_status   = "BOOKING AGAIN";
                    array_push($booking_cancel,$b);
                }
                if($b->status == 5){
                    $b->status_txt      = "Complete";
                    $b->button_status   = "MANAGE BOOKING";
                }
                if($b->status == 7){
                    $b->status_txt      = "Cancel";
                    $b->button_status   = "BOOKING AGAIN";
                }
                if($b->status == 9){
                    $b->status_txt      = "Cancel";
                    $b->button_status   = "BOOKING AGAIN";
                }

            }

            return view('frontend.bookinglist')->with('customer',$customer)
                                               ->with('bookings',$bookings)
                                               ->with('booking_cancel',$booking_cancel);
        }
        return redirect('/');
    }

    public function manage($id){
        if (Auth::guard('Customer')->check()) {
            $customer               = session('customer');
            $b_id                   = $id;
            $u_id                   = Auth::guard('Customer')->id();
            $status                 = Check::checkBookingByUserId($b_id,$u_id);
            if($status['aceplusStatusCode'] == ReturnMessage::OK){
                $hotelRepo          = new HotelRepository();
                $h_facilityRepo     = new HotelFacilityRepository();
                $bRoomRepo          = new BookingRoomRepository();
                $amenityRepo        = new AmenitiesRepository();
                $facilityRepo       = new FacilitiesRepository();
                $settingRepo        = new CoreSettingRepository();
                $h_configRepo       = new HotelConfigRepository();
                $r_categoryRepo     = new HotelRoomCategoryRepository();
                $b_requestRepo      = new BookingRequestRepository();
                $communicationRepo  = new CommunicationRepository();

                $r_category_id      = array();
                $amenity_arr        = array();
                $facility_arr       = array();

                $booking            = $this->repo->getBookingById($b_id);
                $hotel              = $hotelRepo->getObjByID($booking->hotel_id);
                $h_facilities       = $h_facilityRepo->getHotelFacilitiesByHotelID($booking->hotel_id);
                $hotel->h_facilities= $h_facilities;

                $start              = Carbon::parse($booking->check_in_date);
                $end                = Carbon::parse($booking->check_out_date);
                $total_day          = $end->diffInDays($start);
                $booking->total_day = $total_day; //Add total booked days to booking

                $bRooms             = $bRoomRepo->getBookingRoomAndRoomByBookingId($b_id);

                $room_count         = count($bRooms);
                $booking->room_count= $room_count; //Add Number of Room to booking

                if(isset($bRooms) && count($bRooms) > 0){
                    foreach($bRooms as $bRoom){
                        array_push($r_category_id,$bRoom->h_room_category_id);
                    }
                }

                $amenities          = $amenityRepo->getAmenitiesByRoomCategoryId($r_category_id);
                $facilities         = $facilityRepo->getFacilitiesByRoomCategoryId($r_category_id);
                $r_categories       = $r_categoryRepo->getObjsByIdArr($r_category_id);
                if(isset($bRooms) && count($bRooms) > 0){
                    foreach($bRooms as $bRoom){

                        //Add amenities array in booking room
                        foreach($amenities as $amenity){
                            if($bRoom->h_room_category_id == $amenity->room_category_id){
                                array_push($amenity_arr,$amenity);
                            }
                        }
                        $bRoom->amenities   = $amenity_arr;
                        $amenity_arr        = array(); //Clear array

                        //Add facilities array in booking room
                        foreach($facilities as $facility){
                            if($bRoom->h_room_category_id == $facility->h_room_category_id){
                                array_push($facility_arr,$facility);
                            }
                        }
                        $bRoom->facilities  = $facility_arr;
                        $facility_arr       = array(); //Clear array

                        /*
                         * Check user_first_name,user_last_name in table.
                         * If there's no data for above fields in booking_room table, add customer name as guest name
                         * If exist, add user_first_name and user_last_name as guest_name
                         */

                        if($bRoom->user_first_name == "" && $bRoom->user_last_name == ""){
                            $guest_name             = $customer['display_name'];
                            $bRoom->guest_name      = $guest_name;
                        }
                        else{
                            $guest_name             = $bRoom->user_first_name.' '.$bRoom->user_last_name;
                            $bRoom->guest_name      = $guest_name;
                        }

                        //Add maximum count for one room
                        foreach($r_categories as $r_category){
                            if($r_category->id == $bRoom->h_room_category_id){
                                $max_count          = $r_category->capacity;
                                $bRoom->max_count   = $max_count;
                            }
                        }
                    }
                }
                $booking->rooms                     = $bRooms; //Add Rooms Array to booking

                if($booking->status == 2){
                    $booking->charge                = 'free';
                }
                if($booking->status == 5){
                    $h_config           = $h_configRepo->getFirstObjByHotelID($booking->hotel_id);
                    $first_cancel_days  = 0;
                    $second_cancel_days = 0;
                    if(isset($h_config) && count($h_config) > 0){
                        $first_cancel_days  = $h_config->first_cancellation_day_count;
                        $second_cancel_days = $h_config->second_cancellation_day_count;
                    }
                    $first_cancel_date  = Carbon::parse($booking->check_in_date)->subDays($first_cancel_days);
                    $second_cancel_date = Carbon::parse($booking->check_in_date)->subDays($second_cancel_days);
                    $today_date         = Carbon::now();
                    if($today_date >= $first_cancel_date && $today_date < $second_cancel_date){
                        $booking->charge= 'You must be pay 50% of total amount.';
                    }
                    else{
                        $booking->charge= 'You must be pay 100% of total amount.';
                    }
                }

                /* Booking Request */
                $b_request              = $b_requestRepo->getBookingRequestByBookingId($b_id);

                /* Booking Special Request */
                $communications         = $communicationRepo->getCommunicationByBookingId($b_id);

                /*get Cancel Reason */
                $reasons                = $settingRepo->getCancelReason('REASON');

//                dd($booking);

                return view('frontend.manage_booking')->with('customer',$customer)
                                                      ->with('booking',$booking)
                                                      ->with('hotel',$hotel)
                                                      ->with('reasons',$reasons)
                                                      ->with('b_request',$b_request)
                                                      ->with('communications',$communications);
            }
            else{
                dd('unauthorized');
            }
        }
        return redirect('/');

    }

    public function say_congratulation($id){
        $hotel_id   = $id;
        $hotelRepo  = new HotelRepository();
        $hotel      = $hotelRepo->getObjByID($hotel_id);

        return view('frontend.congratulations')->with('hotel',$hotel);
    }

    public function print_congratulation($id){
        $b_id                           = $id;
        $hotelRepo                      = new HotelRepository();
        $h_facilityRepo                 = new HotelFacilityRepository();
        $bRoomRepo                      = new BookingRoomRepository();
        $amenityRepo                    = new AmenitiesRepository();
        $facilityRepo                   = new FacilitiesRepository();
        $h_configRepo                   = new HotelConfigRepository();
        $b_requestRepo                  = new BookingRequestRepository();

        $r_category_id                  = array();
        $amenity_arr                    = array();
        $facility_arr                   = array();

        $booking                        = $this->repo->getBookingById($b_id);
        $hotel                          = $hotelRepo->getObjByID($booking->hotel_id);
        $h_facilities                   = $h_facilityRepo->getHotelFacilitiesByHotelID($booking->hotel_id);
        $hotel->h_facilities            = $h_facilities;

        $start                          = Carbon::parse($booking->check_in_date);
        $end                            = Carbon::parse($booking->check_out_date);
        $total_day                      = $end->diffInDays($start);
        $booking->total_day             = $total_day; //Add total booked days to booking

        $bRooms                         = $bRoomRepo->getBookingRoomAndRoomByBookingId($b_id);
        $room_count                     = count($bRooms);
        $booking->room_count            = $room_count; //Add Number of Room to booking

        /* Calculate Cancellation Cost */
        $h_config                       = $h_configRepo->getConfigByHotel($booking->hotel_id);
        $first_cancel_days              = 0;
        $second_cancel_days             = 0;
        if(isset($h_config) && count($h_config) > 0){
            $first_cancel_days          = $h_config->first_cancellation_day_count;
            $second_cancel_days         = $h_config->second_cancellation_day_count;
        }
        $first_cancel_date              = Carbon::parse($booking->check_in_date)->subDays($first_cancel_days)->format('M d, Y');
        $second_cancel_date             = Carbon::parse($booking->check_in_date)->subDays($second_cancel_days)->format('M d, Y');
        $free_cancel_days               = Carbon::parse($first_cancel_date)->diffInDays(Carbon::now());
        $free_cancel_date               = Carbon::parse($first_cancel_date)->subDay()->format('M d, Y');

        $booking->free_cancel_date      = $free_cancel_date;
        $booking->first_cancel_date     = $first_cancel_date;
        $booking->second_cancel_date    = $second_cancel_date;

        if(isset($bRooms) && count($bRooms) > 0){
            foreach($bRooms as $bRoom){
                array_push($r_category_id,$bRoom->h_room_category_id);
            }
        }

        $amenities                      = $amenityRepo->getAmenitiesByRoomCategoryId($r_category_id);
        $facilities                     = $facilityRepo->getFacilitiesByRoomCategoryId($r_category_id);
        if(isset($bRooms) && count($bRooms) > 0){
            $total_room_price           = 0.00;
            $total_extra_bed_price      = 0.00;
            foreach($bRooms as $bRoom){
                $total_room_price       += $bRoom->room_payable_amt;
//                $total_extra_bed_price  += $bRoom->extra_bed_price;
                //Add amenities array in booking room
                foreach($amenities as $amenity){
                    if($bRoom->h_room_category_id == $amenity->room_category_id){
                        array_push($amenity_arr,$amenity);
                    }
                }
                $bRoom->amenities       = $amenity_arr;
                $amenity_arr            = array();

                //Add facilities array in booking room
                foreach($facilities as $facility){
                    if($bRoom->h_room_category_id == $facility->h_room_category_id){
                        array_push($facility_arr,$facility);
                    }
                }
                $bRoom->facilities      = $facility_arr;
                $facility_arr           = array();
            }
        }
        $booking->total_room_price      = $total_room_price;
//        $booking->total_extra_bed_price = $total_extra_bed_price;
        $booking->rooms                 = $bRooms; //Add Rooms Array to booking

        /* get booking request to know special request */
        $b_request                      = $b_requestRepo->getBookingRequestByBookingId($b_id);

        /* Start Print Function */
        $view                           = \View::make('frontend.print_confirmation',compact('booking','hotel','h_config','b_request'));
        $html                           = $view->render();
        $pdf                            = new TCPDF();

        $pdf::SetTitle('Booking Confirmation Preview');
        $pdf::AddPage();
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('pdf_booking_confirmation.pdf');
        /* End Print Function */

    }

    public function cancel_booking(Request $request){
        try{
            $h_configRepo                                   = new HotelConfigRepository();
            $paymentStripeRepo                              = new BookingPaymentStripeRepository();
            $bookRoomRepo                                   = new BookingRoomRepository();
            $bookPaymentRepo                                = new BookingPaymentRepository();
            $response                                       = array();
            $response['aceplusStatusCode']                  = '500';

            if($request->ajax()){
                $reason                                     = Input::get('reason');
                $id                                         = Input::get('id');
                $booking                                    = Booking::find($id);
                $h_id                                       = $booking->hotel_id;
                $booking_status                             = $booking->status;

                DB::beginTransaction();
                if($booking_status == 2){
                    /*
                     * If booking status is 2(confirm), steps must be
                     * (1) No Charge,No Refund(Free Cancellation)
                     * (2) Change Status
                     * (3) Send Mail
                     */

                    /* START changing status for booking */
                    $booking->status                        = 3;
                    $booking->booking_cancel_reason         = $reason;
                    $result                                 = $this->repo->changeBookingStatus($booking);
                    if($result['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        return \Response::json($response);
                    }
                    /* END changing status for booking */
                    /* START changing status for booking room */
                    $bookRooms                          = $bookRoomRepo->getBookingRoomByBookingId($id);
                    foreach($bookRooms as $bRoom){
                        $bRoom->status                  = 3;
                        $bRoomResult                    = $bookRoomRepo->update($bRoom);
                        if($bRoomResult['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                    }
                    /* END changing status for booking room */
                    /* START changing status for booking payment */
                    $oldBookPayment                                  = $bookPaymentRepo->getObjsByBookingId($id);
                    $newBookPayment                                  = new BookingPayment();
                    $newBookPayment->payment_amount_wo_tax           = $oldBookPayment->payment_amount_wo_tax;
                    $newBookPayment->payment_amount_w_tax            = $oldBookPayment->payment_amount_w_tax;
                    $newBookPayment->description                     = "";
                    $newBookPayment->booking_id                      = $id;
                    $newBookPayment->payment_id                      = $oldBookPayment->payment_id;
                    $newBookPayment->payment_gateway_tax_amt         = $oldBookPayment->payment_gateway_tax_amt;
                    $newBookPayment->status                          = 3;
                    $newBookPayment->total_government_tax_amt        = $oldBookPayment->total_government_tax_amt;
                    $newBookPayment->total_government_tax_percentage = $oldBookPayment->total_service_tax_amt;
                    $newBookPayment->total_service_tax_amt           = $oldBookPayment->total_service_tax_amt;
                    $newBookPayment->total_service_tax_percentage    = $oldBookPayment->total_service_tax_percentage;
                    $newBookPayment->total_payable_amt               = $oldBookPayment->total_payable_amt;
                    $newBookPayment->payment_reference_no            = null;

                    $bookPaymentResult                               = $bookPaymentRepo->create($newBookPayment);
                    if($bookPaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        return \Response::json($response);
                    }
                    /* END changing status for booking payment */
                    DB::commit();
                    /* START send mail */
                    $user_email                         = $booking->user->email;
                    $hotel                              = Hotel::find($h_id);
                    $hotel_email                        = $hotel->email;
                    $emails                             = array($user_email,$hotel_email);
                    $system_email                       = Utility::getSystemAdminMail();

                    if(isset($system_email) && count($system_email) > 0){
                        foreach($system_email as $s_email){
                            array_push($emails,$s_email);
                        }
                    }
                    //Send Mail to Customer,SystemAdmin,HotelAdmin
                    $mailTemplate                       = 'frontend.mail.cancel_mail';
                    $subject                            = 'Booking Cancellation';
                    $logMessage                         = 'update the booking id - '.$id;
                    $returnState                        = Utility::sendMail($mailTemplate,$emails,$subject,$logMessage);

                    if($returnState['aceplusStatusCode'] == ReturnMessage::OK){
                        $response['aceplusStatusCode']  = '200';
                        $response['param']              = $booking->id;
                    }
                    else{
                        $response['aceplusStatusCode']  = '503';
                        $response['param']              = $booking->id;
                    }
                    /* END send mail */

                }

                if($booking_status == 5){
                    /*
                     * If booking status is 5(complete), there are two condition
                     * (1) Within 1st Cancellation day
                     *              or
                     * (2) Within 2nd Cancellation day.
                     *
                     * For 1st condition, if cancellation date is within 1st cancellation day
                     * (1) 50% Refund
                     * (2) Change Status
                     * (3) Send Mail
                     *
                     * For 2nd condition, if cancellation date is within 2nd cancellation day
                     * (1) No Refund
                     * (2) Change Status
                     * (3) Send Mail
                     */
                    $h_config                           = $h_configRepo->getObjByID($booking->hotel_id);
                    $first_cancel_days                  = 0;
                    $second_cancel_days                 = 0;
                    if(isset($h_config) && count($h_config) > 0){
                        $first_cancel_days              = $h_config->first_cancellation_day_count;
                        $second_cancel_days             = $h_config->second_cancellation_day_count;
                    }
                    $first_cancel_date                  = Carbon::parse($booking->check_in_date)->subDays($first_cancel_days);
                    $second_cancel_date                 = Carbon::parse($booking->check_in_date)->subDays($second_cancel_days);
                    $today_date                         = Carbon::now();
//                    dd($first_cancel_date,$second_cancel_date,$today_date);
                    /* For 1st Cancellation Day */
                    if($today_date >= $first_cancel_date && $today_date < $second_cancel_date){
//                        dd('first');
                        /* Refund */
                        $stripePayment                  = $paymentStripeRepo->getStripePaymentId($id);
                        $stripePaymentId                = '';
                        if(isset($stripePayment) && count($stripePayment) > 0){
                            $stripePaymentId            = $stripePayment->stripe_payment_id;
                            $refund_amount              = $stripePayment->stripe_payment_amt/2;
                            $original_amt               = $stripePayment->stripe_payment_amt;
//                        $refund_amount              = 5;
                            $amount                     = $original_amt-$refund_amount;
                            $stripeId                   = $stripePayment->id;
                            $customer_id                = $stripePayment->stripe_user_id;
                        }
                        $stripePaymentObj               = new PaymentUtility();
                        $refundResult                   = $stripePaymentObj->refundPayment($customer_id,$refund_amount,$stripePaymentId);
                        if($refundResult['aceplusStatusCode'] == ReturnMessage::OK){
                            $stripe                     = BookingPaymentStripe::find($stripeId);
                            $stripe->status             = 3;
                            $stripe->stripe_payment_id  = $refundResult['stripe']['stripe_payment_id'];
                            $stripe->stripe_payment_amt = $amount;
                            $updateResult               = $paymentStripeRepo->update($stripe);
                            if($updateResult['aceplusStatusCode'] == ReturnMessage::OK){
                                /* Change Status */
                                $booking->status                = 7;
                                $booking->booking_cancel_reason = $reason;
                                $result                         = $this->repo->changeBookingStatus($booking);
                                if($result['aceplusStatusCode'] == ReturnMessage::OK){
                                    /* Send Mail */
                                    $user_email                     = $booking->user->email;
                                    $hotel                          = Hotel::find($h_id);
                                    $hotel_email                    = $hotel->email;
                                    $emails                         = array($user_email,$hotel_email);
                                    $system_email                   = Utility::getSystemAdminMail();

                                    if(isset($system_email) && count($system_email) > 0){
                                        foreach($system_email as $s_email){
                                            array_push($emails,$s_email);
                                        }
                                    }
                                    //Send Mail to Customer,SystemAdmin,HotelAdmin
                                    $mailTemplate                   = 'frontend.mail.cancel_mail';
                                    $subject                        = 'Booking Cancellation';
                                    $logMessage                     = 'update the booking id - '.$id;
                                    $returnState                    = Utility::sendMail($mailTemplate,$emails,$subject,$logMessage);
                                    if($returnState['aceplusStatusCode'] == ReturnMessage::OK){
                                        $response['aceplusStatusCode'] = '200';
                                        $response['param']             = $booking->id;
                                    }
                                    else{
                                        $response['aceplusStatusCode'] = '503';
                                        $response['param']             = $booking->id;

                                    }
                                    /* Send Mail */
                                    DB::commit();
                                }
                                /* Change Status */
                            }
                            else{
                                DB::rollback();
                                return \Response::json($response);
                            }
                        }
                        /* Refund */

                    }
                    /* For 2nd Cancellation Day */
                    else{
                        /* START changing status for booking */
                        $booking->status                    = 3;
                        $booking->booking_cancel_reason     = $reason;
                        $result                             = $this->repo->changeBookingStatus($booking);
                        if($result['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                        /* END changing status for booking */
                        /* START changing status for booking room */
                        $bookRooms                          = $bookRoomRepo->getBookingRoomByBookingId($id);
                        foreach($bookRooms as $bRoom){
                            $bRoom->status                  = 3;
                            $bRoomResult                    = $bookRoomRepo->update($bRoom);
                            if($bRoomResult['aceplusStatusCode'] != ReturnMessage::OK){
                                DB::rollback();
                                return \Response::json($response);
                            }
                        }
                        /* END changing status for booking room */
                        /* START changing status for booking payment */
                        $oldBookPayment                                  = $bookPaymentRepo->getObjsByBookingId($id);
//                        dd($oldBookPayment);
                        $newBookPayment                                  = new BookingPayment();
                        $newBookPayment->payment_amount_wo_tax           = $oldBookPayment->payment_amount_wo_tax;
                        $newBookPayment->payment_amount_w_tax            = $oldBookPayment->payment_amount_w_tax;
                        $newBookPayment->description                     = "";
                        $newBookPayment->booking_id                      = $id;
                        $newBookPayment->payment_id                      = $oldBookPayment->payment_id;
                        $newBookPayment->payment_gateway_tax_amt         = $oldBookPayment->payment_gateway_tax_amt;
                        $newBookPayment->status                          = 3;
                        $newBookPayment->total_government_tax_amt        = $oldBookPayment->total_government_tax_amt;
                        $newBookPayment->total_government_tax_percentage = $oldBookPayment->total_service_tax_amt;
                        $newBookPayment->total_service_tax_amt           = $oldBookPayment->total_service_tax_amt;
                        $newBookPayment->total_service_tax_percentage    = $oldBookPayment->total_service_tax_percentage;
                        $newBookPayment->total_payable_amt               = $oldBookPayment->total_payable_amt;
                        $newBookPayment->payment_reference_no            = null;

                        $bookPaymentResult                               = $bookPaymentRepo->create($newBookPayment);
                        if($bookPaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                        /* END changing status for booking payment */
                        DB::commit();
                        /* START sending email */
                        $user_email                     = $booking->user->email;
                        $hotel                          = Hotel::find($h_id);
                        $hotel_email                    = $hotel->email;
                        $emails                         = array($user_email,$hotel_email);
                        $system_email                   = Utility::getSystemAdminMail();
                        if(isset($system_email) && count($system_email) > 0){
                            foreach($system_email as $s_email){
                                array_push($emails,$s_email);
                            }
                        }
                        //Send Mail to Customer,SystemAdmin,HotelAdmin
                        $mailTemplate                   = 'frontend.mail.cancel_mail';
                        $subject                        = 'Booking Cancellation';
                        $logMessage                     = 'update the booking id - '.$id;
                        $returnState                    = Utility::sendMail($mailTemplate,$emails,$subject,$logMessage);
                        if($returnState['aceplusStatusCode'] == ReturnMessage::OK){
                            $response['aceplusStatusCode'] = '200';
                            $response['param']             = $booking->id;
                        }
                        else{
                            $response['aceplusStatusCode'] = '503';
                            $response['param']             = $booking->id;

                        }
                        /* END sending email */
                    }

                }

            }
            return \Response::json($response);

        }
        catch(\Exception $e){
            DB::rollback();
            $currentUser                        = Utility::getCurrentCustomerID();
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Customer - '.$currentUser.
                                                  ' cancel the booking and got error -------'.$e->getMessage(). ' ----- line ' .
                                                  $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::create($date,$message);
            $response['aceplusStatusCode']      = '500';

            return \Response::json($response);
        }

    }

    public function show_cancellation($id){
        $b_id                           = $id;
        $hotelRepo                      = new HotelRepository();
        $bRoomRepo                      = new BookingRoomRepository();

        $customer                       = session('customer');
        $booking                        = Booking::find($b_id);
        $h_id                           = $booking->hotel_id;
        $hotel                          = $hotelRepo->getObjByID($h_id);
        $start                          = Carbon::parse($booking->check_in_date);
        $end                            = Carbon::parse($booking->check_out_date);
        $total_day                      = $end->diffInDays($start);
        $booking->total_day             = $total_day; //Add total booked days to booking

        $bRooms                         = $bRoomRepo->getBookingRoomAndRoomByBookingId($b_id);
        $room_count                     = count($bRooms);
        $booking->room_count            = $room_count; //Add Number of Room to booking

        $booking->check_in_date_fmt     = Carbon::parse($booking->check_in_date)->format('M d, Y');
        $booking->check_out_date_fmt    = Carbon::parse($booking->check_out_date)->format('M d, Y');

        return view('frontend.show_cancellation')->with('booking',$booking)
                                                 ->with('hotel',$hotel)
                                                 ->with('customer',$customer);


    }

    public function edit_room(Request $request){
        try{
            $response['aceplusStatusCode']              = '500';

            $bRoomRepo                                  = new BookingRoomRepository();

            if($request->ajax()){
                $room_id                                = Input::get('r_id');
                $booking_id                             = Input::get('b_id');
                $f_name                                 = Input::get('f_name');
                $l_name                                 = Input::get('l_name');
                $guest_count                            = Input::get('g_count');
                $bRoom                                  = $bRoomRepo->getObjectById($room_id);
                $bRoom->user_first_name                 = $f_name;
                $bRoom->user_last_name                  = $l_name;
                $bRoom->guest_count                     = $guest_count;
                $result                                 = $bRoomRepo->update($bRoom);
                if($result['aceplusStatusCode'] == ReturnMessage::OK){
                    /* Mail Send */
                    $booking                            = Booking::find($booking_id);
                    $user_email                         = $booking->user->email;
                    $hotel_id                           = $booking->hotel_id;
                    $hotel                              = Hotel::find($hotel_id);
                    $hotel_email                        = $hotel->email;
                    $emails                             = array($user_email,$hotel_email);
                    $system_email                       = Utility::getSystemAdminMail();
                    if(isset($system_email) && count($system_email) > 0){
                        foreach($system_email as $s_email){
                            array_push($emails,$s_email);
                        }
                    }
                    //Send Mail to Customer,SystemAdmin,HotelAdmin
                    $mailTemplate                       = 'frontend.mail.booking_update_mail';
                    $subject                            = 'Booking Updating';
                    $logMessage                         = "update the booking";
                    $returnState                        = Utility::sendMail($mailTemplate,$emails,$subject,$logMessage);
                    if($returnState['aceplusStatusCode'] == ReturnMessage::OK){
                        $response['aceplusStatusCode']  = '200';
                    }
                    else{
                        $response['aceplusStatusCode']  = '503';
                    }
                }
            }

            return \Response::json($response);

        }
        catch(\Exception $e){
            $response['aceplusStatusCode']              = '500';
            return \Response::json($response);
        }
    }

    public function communication(Request $request){
        try{
            $response['aceplusStatusCode']              = '500';

            $bSpRequestRepo                             = new BookingSpecialRequestRepository();

            if($request->ajax()){
                $b_id                                   = Input::get('id');
                $special_request                        = Input::get('special_request');
                $max_order                              = $bSpRequestRepo->getMaxOrder($b_id);
                $order                                  = $max_order + 1;
                $type                                   = 2;
                DB::beginTransaction();
                $paramObj                               = new BookingSpecialRequest();
                $paramObj->booking_id                   = $b_id;
                $paramObj->order                        = $order;
                $paramObj->special_request              = $special_request;
                $paramObj->type                         = $type;
                $result                                 = $bSpRequestRepo->create($paramObj);
                if($result['aceplusStatusCode'] == ReturnMessage::OK){
                    DB::commit();
                    $response['aceplusStatusCode']      = '200';
                }
                else{
                    DB::rollback();
                    $response['aceplusStatusCode']      = '500';
                }
            }

            return \Response::json($response);

        }
        catch(\Exception $e){
            $response['aceplusStatusCode']              = '500';
            return \Response::json($response);
        }
    }

    public function test_cancel($id){
        $booking            = Booking::find($id);
        $settingRepo        = new CoreSettingRepository();
        $reasons            = $settingRepo->getCancelReason('REASON');

        return view('frontend.booking_cancel')->with('reasons',$reasons)->with('booking',$booking);
//        return view('frontend.change_date')->with('booking',$booking);

    }

    public function change_date(Request $request){
        if($request->ajax()){
            try{
                $response['aceplusStatusCode']  = '500';
                $b_id                           = Input::get('id');
                $check_in                       = Input::get('check_in');
                $check_out                      = Input::get('check_out');

                $h_configRepo                   = new HotelConfigRepository();
                $b_roomRepo                     = new BookingRoomRepository();
                $roomRepo                       = new RoomRepository();
                $configRepo                     = new ConfigRepository();
                $b_paymentRepo                  = new BookingPaymentRepository();
                $stripeRepo                     = new BookingPaymentStripeRepository();

                //Find booking to get information
                $booking                        = $this->repo->getBookingById($b_id);
                /*
                 * If booking status is 2 (confirm), allow to change check_in and check_out date.
                 * If not, don't allow to change check_in and check_out date.
                 * So, check booking status.
                 */

                if($booking->status == 2){
//                    dd('status 2');
                    $new_check_in               = date('Y-m-d', strtotime($check_in));
                    $new_check_out              = date('Y-m-d', strtotime($check_out));
                    /*
                     * Check new check_in and check_out is available or not
                     */
                    $b_room                     = $b_roomRepo->getBookingRoomByBookingId($b_id);
                    $room_id_arr                = array();
                    foreach($b_room as $room){
                        array_push($room_id_arr,$room->room_id);
                    }
                    $h_id                       = $booking->hotel_id;
                    $r_available                = $this->repo->getAvailableRoom($new_check_in,$new_check_out,$room_id_arr);
                    $r_available_arr            = array();
                    $r_category_arr             = array();
                    if(isset($r_available) && count($r_available) > 0){
                        foreach($r_available as $available){
                            array_push($r_available_arr,$available->id);
                            array_push($r_category_arr,$available->h_room_category_id);
                        }
                    }
                    if($room_id_arr != $r_available_arr){
                        /*
                         * If room_id array from booking room is not same with room_id from available room array,
                         * then new check_in and check_out date can't be change.
                         * So, return error status.
                         */
                        return \Response::json($response);
                    }
                    /*
                     * Payment Calculation
                     * (1) Calculate total room price with discount and without discount and with extra bed price
                     * (2) Calculate total government tax amount
                     * (3) Calculate total service tax amount
                     * (4) Calculate total payable amount
                     */
                    /* Start (1) Calculate total room price with discount and without discount */
                    // Calculate the number of night stay
                    $difference                 = strtotime($check_out) - strtotime($check_in);
                    $nights                     = floor($difference/(60*60*24));
                    $room_with_discount         = $roomRepo->getRoomWithDiscount($r_category_arr,$r_available_arr);
                    foreach($b_room as $room){
                        foreach($room_with_discount as $room_discount){
                            if($room->room_id == $room_discount->id){
                                $room_discount->added_extra_bed = $room->added_extra_bed;
                            }
                        }
                    }

                    $total_discount_amount      = 0.00;
                    $total_discount_percent     = 0.00;
                    $total_room_price           = 0.00;
                    $room_discount_arr          = array();
                    $discount_temp_arr          = array();

                    if(isset($room_with_discount) && count($room_with_discount) > 0){
                        foreach($room_with_discount as $r_discount){
                            $next_date                  = $new_check_in;
                            //Calculate extra bed price
                            $extra_bed_price            = $r_discount->added_extra_bed==1?$r_discount->extra_bed_price:0.00;
                            for($i=1;$i<=$nights;$i++){

                                if($next_date >= $r_discount->discount_start_date && $next_date <= $r_discount->discount_end_date) {
                                    //Calculate total discount amount
                                    $discount_amount        = $r_discount->discount_type== 'Amount'?$r_discount->discount_amount:
                                        ($r_discount->discount_percent/100)*$r_discount->price;
                                    $total_discount_amount += $discount_amount;

                                    //Calculate total discount percent
                                    $discount_percent       = $r_discount->discount_type== '%'?$r_discount->discount_percent:
                                        number_format(($discount_amount/$r_discount->price)*100,2);
                                    $total_discount_percent+= $discount_percent;

                                    //Calculate room price
                                    $room_price             = ($r_discount->price-$discount_amount)+$extra_bed_price;
                                    $total_room_price      += $room_price;
                                }
                                else{
                                    $room_price             = $r_discount->price+$extra_bed_price;
                                    $total_room_price      += $room_price;
                                }
//                            $discount_amount            = 0.00;
//                            $discount_percent           = 0;
//                            $room_price                 = 0.00;
                                $next_date = date("Y-m-d", strtotime("1 day", strtotime($next_date)));
                            }
                            //Create temp array
                            $discount_temp_arr['room_id']           = $r_discount->id;
                            $discount_temp_arr['discount_amt']      = $total_discount_amount;
                            $discount_temp_arr['room_payable_amt']  = $room_price;
                            $discount_temp_arr['room_price']        = $r_discount->price;
                            $discount_temp_arr['extra_bed_price']   = $extra_bed_price;
                            array_push($room_discount_arr,$discount_temp_arr);
                            $discount_temp_arr                      = array();
                        }
                    }
                    /* End (1) */

                    /* Start (2) Calculate total government tax amount */
                    $total_government_tax_amt           = 0.00;
                    $total_government_tax_percentage    = 0;
                    $config                             = $configRepo->getGST();
                    if(isset($config) && count($config) > 0){
                        $total_government_tax_percentage= $config[0]->value;
                        $total_government_tax_amt       = ($total_government_tax_percentage/100)*$total_room_price;
                    }
                    /* End (2) */

                    // Get Hotel Config
                    $h_config                           = $h_configRepo->getObjByID($h_id);

                    /* Start (3) Calculate total service tax amount */
                    $total_service_tax_amt              = 0.00;
                    $total_service_tax_percentage       = 0;
                    if(isset($h_config) && count($h_config) > 0){
                        $total_service_tax_percentage   = $h_config->tax;
                        $total_service_tax_amt          = ($total_service_tax_percentage/100)*$total_room_price;
                    }
                    else{
                        $config                         = $configRepo->getServiceTax();
                        if(isset($config) && count($config) > 0){
                            $total_service_tax_percentage   = $config[0]->value;
                        }
                    }
                    /* End (3) */

                    /* Start (4) Calculate Total Payable Amount */
                    $total_payable_amount               = $total_room_price+$total_government_tax_amt+$total_service_tax_amt;
                    /* End (4) */

                    DB::beginTransaction();
                    //Update Booking
                    $booking->check_in_date                     = $new_check_in;
                    $booking->check_out_date                    = $new_check_out;
                    $booking->price_w_tax                       = $total_payable_amount;
                    $booking->price_wo_tax                      = $total_room_price;
                    $booking->total_government_tax_amt          = $total_government_tax_amt;
                    $booking->total_government_tax_percentage   = $total_government_tax_percentage;
                    $booking->total_service_tax_amt             = $total_service_tax_amt;
                    $booking->total_service_tax_percentage      = $total_service_tax_percentage;
                    $booking->total_payable_amt                 = $total_payable_amount;
                    $booking->total_discount_amt                = $total_discount_amount;
                    $booking->total_discount_percentage         = $total_discount_percent;
                    $booking_update_res                         = $this->repo->update($booking);
                    if($booking_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        return \Response::json($response);
                    }
                    //Update Booking Room
                    foreach($b_room as $room){
                        $room->check_in_date                    = $new_check_in;
                        $room->check_out_date                   = $new_check_out;
                        $room->number_of_night                  = $nights;
                        foreach($room_discount_arr as $discountKey=>$discountValue){
                            if($room->room_id == $discountValue['room_id']){
                                $room->room_price_per_night     = $discountValue['room_price'];
                                $room->discount_amt             = $discountValue['discount_amt'];
                                $room->room_payable_amt         = $discountValue['room_payable_amt'];
                                $room->extra_bed_price          = $discountValue['extra_bed_price'];
                                break;
                            }
                        }
                        $b_room_update_res                      = $b_roomRepo->update($room);
                        if($b_room_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                    }
                    //Update Booking Payment
                    $b_payment                                  = $b_paymentRepo->getObjsByBookingId($b_id);
                    $b_payment->payment_amount_wo_tax           = $total_room_price;
                    $b_payment->payment_amount_w_tax            = $total_payable_amount;
//                $b_payment->payment_gateway_tax_amt         = 0;
                    $b_payment->total_government_tax_amt        = $total_government_tax_amt;
                    $b_payment->total_government_tax_percentage = $total_government_tax_percentage;
                    $b_payment->total_service_tax_amt           = $total_service_tax_amt;
                    $b_payment->total_service_tax_percentage    = $total_service_tax_percentage;
                    $b_payment->total_payable_amt               = $total_payable_amount;
                    $b_payment_update_res                       = $b_paymentRepo->update($b_payment);
                    if($b_payment_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        return \Response::json($response);
                    }

                    /*
                     * If new check_in date is within first/second cancellation day, need to charge booking payment 100%.
                     */

                    $first_cancel_days          = 0;
                    $second_cancel_days         = 0;
                    if(isset($h_config) && count($h_config) > 0){
                        $first_cancel_days      = $h_config->first_cancellation_day_count;
                        $second_cancel_days     = $h_config->second_cancellation_day_count;
                    }
                    $first_cancel_date          = Carbon::parse($new_check_in)->subDays($first_cancel_days);
                    $today_date                 = Carbon::now();

                    if($today_date >= $first_cancel_date){

                        $stripe_payment         = $stripeRepo->getStripePaymentIdWithStatusOne($b_id);
                        $stripe_user_id         = $stripe_payment->stripe_user_id;
                        $paymentObj             = new PaymentUtility();
                        $stripe_capture_payment = $paymentObj->capturePayment($stripe_user_id,$total_payable_amount);
//                    $stripe_capture_payment['aceplusStatusCode'] = ReturnMessage::OK;
//                    $stripe_capture_payment['stripe']['stripe_payment_id'] = "ch_1B3e8sKi85kjRqY04ztN51oh";
//                    $stripe_capture_payment['stripe']['stripe_payment_amt'] = 113.85;

                        if($stripe_capture_payment['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                        $stripe_payment->stripe_payment_id          = $stripe_capture_payment['stripe']['stripe_payment_id'];
                        $stripe_payment->stripe_payment_amt         = $stripe_capture_payment['stripe']['stripe_payment_amt'];
//                        $stripe_payment->stripe_balance_transaction = $stripe_capture_payment['stripe']['stripe_balance_transaction'];
                        $stripe_payment->status             = 2;
                        $stripe_payment_update_res          = $stripeRepo->update($stripe_payment);
                        if($stripe_payment_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                        /* Payment is complete. So, we need to change status of booking, booking_room, booking_payment.*/
                        // Update status of Booking Payment
                        $b_payment->status                  = 2;
                        $b_payment_update_res               = $b_paymentRepo->update($b_payment);
                        if($b_payment_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                        // Update status of Booking Room
                        foreach($b_room as $room){
                            $room->status                   = 5;
                            $b_room_update_res              = $b_roomRepo->update($room);
                            if($b_room_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                                DB::rollback();
                                return \Response::json($response);
                            }
                        }
                        //Update status of Booking
                        $booking->status                    = 5;
                        $booking_update_res                 = $this->repo->update($booking);
                        if($booking_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }

                        // If all updating is complete,send mail
                        $email              = $booking->user->email;
                        $hotel_email        = $h_configRepo->getEmailByHotelId($h_id);
                        $hotel_email_str    = $hotel_email->email;
                        $system_email       = "testingmps2017@gmail.com";
                        $emails             = array($email,$hotel_email_str,$system_email);
                        $template           = "frontend.mail.booking_update_mail";
                        $subject            = "Updated your booking check_in and check_out date";
                        $logMessage         = "updated a booking";
                        $mailResult         = Utility::sendMail($template,$emails,$subject,$logMessage);
                        if ($mailResult['aceplusStatusCode'] != ReturnMessage::OK){
                            $response['aceplusStatusCode']  = '203';
                            return \Response::json($response);
                        }
                    }
                    DB::commit();
                    $response['aceplusStatusCode']      = '200';
                    return \Response::json($response);

                }
                else{
                    //don't allow to change check_in and check_out date
                    $response['aceplusStatusCode']      = '403';
                    return \Response::json($response);
                }

            }
            catch(\Exception $e){
                $currentUser                        = Utility::getCurrentCustomerID();
                $date                               = date("Y-m-d H:i:s");
                $message                            = '['. $date .'] '. 'error: ' . 'Customer - '.$currentUser.
                                                      ' changed the booking check_in, check_out date and got error -------'.
                                                      $e->getMessage(). ' ----- line ' .
                                                      $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

                LogCustom::create($date,$message);
                $response['aceplusStatusCode']  = '500';
                return \Response::json($response);
            }
        }
        else{
            $response['aceplusStatusCode']  = '404';
            return \Response::json($response);
        }
    }

    public function cancel_room($b_id,$r_id){
        try{
            DB::beginTransaction();
            /* Repository Declaration */
            $bRoomRepo                          = new BookingRoomRepository();
            $configRepo                         = new ConfigRepository();
            $bPaymentRepo                       = new BookingPaymentRepository();
            $h_configRepo                       = new HotelConfigRepository();
            $paymentStripeRepo                  = new BookingPaymentStripeRepository();
            /* Repository Declaration */

            //Get booking info
            $booking                            = $this->repo->getBookingById($b_id);
            $bStatus                            = $booking->status;
            $h_id                               = $booking->hotel_id;

            //Get canceled booking room info
            $bCancelRoom                        = $bRoomRepo->getObjectById($r_id);
//            dd('Cancel Room',$bCancelRoom);
            $cancel_room_payable_amt_wo_tax     = $bCancelRoom->room_payable_amt_wo_tax;
            $cancel_room_payable_amt_w_tax      = $bCancelRoom->room_payable_amt_w_tax;
            $cancel_room_price                  = $bCancelRoom->room_price_per_night;
            $cancel_room_discount_amt           = $bCancelRoom->discount_amt;
            $cancel_room_discount_percent       = number_format(($cancel_room_discount_amt/$cancel_room_price)*100,2);
            $cancel_room_gst_amt                = $bCancelRoom->government_tax_amt;

            $cancel_room_service_amt            = $bCancelRoom->service_tax_amt;
            $cancel_room_stripe_fee_percent     = $bCancelRoom->stripe_fee_percent;
            $cancel_room_net_amt                = $bCancelRoom->room_net_amt;
            if($bStatus == 2){
                /*
                 * Change status 3 for booking room.
                 * Recalculate without amount of canceled room for booking and update.
                 * If the canceled room is latest room,
                 * (1) Change the status 3 for booking.
                 * (2) Change status 3 for booking_payment.
                 * (3) Change status 4 for booking payment stripe.
                 * If not,
                 */
                $bCancelRoom->status                        = 3;
                $bRoomUpdateRes                             = $bRoomRepo->update($bCancelRoom);
                if($bRoomUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->error('Cancellation of room is fail.')->persistent('OK');
                }
                /*
                 * Before updating booking, need to check the cancel room is last room or not
                 * Start checking
                 */
                $total_price_wo_tax                         = 0.00;
                $total_price_w_tax                          = 0.00;
                $total_gst_amt                              = 0.00;
                $total_service_amt                          = 0.00;
                $total_discount_amt                         = 0.00;
                $total_stripe_fee_percent                   = 0.00;
                $total_stripe_net_amt                       = 0.00;
                $total_stripe_fee_amt                       = 0.00;
                $bActiveRoom                                = $bRoomRepo->getActiveBookingRoom($b_id);
                $bookingStatus                              = 3;
                $active                                     = 0;
                if(isset($bActiveRoom) && count($bActiveRoom) > 0){
                    $bookingStatus                          = $bStatus;
                    $active                                 = 1;
                    foreach($bActiveRoom as $activeRoom){
                        $total_price_wo_tax                += $activeRoom->room_payable_amt_wo_tax;
                        $total_price_w_tax                 += $activeRoom->room_payable_amt_w_tax;
                        $total_gst_amt                     += $activeRoom->government_tax_amt;
                        $total_service_amt                 += $activeRoom->service_tax_amt;
                        $total_discount_amt                += $activeRoom->discount_amt;
                        $total_stripe_fee_percent          += $activeRoom->stripe_fee_percent;
//                        $total_stripe_net_amt              += $activeRoom->room_net_amt;
                    }
                    $total_stripe_fee_amt                   = $total_stripe_fee_percent+$this->stripe_fee_cents;
                    $total_stripe_net_amt                   = $total_price_w_tax-$total_stripe_fee_amt;
                }
                /* End checking */
                /* Update Booking */
                $booking->price_wo_tax                      = $total_price_wo_tax;
                $booking->price_w_tax                       = $total_price_w_tax;
                $booking->total_government_tax_amt          = $total_gst_amt;
//                $booking->total_government_tax_percentage   = $total_government_tax_percentage;
                $booking->total_service_tax_amt             = $total_service_amt;
//                $booking->total_service_tax_percentage      = $total_service_tax_percentage;
                $booking->total_payable_amt                 = $total_price_w_tax;
                $booking->total_discount_amt                = $total_discount_amt;
//                $booking->total_discount_percentage         = $total_discount_percentage;
                $booking->status                            = $bookingStatus;
                $booking->total_stripe_fee_percent          = $total_stripe_fee_percent;
                $booking->total_stripe_fee_amt              = $total_stripe_fee_amt;
                $booking->total_stripe_net_amt              = $total_stripe_net_amt;
                $booking->total_vendor_net_amt              = $total_stripe_net_amt;
//                dd('booking after cancel room',$booking);
                $bookingUpdateRes                           = $this->repo->update($booking);
                if($bookingUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->error('Cancellation of room is fail.')->persistent('OK');
                }
                /* START changing status for booking payment */
                $bPayment                           = $bPaymentRepo->getObjsByBookingId($b_id);
                $bPayment->status                   = $bookingStatus;
                $bPayment->payment_amount_wo_tax    = $total_price_w_tax;
                $bPayment->payment_amount_w_tax     = $total_stripe_net_amt;
                $bPayment->payment_gateway_tax_amt  = $total_stripe_fee_amt;
                $bPayment->total_government_tax_amt = $total_gst_amt;
//                $bPayment->total_government_tax_percentage = ;
                $bPayment->total_service_tax_amt    = $total_service_amt;
//                $bPayment->total_service_tax_percentage = ;
                $bPayment->total_payable_amt        = $total_price_w_tax;
//                dd('Booking Payment',$bPayment);
                $bookPaymentResult                  = $bPaymentRepo->update($bPayment);
                if($bookPaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->error('Cancellation of room is fail.')->persistent('OK');
                }
                /*
                $oldBookPayment                                  = $bPaymentRepo->getObjsByBookingId($b_id);
                $newBookPayment                                  = new BookingPayment();
                $newBookPayment->payment_amount_wo_tax           = $total_price_w_tax;
                $newBookPayment->payment_amount_w_tax            = $total_stripe_net_amt;
                $newBookPayment->description                     = "";
                $newBookPayment->booking_id                      = $b_id;
                $newBookPayment->payment_id                      = $oldBookPayment->payment_id;
//                $newBookPayment->payment_gateway_tax_amt         = $oldBookPayment->payment_gateway_tax_amt;
                $newBookPayment->status                          = 3;
                $newBookPayment->total_government_tax_amt        = $total_gst_amt;
//                $newBookPayment->total_government_tax_percentage = $oldBookPayment->$service_tax_amt;
                $newBookPayment->total_service_tax_amt           = $total_service_amt;
//                $newBookPayment->total_service_tax_percentage    = $oldBookPayment->total_service_tax_percentage;
                $newBookPayment->total_payable_amt               = $total_price_w_tax;
                $newBookPayment->payment_reference_no            = null;

                $bookPaymentResult                               = $bPaymentRepo->create($newBookPayment);
                if($bookPaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->error('Cancellation of room is fail.')->persistent('OK');
                }*/
                /* END changing status for booking payment */
                /* START changing status for booking payment stripe */
                if(isset($active) && $active == 0){
//                    dd('no active room');
                    $bPaymentStripe             = $paymentStripeRepo->getStripePaymentIdByBookingId($b_id);
                    $bPaymentStripe->status     = 4; // cancel status
//                    dd('booking payment stripe',$bPaymentStripe);
                    $bPaymentStripeResult       = $paymentStripeRepo->update($bPaymentStripe);
                    if($bPaymentStripeResult['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                }
//                dd('active room');
                /* END changing status for booking payment stripe */
                DB::commit();
                // If all updating is complete,send mail
                $email              = $booking->user->email;
                $hotel_email        = $h_configRepo->getEmailByHotelId($h_id);
                $hotel_email_str    = $hotel_email->email;
                $system_email       = "testingmps2017@gmail.com";
                $emails             = array($email,$hotel_email_str,$system_email);
                $template           = "frontend.mail.booking_update_mail";
                $subject            = "Updated your booking check_in and check_out date";
                $logMessage         = "updated a booking";
                $mailResult         = Utility::sendMail($template,$emails,$subject,$logMessage);
                if ($mailResult['aceplusStatusCode'] != ReturnMessage::OK){
                    alert()->warning('Room cancellation is successful.But email could not be send for some reasons.')
                           ->persistent('OK');
                }
                alert()->success('Room cancellation is successful.Please check your email.')
                       ->persistent('OK');
                return redirect()->action('Frontend\BookingController@booking_list');
            }
            elseif($bStatus == 5){
                //Get hotel config info
                $h_config                               = $h_configRepo->getObjByID($h_id);
                /* Start Calculating Total Government Tax Amount and Percentage*/
                $government_tax_amt                     = 0.00;
                $government_tax_percentage              = 0;
                $config                                 = $configRepo->getGST();
                if(isset($config) && count($config) > 0){
                    $government_tax_percentage          = $config[0]->value;
                    $government_tax_amt                 = round(($government_tax_percentage/100)*$cancel_room_payable_amt_wo_tax,2);
                }
                /* End Calculating Total Government Tax Amount and Percentage*/
                /* Start Calculating Total Service Tax Amount and Percentage */
                $service_tax_amt                        = 0.00;
                $service_tax_percentage                 = 0;
                if(isset($h_config) && count($h_config) > 0){
                    $service_tax_percentage             = $h_config->tax;
                    $service_tax_amt                    = round(($service_tax_percentage/100)*$cancel_room_payable_amt_wo_tax,2);
                }
                else{
                    $config                             = $configRepo->getServiceTax();
                    if(isset($config) && count($config) > 0){
                        $service_tax_percentage         = number_format((float)$config[0]->value,2);
                        $service_tax_amt                = round(($service_tax_percentage/100)*$cancel_room_payable_amt_wo_tax,2);
                    }
                }
                /* End Calculating Total Service Tax Amount and Percentage */
                $first_cancel_days                      = 0;
                $second_cancel_days                     = 0;
                if(isset($h_config) && count($h_config) > 0){
                    $first_cancel_days                  = $h_config->first_cancellation_day_count;
                    $second_cancel_days                 = $h_config->second_cancellation_day_count;
                }

                $first_cancel_date                      = Carbon::parse($booking->check_in_date)->subDays($first_cancel_days);
                $second_cancel_date                     = Carbon::parse($booking->check_in_date)->subDays($second_cancel_days);
                $today_date                             = Carbon::now();
                if($today_date >= $first_cancel_date && $today_date < $second_cancel_date){

//                    dd('first');
                    // first cancellation
                    // refund 50% of room payable amount with tax
                    /*
                     * Update booking room table status and, fill after_refund fields
                     *
                     */
                    $cancel_room_refund_amt                     = $cancel_room_payable_amt_w_tax/2;

                    // dd('first');
                    // first cancellation
                    // refund 50% of room payable amount with tax
                    $cancel_room_refund_amt                     = round($cancel_room_payable_amt_w_tax/2,2);

                    $cancel_room_payable_amt_wo_tax_af          = $cancel_room_payable_amt_wo_tax/2;
                    /* Start Calculating Total Government Tax Amount and Percentage*/
                    $government_tax_amt                         = 0.00;
                    $government_tax_percentage                  = 0;
                    $config                                     = $configRepo->getGST();
                    if(isset($config) && count($config) > 0){
                        $government_tax_percentage              = $config[0]->value;
                        $government_tax_amt                     = round(($government_tax_percentage/100)*$cancel_room_payable_amt_wo_tax_af,2);
                    }
                    /* End Calculating Total Government Tax Amount and Percentage*/
                    /* Start Calculating Total Service Tax Amount and Percentage */
                    $service_tax_amt                            = 0.00;
                    $service_tax_percentage                     = 0;
                    if(isset($h_config) && count($h_config) > 0){
                        $service_tax_percentage                 = $h_config->tax;
                        $service_tax_amt                        = round(($service_tax_percentage/100)*$cancel_room_payable_amt_wo_tax_af,2);
                    }
                    else{
                        $config                                 = $configRepo->getServiceTax();
                        if(isset($config) && count($config) > 0){
                            $service_tax_percentage             = number_format((float)$config[0]->value,2);
                            $service_tax_amt                    = round(($service_tax_percentage/100)*$cancel_room_payable_amt_wo_tax_af,2);
                        }
                    }
                    $cancel_room_payable_amt_w_tax_af           = $cancel_room_payable_amt_wo_tax_af+$government_tax_amt+
                        $service_tax_amt;
                    $cancel_stripe_fee_amt_af                   = round($cancel_room_payable_amt_w_tax_af*$this->stripe_fee_percent,2);
                    $cancel_room_net_amt_af                     = $cancel_room_payable_amt_w_tax_af-$cancel_stripe_fee_amt_af;
                    /* End Calculating Total Service Tax Amount and Percentage */
//                    dd($cancel_room_refund_amt,$cancel_room_payable_amt_wo_tax_af,$cancel_room_payable_amt_w_tax_af,
//                        $cancel_stripe_fee_amt_af,$cancel_room_net_amt_af,$government_tax_amt,$service_tax_amt);
                    /* START booking room */
                    $bCancelRoom->status                        = 7;
                    $bCancelRoom->refund_amt                    = $cancel_room_refund_amt;
                    $bCancelRoom->room_payable_amt_wo_tax_af    = $cancel_room_payable_amt_wo_tax_af;
                    $bCancelRoom->government_tax_amt_af         = $government_tax_amt;
                    $bCancelRoom->service_tax_amt_af            = $service_tax_amt;
                    $bCancelRoom->room_payable_amt_w_tax_af     = $cancel_room_payable_amt_w_tax_af;
                    $bCancelRoom->stripe_fee_percent_af         = $cancel_stripe_fee_amt_af;
                    $bCancelRoom->room_net_amt_af               = $cancel_room_net_amt_af;
//                    dd($bCancelRoom);
                    $bRoomUpdateRes                             = $bRoomRepo->update($bCancelRoom);
                    if($bRoomUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /* END booking room */
                    /*
                     * Before updating booking, need to check the cancel room is last room or not
                     * Start checking
                     */
                    $total_price_wo_tax                         = 0.00;
                    $total_price_w_tax                          = 0.00;
                    $total_gst_amt                              = 0.00;
                    $total_service_amt                          = 0.00;
                    $total_discount_amt                         = 0.00;
                    $total_stripe_fee_percent                   = 0.00;
                    $total_stripe_fee_amt                       = 0.00;
                    $total_stripe_net_amt                       = 0.00;
                    $bActiveRoom                                = $bRoomRepo->getActiveBookingRoom($b_id);
                    $bookingStatus                              = 7;
                    $active                                     = 0;
                    if(isset($bActiveRoom) && count($bActiveRoom) > 0){
//                        dd('active');
                        // If the canceled room is not the last room, booking status doesn't change.
                        $bookingStatus                          = $bStatus;
                        $active                                 = 1;
                        foreach($bActiveRoom as $activeRoom){
                            $total_price_wo_tax                += $activeRoom->room_payable_amt_wo_tax;
                            $total_price_w_tax                 += $activeRoom->room_payable_amt_w_tax;
                            $total_gst_amt                     += $activeRoom->government_tax_amt;
                            $total_service_amt                 += $activeRoom->service_tax_amt;
                            $total_discount_amt                += $activeRoom->discount_amt;
                            $total_stripe_fee_percent          += $activeRoom->stripe_fee_percent;
                            $total_stripe_net_amt              += $activeRoom->room_net_amt;
//                            dd($total_stripe_net_amt);
                        }
                        $total_stripe_fee_amt                   = $total_stripe_fee_percent+$this->stripe_fee_cents;
//                        $total_stripe_net_amt                   = $total_price_w_tax-$total_stripe_fee_amt;
                        $total_stripe_net_amt                   = $total_stripe_net_amt-$this->stripe_fee_cents;
                    }
//                    dd('active',$active);
//                    dd('bstatus',$bookingStatus);
//                    dd('no active');
                    /* End checking */
                    /* START booking */
                    $total_cancel_income                        = $booking->total_cancel_income+$cancel_room_net_amt_af;
                    if($bookingStatus == 7){
                        // If the canceled room is the last room, subtract 30 cents from total_cancel_income.
                        $total_cancel_income                    = $total_cancel_income-$this->stripe_fee_cents;
                    }

                    $booking->price_wo_tax                      = $total_price_wo_tax;
                    $booking->price_w_tax                       = $total_price_w_tax;
                    $booking->total_government_tax_amt          = $total_gst_amt;
//                $booking->total_government_tax_percentage   = $total_government_tax_percentage;
                    $booking->total_service_tax_amt             = $total_service_amt;
//                $booking->total_service_tax_percentage      = $total_service_tax_percentage;
                    $booking->total_payable_amt                 = $total_price_w_tax;
                    $booking->total_discount_amt                = $total_discount_amt;
//                $booking->total_discount_percentage         = $total_discount_percentage;
                    $booking->status                            = $bookingStatus;
                    $booking->total_cancel_income               = $total_cancel_income;
                    $booking->total_stripe_fee_percent          = $total_stripe_fee_percent;
                    $booking->total_stripe_fee_amt              = $total_stripe_fee_amt;
                    $booking->total_stripe_net_amt              = $total_stripe_net_amt;
                    $booking->total_vendor_net_amt              = $total_stripe_net_amt+$total_cancel_income;
                    $bookingUpdateRes                           = $this->repo->update($booking);
                    if($bookingUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /* END booking */
                    /* START booking payment */
                    $oldBookPayment                                  = $bPaymentRepo->getObjsByBookingId($b_id);
                    $newBookPayment                                  = new BookingPayment();
                    $newBookPayment->payment_amount_wo_tax           = $cancel_room_payable_amt_w_tax_af;
                    $newBookPayment->payment_amount_w_tax            = $cancel_room_net_amt_af;
                    $newBookPayment->description                     = "";
                    $newBookPayment->booking_id                      = $b_id;
                    $newBookPayment->payment_id                      = $oldBookPayment->payment_id;
                    $newBookPayment->payment_gateway_tax_amt         = $cancel_stripe_fee_amt_af;
                    $newBookPayment->status                          = 7;
                    $newBookPayment->total_government_tax_amt        = $government_tax_amt;
//                $newBookPayment->total_government_tax_percentage = $oldBookPayment->$service_tax_amt;
                    $newBookPayment->total_service_tax_amt           = $service_tax_amt;
//                $newBookPayment->total_service_tax_percentage    = $oldBookPayment->total_service_tax_percentage;
                    $newBookPayment->total_payable_amt               = $cancel_room_payable_amt_w_tax_af;
                    $newBookPayment->payment_reference_no            = null;

                    $bookPaymentResult                               = $bPaymentRepo->create($newBookPayment);
                    if($bookPaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /* END booking payment */
                    /* START Refund */
                    $new_b_payment_id                       = $bookPaymentResult['object']->id;
                    $stripePayment                          = $paymentStripeRepo->getStripePaymentId($b_id);
                    //Get data of stripe payment to calculate refund amount
                    $stripeStatus                           = $stripePayment->status;
                    $stripePaymentId                        = $stripePayment->stripe_payment_id;
                    $stripeId                               = $stripePayment->id;
                    $customer_id                            = $stripePayment->stripe_user_id;
                    $stripe_email                           = $stripePayment->email;
                    $stripe_booking_id                      = $stripePayment->booking_id;
                    $stripePaymentObj                       = new PaymentUtility();
                    $refundResult                           = $stripePaymentObj->refundPayment($customer_id,$cancel_room_refund_amt,$stripePaymentId);
<<<<<<< HEAD
//                    dd('refund res',$refundResult);
//                    $refundResult['aceplusStatusCode']              = ReturnMessage::OK;
//                    $refundResult['stripe']['stripe_user_id']       = 'cus_BY2nbLUyL05Pcn';
//                    $refundResult['stripe']['stripe_payment_id']    = 'ch_1BAwi8Ki85kjRqY0QQzkyEri';
//                    $refundResult['stripe']['stripe_payment_amt']   = 33.0;
//                    $refundResult['stripe']['stripe_balance_transaction'] = 'txn_1BAxjBKi85kjRqY039eQw2Wr';
=======
                    // dd($refundResult);
>>>>>>> heinkhantlin
                    if($refundResult['aceplusStatusCode'] != ReturnMessage::OK) {
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /* END Refund */
                    /* START booking payment stripe */
                    // Retrieve stripe balance
                    $refund_balance_transaction             = $refundResult['stripe']['stripe_balance_transaction'];
                    $stripeBalanceRes                       = $stripePaymentObj->retrieveBalance($refund_balance_transaction);
//                    dd($stripeBalanceRes);
                    if($stripeBalanceRes['aceplusStatusCode'] != ReturnMessage::OK){
                        // shouldn't rollback, write log or do something bcz refundPayment method is already executed.
                        DB::rollback();
                        alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
                        return redirect('/');
                    }
                    $stripe_payment_amt                             = $stripeBalanceRes['stripe']['stripe_payment_amt'];
                    $stripe_payment_fee                             = $stripeBalanceRes['stripe']['stripe_payment_fee'];
                    $stripe_payment_net                             = $stripeBalanceRes['stripe']['stripe_payment_net'];
                    $stripe_balance_transaction                     = $stripeBalanceRes['stripe']['stripe_balance_transaction'];
                    $newStripePayment                               = new BookingPaymentStripe();
                    $newStripePayment->stripe_user_id               = $customer_id;
                    $newStripePayment->stripe_payment_id            = $stripePaymentId;
                    $newStripePayment->stripe_balance_transaction   = $stripe_balance_transaction;
                    $newStripePayment->stripe_payment_amt           = $stripe_payment_amt;
                    $newStripePayment->stripe_payment_net           = $stripe_payment_net;
                    $newStripePayment->stripe_payment_fee           = $stripe_payment_fee;
                    $newStripePayment->status                       = 3; // refund status
                    $newStripePayment->email                        = $stripe_email;
                    $newStripePayment->booking_id                   = $stripe_booking_id;
                    $newStripePayment->booking_payment_id           = $new_b_payment_id;
                    $newStripePaymentRes                            = $paymentStripeRepo->create($newStripePayment);
//                    dd($newStripePaymentRes);
                    if($newStripePaymentRes['aceplusStatusCode'] != ReturnMessage::OK){
                        // shouldn't rollback, write log or do something bcz refundPayment method is already executed.
                        DB::rollback();
                        alert()->warning('Cancellation of room is success.')->persistent('OK');
                    }
                    /* END booking payment stripe */
                    DB::commit();
                    /* START Mail */
                    // If all updating is complete,send mail
                    $email              = $booking->user->email;
                    $hotel_email        = $h_configRepo->getEmailByHotelId($h_id);
                    $hotel_email_str    = $hotel_email->email;
                    $system_email       = "testingmps2017@gmail.com";
                    $emails             = array($email,$hotel_email_str,$system_email);
                    $template           = "frontend.mail.booking_update_mail";
                    $subject            = "Updated your booking check_in and check_out date";
                    $logMessage         = "updated a booking";
                    $mailResult         = Utility::sendMail($template,$emails,$subject,$logMessage);
                    if ($mailResult['aceplusStatusCode'] != ReturnMessage::OK){
                        alert()->warning('Room cancellation is successful.But email could not be send for some reasons.')
                            ->persistent('OK');
                    }
                    alert()->success('Room cancellation is successful.Please check your email.')
                        ->persistent('OK');
                    /* END Mail */
                    return redirect()->action('Frontend\BookingController@booking_list');
                }
                else{
                    dd('second');
                    // second cancellation
                    /*
                     * Update booking room with refund amount 0.00 and status 9.
                     * Update booking.
                     * Update booking payment status if the canceled room is last room.
                     * Update booking payment stripe status if the canceled room is last room.
                     */
                    $bCancelRoom->status                        = 9; // cancel within second cancellation days
                    $bCancelRoom->refund_amt                    = 0.00;
                    $bCancelRoom->room_payable_amt_wo_tax_af    = $cancel_room_payable_amt_wo_tax;
                    $bCancelRoom->government_tax_amt_af         = $cancel_room_gst_amt;
                    $bCancelRoom->service_tax_amt_af            = $cancel_room_service_amt;
                    $bCancelRoom->room_payable_amt_w_tax_af     = $cancel_room_payable_amt_w_tax;
                    $bCancelRoom->stripe_fee_percent_af         = $cancel_room_stripe_fee_percent;
                    $bCancelRoom->room_net_amt_af               = $cancel_room_net_amt;
//                    dd('booking cancel room within second',$bCancelRoom);
                    $bRoomUpdateRes                             = $bRoomRepo->update($bCancelRoom);
                    if($bRoomUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /*
                     * Before updating booking, need to check the cancel room is last room or not
                     * Start checking
                     */
                    $total_price_wo_tax                         = 0.00;
                    $total_price_w_tax                          = 0.00;
                    $total_gst_amt                              = 0.00;
                    $total_service_amt                          = 0.00;
                    $total_discount_amt                         = 0.00;
                    $total_stripe_fee_percent                   = 0.00;
                    $total_stripe_net_amt                       = 0.00;
                    $total_stripe_fee_amt                       = 0.00;
                    $bActiveRoom                                = $bRoomRepo->getActiveBookingRoom($b_id);
                    $bookingStatus                              = 9;
                    $active                                     = 0;
                    if(isset($bActiveRoom) && count($bActiveRoom) > 0){
                        $bookingStatus                          = $bStatus;
                        $active                                 = 1;
                        foreach($bActiveRoom as $activeRoom){
                            $total_price_wo_tax                += $activeRoom->room_payable_amt_wo_tax;
                            $total_price_w_tax                 += $activeRoom->room_payable_amt_w_tax;
                            $total_gst_amt                     += $activeRoom->government_tax_amt;
                            $total_service_amt                 += $activeRoom->service_tax_amt;
                            $total_discount_amt                += $activeRoom->discount_amt;
                            $total_stripe_fee_percent          += $activeRoom->stripe_fee_percent;
                        }
                        $total_stripe_fee_amt                   = $total_stripe_fee_percent+$this->stripe_fee_cents;
//                        $total_stripe_net_amt                   = $total_price_w_tax-$total_stripe_fee_amt;
                    }
                    /* End checking */
                    /* Update Booking */
                    // Calculate total cancel income
                    $total_cancel_income                        = $booking->total_cancel_income+$cancel_room_net_amt;
                    if($bookingStatus == 9){
                        $total_cancel_income                    = $total_cancel_income-$this->stripe_fee_cents;
                    }

                    $booking->price_wo_tax                      = $total_price_wo_tax;
                    $booking->price_w_tax                       = $total_price_w_tax;
                    $booking->total_government_tax_amt          = $total_gst_amt;
//                $booking->total_government_tax_percentage   = $total_government_tax_percentage;
                    $booking->total_service_tax_amt             = $total_service_amt;
//                $booking->total_service_tax_percentage      = $total_service_tax_percentage;
                    $booking->total_payable_amt                 = $total_price_w_tax;
                    $booking->total_discount_amt                = $total_discount_amt;
//                $booking->total_discount_percentage         = $total_discount_percentage;
                    $booking->status                            = $bookingStatus;
                    $booking->total_stripe_fee_percent          = $total_stripe_fee_percent;
                    $booking->total_stripe_fee_amt              = $total_stripe_fee_amt;
                    $booking->total_stripe_net_amt              = $total_stripe_net_amt;
                    $booking->total_cancel_income               = $total_cancel_income;
                    $booking->total_vendor_net_amt              = $total_cancel_income+$total_stripe_net_amt;
//                    dd('booking after cancel room',$booking);
                    $bookingUpdateRes                           = $this->repo->update($booking);
                    if($bookingUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /* START changing status for booking payment */
                    $bPayment                                   = $bPaymentRepo->getObjsByBookingId($b_id);
                    $bPayment->status                           = $bookingStatus;
//                    $bPayment->payment_amount_wo_tax            = $total_price_w_tax;
//                    $bPayment->payment_amount_w_tax             = $total_stripe_net_amt;
//                    $bPayment->payment_gateway_tax_amt          = $total_stripe_fee_amt;
//                    $bPayment->total_government_tax_amt         = $total_gst_amt;
////                $bPayment->total_government_tax_percentage = ;
//                    $bPayment->total_service_tax_amt            = $total_service_amt;
////                $bPayment->total_service_tax_percentage = ;
//                    $bPayment->total_payable_amt                = $total_price_w_tax;
//                    dd('Booking Payment',$bPayment);
                    $bookPaymentResult                          = $bPaymentRepo->update($bPayment);
                    if($bookPaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /* END changing status for booking payment */
                    /* START changing status for booking payment stripe */
                    if(isset($active) && $active == 0){
//                    dd('no active room');
                        $bPaymentStripe                         = $paymentStripeRepo->getStripePaymentIdByBookingId($b_id);
                        $bPaymentStripe->status                 = 4; // cancel status
//                    dd('booking payment stripe',$bPaymentStripe);
                        $bPaymentStripeResult                   = $paymentStripeRepo->update($bPaymentStripe);
                        if($bPaymentStripeResult['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            alert()->error('Cancellation of room is fail.')->persistent('OK');
                        }
                    }
                    /* END changing status for booking payment stripe */

                    DB::commit();
                    // If all updating is complete,send mail
                    $email              = $booking->user->email;
                    $hotel_email        = $h_configRepo->getEmailByHotelId($h_id);
                    $hotel_email_str    = $hotel_email->email;
                    $system_email       = "testingmps2017@gmail.com";
                    $emails             = array($email,$hotel_email_str,$system_email);
                    $template           = "frontend.mail.booking_update_mail";
                    $subject            = "Updated your booking check_in and check_out date";
                    $logMessage         = "updated a booking";
                    $mailResult         = Utility::sendMail($template,$emails,$subject,$logMessage);
                    if ($mailResult['aceplusStatusCode'] != ReturnMessage::OK){
                        alert()->warning('Room cancellation is successful.But email could not be send for some reasons.')
                            ->persistent('OK');
                    }
                    alert()->success('Room cancellation is successful.Please check your email.')
                        ->persistent('OK');
                    return redirect()->action('Frontend\BookingController@booking_list');

                }

            }
            else{
                //don't allow to cancel room
                alert()->warning('You could not cancel your reserved room!')->persistent('OK');
                return redirect()->back();
            }
        }
        catch(\Exception $e){
            //
            dd($e->getMessage(),$e->getLine(),$e->getFile());
            alert()->warning('You could not cancel your reserved room!')->persistent('OK');
            return redirect()->back();
        }
    }


}
