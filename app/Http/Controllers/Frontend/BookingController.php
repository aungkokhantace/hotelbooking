<?php

namespace App\Http\Controllers\Frontend;

use App\Core\Check;
use App\Core\Config\Config;
use App\Core\Config\ConfigRepository;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use App\Payment\PaymentConstance;
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
use Illuminate\Support\Facades\Session;
use PDF;
use Mail;

class BookingController extends Controller
{
    private $repo;
    private $stripe_fee_percent;
    private $stripe_fee_cents;
    public function __construct(BookingRepositoryInterface $repo){
        $this->repo                     = $repo;
        /* Stripe transaction fee */
        $this->stripe_fee_percent       = PaymentConstance::STIRPE_FEE_PERCENT;
        $this->stripe_fee_cents         = PaymentConstance::STRIPE_FEE_FIXED;
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
                    $b->button_status   = "BOOK AGAIN";
                    array_push($booking_cancel,$b);
                }
                if($b->status == 5){
                    $b->status_txt      = "Complete";
                    $b->button_status   = "MANAGE BOOKING";
                }
                if($b->status == 7){
                    $b->status_txt      = "Cancel";
                    $b->button_status   = "BOOK AGAIN";
                }
                if($b->status == 8){
                    $b->status_txt      = "Void";
                    $b->button_status   = "BOOK AGAIN";
                }
                if($b->status == 9){
                    $b->status_txt      = "Cancel";
                    $b->button_status   = "BOOK AGAIN";
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

                $book_rooms = $bRoomRepo->getActiveBookingRoom($b_id);

                $room_count         = count($book_rooms);
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
                // dd($booking->rooms);

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
                        $booking->charge= 'You must pay 50% of total amount.';
                    }
                    else{
                        $booking->charge= 'You must pay 100% of total amount.';
                    }
                }

                /* Booking Request */
                $b_request              = $b_requestRepo->getBookingRequestByBookingId($b_id);

                /* Booking Special Request */
                $communications         = $communicationRepo->getCommunicationByBookingId($b_id);

                /*get Cancel Reason */
                $reasons                = $settingRepo->getCancelReason('REASON');

                return view('frontend.manage_booking')->with('customer',$customer)
                                                      ->with('booking',$booking)
                                                      ->with('hotel',$hotel)
                                                      ->with('reasons',$reasons)
                                                      ->with('b_request',$b_request)
                                                      ->with('communications',$communications);
            }
            else{
                // Unauthorized
                return redirect('bookingList');
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
        try{
            if(!Session::has('customer')){
                return redirect('/');
            }
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
                // $total_room_price           = 0.00;
                $total_extra_bed_price      = 0.00;
                foreach($bRooms as $bRoom){
                    // $total_room_price       += $bRoom->room_payable_amt;
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
            // $booking->total_room_price      = $total_room_price;
    //        $booking->total_extra_bed_price = $total_extra_bed_price;
            $booking->rooms                 = $bRooms; //Add Rooms Array to booking

            /* get booking request to know special request */
            $b_request_arr                  = array();
            $b_request                      = $b_requestRepo->getBookingRequestByBookingId($b_id);
            if($b_request->non_smoking_room == 1){
                array_push($b_request_arr,'Non Smoking Room');
            }
            if($b_request->non_smoking_room == 1){
                array_push($b_request_arr,'Non Smoking Room');
            }
            if($b_request->late_check_in == 1){
                array_push($b_request_arr,'Late Check In');
            }
            if($b_request->early_check_in == 1){
                array_push($b_request_arr,'Early Check In');
            }
            if($b_request->high_floor_room == 1){
                array_push($b_request_arr,'High Floor Room');
            }
            if($b_request->large_bed == 1){
                array_push($b_request_arr,'Large Bed');
            }
            if($b_request->twin_bed == 1){
                array_push($b_request_arr,'Twin Bed');
            }
            if($b_request->quiet_room == 1){
                array_push($b_request_arr,'Quiet Room');
            }
            if($b_request->baby_cot == 1){
                array_push($b_request_arr,'Baby Cot');
            }
            if($b_request->airport_transfer == 1){
                array_push($b_request_arr,'Air Port Transfer');
            }
            if($b_request->private_parking == 1){
                array_push($b_request_arr,'Private Parking');
            }
            if($b_request->booking_taxi == 1){
                array_push($b_request_arr,'Book Taxi');
            }
            if($b_request->booking_tour_guide == 1){
                array_push($b_request_arr,'Request Tour Guide');
            }

            /* Start Print Function */
            $view                           = \View::make('frontend.print_confirmation',compact('booking','hotel','h_config','b_request_arr'));
            $html                           = $view->render();
            $pdf                            = new TCPDF();

            $pdf::SetTitle('Booking Confirmation Preview');
            $pdf::AddPage();
            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::Output('pdf_booking_confirmation.pdf');
            /* End Print Function */
        }catch(\Exception $e){
            //create error log
            $currentUser                        = Utility::getCurrentCustomerID();
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Customer - '.$currentUser.
                ' printed a booking and got error -------'.$e->getMessage(). ' ----- line ' .
                $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::create($date,$message);

            return redirect('/');
        }

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
                     * (2) Change Status for booking and booking rooms
                     * (3) Send Mail
                     */

                    /* START changing status for booking */
                    $booking->status                        = 3;
                    $booking->booking_cancel_reason         = $reason;
                    $result                                 = $this->repo->update($booking);
                    if($result['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        return \Response::json($response);
                    }
                    /* END changing status for booking */
                    /* START changing status for booking room */
                    $bookRooms                              = $bookRoomRepo->getBookingRoomByBookingId($id);
                    foreach($bookRooms as $bRoom){
                        $bRoom->status                      = 3;
                        $bRoomResult                        = $bookRoomRepo->update($bRoom);
                        // dd($bRoomResult);
                        if($bRoomResult['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                    }
                    /* END changing status for booking room */

                    /* Update booking payment status */
                    /* $bPayment                               = $bookPaymentRepo->getObjsByBookingId($id);
                    $bPayment->status                       = 3;
                    $bookPaymentResult                      = $bookPaymentRepo->update($bPayment);
                    if($bookPaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        return \Response::json($response);
                    }*/
                    //if customer cancel the booking status 2(confirm) was successful, then create date and message for cancel booking success log
                    $currentUser = Utility::getCurrentCustomerID(); //get currently logged in customer
                    $date     = date('Y-m-d H:i:s');
                    $message  = '['. $date .'] '. 'info: ' . 'Customer '. $currentUser.' cancelled booking id = '.$booking->booking_no.' with status 2 is successful'. PHP_EOL;
                    LogCustom::create($date,$message);
                    DB::commit();
                    /* START send mail */
                    $user_email                             = $booking->user->email;
                    $hotel                                  = Hotel::find($h_id);
                    $hotel_email                            = $hotel->email;
                    $emails                                 = array($user_email,$hotel_email);
                    $system_email                           = Utility::getSystemAdminMail();

                    if(isset($system_email) && count($system_email) > 0){
                        foreach($system_email as $s_email){
                            array_push($emails,$s_email);
                        }
                    }
                    //Send Mail to Customer,SystemAdmin,HotelAdmin
                    $mailTemplate                           = 'frontend.mail.cancel_mail';
                    $subject                                = 'Booking Cancellation';
                    $logMessage                             = 'update the booking id - '.$id;
                    $returnState                            = Utility::sendMail($mailTemplate,$emails,$subject,$logMessage);

                    if($returnState['aceplusStatusCode'] == ReturnMessage::OK){
                        $response['aceplusStatusCode']      = '200';
                        $response['param']                  = $booking->id;
                    }
                    else{
                        $response['aceplusStatusCode']      = '503';
                        $response['param']                  = $booking->id;
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
                     * (3) Recalculate total amount after refund
                     * (4) Send Mail
                     *
                     * For 2nd condition, if cancellation date is within 2nd cancellation day
                     * (1) No Refund
                     * (2) Change Status
                     * (3) Send Mail
                     */
                    $h_config                                       = $h_configRepo->getObjByID($booking->hotel_id);
                    $first_cancel_days                              = 0;
                    $second_cancel_days                             = 0;
                    if(isset($h_config) && count($h_config) > 0){
                        $first_cancel_days                          = $h_config->first_cancellation_day_count;
                        $second_cancel_days                         = $h_config->second_cancellation_day_count;
                    }
                    $first_cancel_date                              = Carbon::parse($booking->check_in_date)->subDays($first_cancel_days);
                    $second_cancel_date                             = Carbon::parse($booking->check_in_date)->subDays($second_cancel_days);
                    $today_date                                     = Carbon::now();
                    /* For 1st Cancellation Day */
                    if($today_date >= $first_cancel_date && $today_date < $second_cancel_date){
                    //    dd('first cancellation day');
                        /* Refund */
                        $stripePayment                              = $paymentStripeRepo->getStripePaymentId($id);
                        $stripePaymentId                            = '';
                        $stripeEmail                                = '';
                        if(isset($stripePayment) && count($stripePayment) > 0){
                            $stripePaymentId                        = $stripePayment->stripe_payment_id;
                            $stripeId                               = $stripePayment->id;
                            $customer_id                            = $stripePayment->stripe_user_id;
                            $stripeEmail                            = $stripePayment->email;
                        }


                        /* Update to after refund fields */
                        $bRooms                                     = $bookRoomRepo->getBookingRoomByBookingId($id);
                        foreach($bRooms as $bRoom){
                            if($bRoom->status == 2 || $bRoom->status == 5){
                                $r_discount_amt                     = $bRoom->discount_amt;
                                $r_extra_bed_price                  = $bRoom->extra_bed_price;
                                $r_payment_amt_wo_tax               = $bRoom->room_payable_amt_wo_tax;
                                $r_gst_amt                          = $bRoom->government_tax_amt;
                                $r_service_amt                      = $bRoom->service_tax_amt;
                                $r_payment_amt_w_tax                = $bRoom->room_payable_amt_w_tax;
                                $r_stripe_fee_percent               = $bRoom->stripe_fee_percent;
                                $r_net_amt                          = $bRoom->room_net_amt;
                                $refund_amt                         = round($r_payment_amt_w_tax/2,2);

                                // Refund 50% of Payment
                                $stripePaymentObj                   = new PaymentUtility();
                                $refundResult                       = $stripePaymentObj->refundPayment($customer_id,$refund_amt,$stripePaymentId);
                                if($refundResult['aceplusStatusCode'] != ReturnMessage::OK){

                                    return \Response::json($response);
                                }
                                // Retrieve Balance Transaction
                                $stripe_balance_transaction         = $refundResult['stripe']['stripe_balance_transaction'];
                                $balance                            = $stripePaymentObj->retrieveBalance($stripe_balance_transaction);
                                if($balance['aceplusStatusCode'] != ReturnMessage::OK){
                                    // write log or do something

                                    //create Retrieve Balance Transaction error log
                                    $currentUser                        = Utility::getCurrentCustomerID();
                                    $date                               = date("Y-m-d H:i:s");

                                    $message                            = '['. $date .'] '. 'error: ' . 'Customer id - '.$currentUser.' retrieve balance transaction '.$stripe_balance_transaction.' and got error'. PHP_EOL;
                                    LogCustom::create($date,$message);

                                    return \Response::json($response);
                                }
                                $stripe_payment_net_balance         = $balance['stripe']['stripe_payment_net'];
                                $stripe_payment_fee_balance         = $balance['stripe']['stripe_payment_fee'];
                                $stripe_payment_amt_balance         = $balance['stripe']['stripe_payment_amt'];
                                $stripe_payment_id_balance          = $balance['stripe']['stripe_payment_id'];
                                $stripe_balance_transaction_balance = $balance['stripe']['stripe_balance_transaction'];

                                /* Create Booking Payment Stripe */
                                $stripe                             = new BookingPaymentStripe();
                                $stripe->stripe_user_id             = $customer_id;
                                $stripe->stripe_payment_id          = $stripe_payment_id_balance;
                                $stripe->stripe_balance_transaction = $stripe_balance_transaction_balance;
                                $stripe->stripe_payment_net         = $stripe_payment_net_balance;
                                $stripe->stripe_payment_fee         = $stripe_payment_fee_balance;
                                $stripe->stripe_payment_amt         = $stripe_payment_amt_balance;
                                $stripe->email                      = $stripeEmail;
                                $stripe->status                     = 3;
                                $stripe->booking_id                 = $id;
                                $stripeRes                          = $paymentStripeRepo->create($stripe);
                                if($stripeRes['aceplusStatusCode'] != ReturnMessage::OK){
                                    //write log
                                    DB::rollback();
                                    //create Booking Payment Stripe error log
                                    $currentUser                        = Utility::getCurrentCustomerID();
                                    $date                               = date("Y-m-d H:i:s");

                                    $message                            = '['. $date .'] '. 'error: ' . 'Customer id - '.$currentUser.' create booking payment stripe '.$stripe_balance_transaction.' and got error'. PHP_EOL;
                                    LogCustom::create($date,$message);
                                    return \Response::json($response);
                                }

                                /* Create booking payment for refund amt */
                                $newBPayment                                = new BookingPayment();
                                $newBPayment->payment_amount_wo_tax         = $r_payment_amt_wo_tax;
                                $newBPayment->payment_amount_w_tax          = $r_payment_amt_w_tax;
                                $newBPayment->booking_id                    = $id;
                                $newBPayment->payment_gateway_tax_amt       = abs($stripe_payment_fee_balance);
                                $newBPayment->status                        = 7;
                                $newBPayment->total_government_tax_amt      = $r_gst_amt;
                                // $newBPayment->total_government_tax_percentage  = ;
                                $newBPayment->total_service_tax_amt         = $r_service_amt;
                                // $newBPayment->total_service_tax_percentage  =;
                                $newBPayment->total_payable_amt             = $r_payment_amt_wo_tax;
                                $newBPaymentRes                             = $bookPaymentRepo->create($newBPayment);
                                if($newBPaymentRes['aceplusStatusCode'] != ReturnMessage::OK){
                                    DB::rollback();
                                    return \Response::json($response);
                                }

                                /* Update Booking Room */
                                $bRoom->status                      = 7;
                                $bRoom->refund_amt                  = $refund_amt;
                                $bRoom->discount_amt_af             = round($r_discount_amt/2,2);
                                $bRoom->extra_bed_price_af          = round($r_extra_bed_price/2,2);
                                $bRoom->room_payable_amt_wo_tax_af  = round($r_payment_amt_wo_tax/2,2);
                                $bRoom->government_tax_amt_af       = round($r_gst_amt/2,2);
                                $bRoom->service_tax_amt_af          = round($r_service_amt/2,2);
                                // $bRoom->room_payable_amt_w_tax_af   = round($r_payment_amt_w_tax/2,2);
                                // $bRoom->stripe_fee_percent_af       = round($r_stripe_fee_percent/2,2);
                                $bRoom->room_payable_amt_w_tax_af   = abs($stripe_payment_amt_balance);
                                $bRoom->stripe_fee_percent_af       = abs($stripe_payment_fee_balance);
                                $bRoom->room_net_amt_af             = abs($stripe_payment_net_balance);

                                $bRoomRes                           = $bookRoomRepo->update($bRoom);
                                if($bRoomRes['aceplusStatusCode'] != ReturnMessage::OK){
                                    DB::rollback();
                                    return \Response::json($response);
                                }
                            }
                        }
                        /* Calculate total amount after filling refund amt in booking room table */
                        $bookRooms                                  = $bookRoomRepo->getBookingRoomByBookingId($id);
                        $total_price_wo_tax                         = 0.00;
                        $total_price_w_tax                          = 0.00;
                        $total_gst_amt                              = 0.00;
                        $total_service_amt                          = 0.00;
                        $total_payable_amt                          = 0.00;
                        $total_discount_amt                         = 0.00;
                        $total_cancel_income                        = 0.00;
                        $total_stripe_fee_percent                   = 0.00;
                        $total_room_net_amt                         = 0.00;
                        foreach($bookRooms as $bRoom){
                            $total_price_wo_tax                     += $bRoom->room_payable_amt_wo_tax_af;
                            $total_price_w_tax                      += $bRoom->room_payable_amt_w_tax_af;
                            $total_gst_amt                          += $bRoom->government_tax_amt_af;
                            $total_service_amt                      += $bRoom->service_tax_amt_af;
                            $total_discount_amt                     += $bRoom->discount_amt_af;
                            // $total_stripe_fee_percent               += $bRoom->stripe_fee_percent_af;
                            $total_room_net_amt                     += $bRoom->room_net_amt_af;
                        }
                        $total_payable_amt                          = $total_price_w_tax;
                        /*
                        $total_stripe_fee_amt                       = $total_stripe_fee_percent+$this->stripe_fee_cents;
                        $total_stripe_net_amt                       = $total_room_net_amt-$this->stripe_fee_cents;
                        $total_cancel_income                        = $total_stripe_net_amt;
                        $total_vendor_net_amt                       = $total_stripe_net_amt;*/
                        $total_stripe_fee_amt                       = 0.00;
                        $total_stripe_net_amt                       = 0.00;
                        $total_cancel_income                        = 0.00;
                        $total_vendor_net_amt                       = 0.00;

                        /* Calculate stripe fee amout with data from booking payment stripe table */
                        $bPaymentStripes                            = $paymentStripeRepo->getAllBookingPaymentStripeByBookingId($id);
                        foreach($bPaymentStripes as $bStripe){
                            $total_stripe_fee_amt                  += $bStripe->stripe_payment_fee;
                            $total_stripe_net_amt                  += $bStripe->stripe_payment_net;
                            $total_cancel_income                   += $bStripe->stripe_payment_net;
                            $total_vendor_net_amt                  += $bStripe->stripe_payment_net;
                        }
                        $total_stripe_fee_percent                   = $total_stripe_fee_amt-$this->stripe_fee_cents;
                        /* Update Booking */
                        $booking->status                            = 7;
                        $booking->booking_cancel_reason             = $reason;
                        $booking->price_wo_tax                      = $total_price_wo_tax;
                        $booking->price_w_tax                       = $total_price_w_tax;
                        $booking->total_government_tax_amt          = $total_gst_amt;
                        $booking->total_service_tax_amt             = $total_service_amt;
                        $booking->total_payable_amt                 = $total_price_w_tax;
                        $booking->total_discount_amt                = $total_discount_amt;
                        $booking->total_cancel_income               = $total_cancel_income;
                        $booking->total_stripe_fee_percent          = $total_stripe_fee_percent;
                        $booking->total_stripe_fee_amt              = $total_stripe_fee_amt;
                        $booking->total_stripe_net_amt              = $total_stripe_net_amt;
                        $booking->total_vendor_net_amt              = $total_vendor_net_amt;
                        $bookingUpdateRes                           = $this->repo->update($booking);
                        if($bookingUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                        /* Create booking payment for refund amt
                        $oldBPayment                                = $bookPaymentRepo->getObjsByBookingId($id);
                        $newBPayment                                = new BookingPayment();
                        $newBPayment->payment_amount_wo_tax         = $total_price_w_tax;
                        $newBPayment->payment_amount_w_tax          = $total_stripe_net_amt;
                        $newBPayment->booking_id                    = $id;
                        $newBPayment->payment_gateway_tax_amt       = $total_stripe_fee_amt;
                        $newBPayment->status                        = 7;
                        $newBPayment->total_government_tax_amt      = $total_gst_amt;
                        // $newBPayment->total_government_tax_percentage  = ;
                        $newBPayment->total_service_tax_amt         = $total_service_amt;
                        // $newBPayment->total_service_tax_percentage  =;
                        $newBPayment->total_payable_amt             = $total_price_w_tax;
                        $newBPaymentRes                             = $bookPaymentRepo->create($newBPayment);
                        if($newBPaymentRes['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }*/

                        //if customer cancel the booking status 5(complete) was successful, then create date and message for cancel booking success log
                        $currentUser = Utility::getCurrentCustomerID(); //get currently logged in customer
                        $date     = date('Y-m-d H:i:s');
                        $message  = '['. $date .'] '. 'info: ' . 'Customer '. $currentUser.' cancelled booking id = '.$booking->booking_no.' with status 5 is successful'. PHP_EOL;
                        LogCustom::create($date,$message);

                        DB::commit();
                        /* Send Mail */
                        $user_email                                 = $booking->user->email;
                        $hotel                                      = Hotel::find($h_id);
                        $hotel_email                                = $hotel->email;
                        $emails                                     = array($user_email,$hotel_email);
                        $system_email                               = Utility::getSystemAdminMail();
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

                    }
                    /* For 2nd Cancellation Day */
                    else{
                        // dd('second cancellation day');
                        $bookRooms                                      = $bookRoomRepo->getBookingRoomByBookingId($id);
                        foreach($bookRooms as $bRoom){
                            /* Update Booking Room */
                            if($bRoom->status == 2 || $bRoom->status == 5){
                                $bRoom->status                          = 9;
                                $bRoom->refund_amt                      = 0.00;
                                $bRoom->discount_amt_af                 = $bRoom->discount_amt;
                                $bRoom->extra_bed_price_af              = $bRoom->extra_bed_price;
                                $bRoom->room_payable_amt_wo_tax_af      = $bRoom->room_payable_amt_wo_tax;
                                $bRoom->government_tax_amt_af           = $bRoom->government_tax_amt;
                                $bRoom->service_tax_amt_af              = $bRoom->service_tax_amt;
                                $bRoom->room_payable_amt_w_tax_af       = $bRoom->room_payable_amt_w_tax;
                                $bRoom->stripe_fee_percent_af           = $bRoom->stripe_fee_percent;
                                $bRoom->room_net_amt_af                 = $bRoom->room_net_amt;
                                $bRoomRes                               = $bookRoomRepo->update($bRoom);
                                if($bRoomRes['aceplusStatusCode'] != ReturnMessage::OK){
                                    DB::rollback();
                                    return \Response::json($response);
                                }
                            }

                        }
                        /*
                        $bRooms                                         = $bookRoomRepo->getBookingRoomByBookingId($id);
                        $total_price_wo_tax                             = 0.00;
                        $total_price_w_tax                              = 0.00;
                        $total_gst_amt                                  = 0.00;
                        $total_service_amt                              = 0.00;
                        $total_payable_amt                              = 0.00;
                        $total_discount_amt                             = 0.00;
                        $total_cancel_income                            = 0.00;
                        $total_stripe_fee_percent                       = 0.00;
                        $total_room_net_amt                             = 0.00;
                        foreach($bRooms as $bRoom){
                            $total_price_wo_tax                         += $bRoom->room_payable_amt_wo_tax_af;
                            $total_price_w_tax                          += $bRoom->room_payable_amt_w_tax_af;
                            $total_gst_amt                              += $bRoom->government_tax_amt_af;
                            $total_service_amt                          += $bRoom->service_tax_amt_af;
                            $total_discount_amt                         += $bRoom->discount_amt_af;
                            $total_stripe_fee_percent                   += $bRoom->stripe_fee_percent_af;
                            $total_room_net_amt                         += $bRoom->room_net_amt_af;
                        }
                        $total_payable_amt                              = $total_price_w_tax;
                        $total_stripe_fee_amt                           = $total_stripe_fee_percent+$this->stripe_fee_cents;
                        $total_stripe_net_amt                           = $total_price_w_tax-$total_stripe_fee_amt;
                        $total_cancel_income                            = $total_stripe_net_amt;
                        $total_vendor_net_amt                           = $total_stripe_net_amt;*/

                        /* Update Booking */
                        $booking->status                                = 9;
                        $booking->booking_cancel_reason                 = $reason;
                        $booking->total_cancel_income                   = $booking->total_stripe_net_amt;
                        /*
                        $booking->price_wo_tax                          = $total_price_wo_tax;
                        $booking->price_w_tax                           = $total_price_w_tax;
                        $booking->total_government_tax_amt              = $total_gst_amt;
                        $booking->total_service_tax_amt                 = $total_service_amt;
                        $booking->total_payable_amt                     = $total_price_w_tax;
                        $booking->total_discount_amt                    = $total_discount_amt;
                        $booking->total_cancel_income                   = $total_cancel_income;
                        $booking->total_stripe_fee_percent              = $total_stripe_fee_percent;
                        $booking->total_stripe_fee_amt                  = $total_stripe_fee_amt;
                        $booking->total_stripe_net_amt                  = $total_stripe_net_amt;
                        $booking->total_vendor_net_amt                  = $total_vendor_net_amt;
                        */
                        $bookingUpdateRes                               = $this->repo->update($booking);
                        if($bookingUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }

                        //if customer cancel the booking in 2nd cancellation was successful, then create date and message for cancel booking success log
                        $currentUser = Utility::getCurrentCustomerID(); //get currently logged in customer
                        $date     = date('Y-m-d H:i:s');
                        $message  = '['. $date .'] '. 'info: ' . 'Customer '. $currentUser.' cancelled booking id = '.$booking->booking_no.' in second cancellation is successful'. PHP_EOL;
                        LogCustom::create($date,$message);

                        DB::commit();
                        /* START sending email */
                        $user_email                                     = $booking->user->email;
                        $hotel                                          = Hotel::find($h_id);
                        $hotel_email                                    = $hotel->email;
                        $emails                                         = array($user_email,$hotel_email);
                        $system_email                                   = Utility::getSystemAdminMail();
                        if(isset($system_email) && count($system_email) > 0){
                            foreach($system_email as $s_email){
                                array_push($emails,$s_email);
                            }
                        }
                        //Send Mail to Customer,SystemAdmin,HotelAdmin
                        $mailTemplate                                   = 'frontend.mail.cancel_mail';
                        $subject                                        = 'Booking Cancellation';
                        $logMessage                                     = 'update the booking id - '.$id;
                        $returnState                                    = Utility::sendMail($mailTemplate,$emails,$subject,$logMessage);
                        if($returnState['aceplusStatusCode'] == ReturnMessage::OK){
                            $response['aceplusStatusCode']              = '200';
                            $response['param']                          = $booking->id;
                        }
                        else{
                            $response['aceplusStatusCode']              = '503';
                            $response['param']                          = $booking->id;

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

        $bRooms                         = $bRoomRepo->getAllBookingRoomAndRoomByBookingId($b_id);
        $book_rooms                     = $bRoomRepo->getBookingRoomByBookingId($b_id);
        $room_count                     = count($book_rooms);
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
        /*
        $find = array("value='128'","value='129'");
        $replace = array("checked=checked","checked=checked");
        // var_dump($find);
        // $arr = array("<input type='checkbox' value='128'>","<input type='checkbox' value='129'>","<input type='checkbox' value='130'>","!");
        $arr = "<input type='checkbox' value='128'>1 <br>ssssss<br> <input type='checkbox' value='129'>2<br><input type='checkbox' value='130'>3";
        // print_r(str_replace($find,$replace,$arr));
        echo str_replace($find,$replace,$arr);*/
        //comment
        $booking            = Booking::find($id);
        $settingRepo        = new CoreSettingRepository();
        $reasons            = $settingRepo->getCancelReason('REASON');

        return view('frontend.booking_cancel')->with('reasons',$reasons)->with('booking',$booking);
    //    return view('frontend.change_date')->with('booking',$booking);

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
                    // dd($r_available);
                    $r_available_arr            = array();
                    $r_category_arr             = array();

                    if(isset($r_available) && count($r_available) > 0){
                        foreach($r_available as $available){
                            array_push($r_available_arr,$available->id);
                            array_push($r_category_arr,$available->h_room_category_id);
                        }
                    }
                    if(empty($r_available_arr) || $room_id_arr != $r_available_arr){
                        /*
                         * If room_id array from booking room is not same with room_id from available room array,
                         * then new check_in and check_out date can't be change.
                         * So, return error status.
                         */

                         //create error log
                         $currentUser                        = Utility::getCurrentCustomerID();
                         $date                               = date("Y-m-d H:i:s");
                         $error_message                      = "room_id array from booking room is not same with room_id from available room array";
                         $message                            = '['. $date .'] '. 'error: ' . 'Customer - '.$currentUser. ' changed booking dates and got error : '.$error_message. PHP_EOL;

                         LogCustom::create($date,$message);

                        return \Response::json($response);
                    }


                    // Calculate the number of night stay
                    $difference                 = strtotime($check_out) - strtotime($check_in);
                    $nights                     = floor($difference/(60*60*24));

                    // Get Government tax amount from config table
                    $gst_temp                           = $configRepo->getGST();
                    $gst_tax                            = number_format((float)$gst_temp[0]->value,2);

                    // Get Service tax amount
                    $service_tax                        = Utility::getServiceTax($h_id);

                    // Get Room discount
                    $room_with_discount                 = $roomRepo->getRoomWithDiscount($r_category_arr,$r_available_arr);

                    foreach($b_room as $room){
                        foreach($room_with_discount as $room_discount){
                            if($room->room_id == $room_discount->id){
                                $room_discount->added_extra_bed = $room->added_extra_bed;
                            }
                        }
                    }

                    $discount_amount_tmp        = 0.00;
                    $discount_percent_tmp       = 0.00;
                    $total_room_price           = 0.00;
                    $price_wo_tax               = 0.00;
                    $total_gst_amt              = 0.00;
                    $total_service_amt          = 0.00;
                    $price_w_tax                = 0.00;
                    $total_stripe_fee_percent   = 0.00;
                    $total_room_net_amt         = 0.00;
                    $total_discount_amount      = 0.00;
                    $total_discount_percent     = 0.00;
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
                                        round(($r_discount->discount_percent/100)*$r_discount->price,2);
                                    $discount_amount_tmp   += $discount_amount;
                                    $total_discount_amount += $discount_amount;

                                    //Calculate total discount percent
                                    $discount_percent       = $r_discount->discount_type== '%'?$r_discount->discount_percent:
                                        round(($discount_amount/$r_discount->price)*100,2);
                                    $discount_percent_tmp  += $discount_percent;
                                    $total_discount_percent+= $discount_percent;

                                    //Calculate room price
                                    $room_price_wo_tax      = ($r_discount->price-$discount_amount)+$extra_bed_price;
                                    $total_room_price      += $room_price_wo_tax;
                                    $price_wo_tax          += $room_price_wo_tax;
                                }
                                else{
                                    $room_price_wo_tax      = $r_discount->price+$extra_bed_price;
                                    $total_room_price      += $room_price_wo_tax;
                                    $price_wo_tax          += $room_price_wo_tax;
                                }
                                $next_date = date("Y-m-d", strtotime("1 day", strtotime($next_date)));

                            }

                            // Calculate government tax amount
                            $gst_tax_amount                                 = round(($gst_tax / 100) * $total_room_price,2);
                            $total_gst_amt                                 += $gst_tax_amount;

                            // Calculate service tax amount
                            $service_tax_amount                             = round(($service_tax / 100) * $total_room_price,2);
                            $total_service_amt                             += $service_tax_amount;

                            // Calculate room price with tax
                            $room_price_w_tax                               = $total_room_price+$gst_tax_amount+$service_tax_amount;
                            $price_w_tax                                   += $room_price_w_tax;

                            // Calculate stripe fee only with percent 2.9%
                            $room_stripe_fee_percent                        = round($room_price_w_tax*$this->stripe_fee_percent,2);
                            $total_stripe_fee_percent                      += $room_stripe_fee_percent;

                            // Calculate room net amount
                            $room_net_amount                                = round($room_price_w_tax-$room_stripe_fee_percent,2);
                            $total_room_net_amt                            += $room_net_amount;

                            //Create temp array
                            $discount_temp_arr['room_id']                   = $r_discount->id;
                            $discount_temp_arr['discount_amt']              = $discount_amount_tmp;
                            $discount_temp_arr['room_payable_amt_wo_tax']   = $total_room_price;
                            $discount_temp_arr['gst']                       = $gst_tax_amount;
                            $discount_temp_arr['service']                   = $service_tax_amount;
                            $discount_temp_arr['room_payable_amt_w_tax']    = $room_price_w_tax;
                            $discount_temp_arr['room_price']                = $r_discount->price;
                            $discount_temp_arr['extra_bed_price']           = $extra_bed_price*$nights;
                            $discount_temp_arr['stripe_fee_percent']        = $room_stripe_fee_percent;
                            $discount_temp_arr['room_net_amt']              = $room_net_amount;
                            array_push($room_discount_arr,$discount_temp_arr);
                            $discount_temp_arr                              = array();
                            $discount_amount_tmp                            = 0.00;
                            $discount_percent_tmp                           = 0.00;
                            $total_room_price                               = 0.00;
                        }
                    }

                    // Calculate Stripe Fee Amount
                    $total_stripe_fee_amt                       = $total_stripe_fee_percent+$this->stripe_fee_cents;
                    $total_room_net_amt                         = $total_room_net_amt-$this->stripe_fee_cents;
                    $total_vendor_amt                           = $total_room_net_amt;
                    DB::beginTransaction();
                    //Update Booking
                    $booking->check_in_date                     = $new_check_in;
                    $booking->check_out_date                    = $new_check_out;
                    $booking->price_wo_tax                      = $price_wo_tax;
                    $booking->price_w_tax                       = $price_w_tax;
                    $booking->total_government_tax_amt          = $total_gst_amt;
                    // $booking->total_government_tax_percentage   = $total_government_tax_percentage;
                    $booking->total_service_tax_amt             = $total_service_amt;
                    // $booking->total_service_tax_percentage      = $total_service_tax_percentage;
                    $booking->total_payable_amt                 = $price_w_tax;
                    $booking->total_discount_amt                = $total_discount_amount;
                    // $booking->total_discount_percentage         = $total_discount_percent;
                    /*
                    $booking->total_stripe_fee_percent          = $total_stripe_fee_percent;
                    $booking->total_stripe_fee_amt              = $total_stripe_fee_amt;
                    $booking->total_stripe_net_amt              = $total_room_net_amt;
                    $booking->total_vendor_net_amt              = $total_vendor_amt;*/
                    $booking->total_stripe_fee_percent          = 0.00;
                    $booking->total_stripe_fee_amt              = 0.00;
                    $booking->total_stripe_net_amt              = 0.00;
                    $booking->total_vendor_net_amt              = 0.00;
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
                                $room->room_payable_amt_wo_tax  = $discountValue['room_payable_amt_wo_tax'];
                                $room->extra_bed_price          = $discountValue['extra_bed_price'];
                                $room->government_tax_amt       = $discountValue['gst'];
                                $room->service_tax_amt          = $discountValue['service'];
                                $room->room_payable_amt_w_tax   = $discountValue['room_payable_amt_w_tax'];
                                $room->stripe_fee_percent       = $discountValue['stripe_fee_percent'];
                                $room->room_net_amt             = $discountValue['room_net_amt'];

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
                    /*
                    $b_payment                                  = $b_paymentRepo->getObjsByBookingId($b_id);
                    $b_payment->payment_amount_wo_tax           = $price_w_tax;
                    $b_payment->payment_amount_w_tax            = $total_room_net_amt;
                    $b_payment->payment_gateway_tax_amt         = $total_stripe_fee_amt;
                    $b_payment->total_government_tax_amt        = $total_gst_amt;
                    // $b_payment->total_government_tax_percentage = $total_government_tax_percentage;
                    $b_payment->total_service_tax_amt           = $total_service_amt;
                    // $b_payment->total_service_tax_percentage    = $total_service_tax_percentage;
                    $b_payment->total_payable_amt               = $price_w_tax;
                    $b_payment_update_res                       = $b_paymentRepo->update($b_payment);
                    if($b_payment_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        return \Response::json($response);
                    }*/

                    $b_payment                                  = $b_paymentRepo->getObjsByBookingId($b_id);
                    $b_payment->payment_amount_wo_tax           = $price_w_tax;
                    $b_payment->payment_amount_w_tax            = 0.00;
                    $b_payment->payment_gateway_tax_amt         = 0.00;
                    $b_payment->total_government_tax_amt        = $total_gst_amt;
                    // $b_payment->total_government_tax_percentage = $total_government_tax_percentage;
                    $b_payment->total_service_tax_amt           = $total_service_amt;
                    // $b_payment->total_service_tax_percentage    = $total_service_tax_percentage;
                    $b_payment->total_payable_amt               = 0.00;
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
                    $h_config                   = $h_configRepo->getConfigByHotel($h_id);

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
                        $stripe_capture_payment = $paymentObj->capturePayment($stripe_user_id,$price_w_tax);
                        // $stripe_capture_payment['aceplusStatusCode'] = ReturnMessage::OK;
                        // $stripe_capture_payment['stripe']['stripe_payment_id'] = "ch_1BBxegKi85kjRqY0uO6Rz2yy";
                        // $stripe_capture_payment['stripe']['stripe_payment_amt'] = 160.6;
                        // $stripe_capture_payment['stripe']['stripe_balance_transaction'] = "txn_1BBxegKi85kjRqY0FUFt4rdO";

                        if($stripe_capture_payment['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                        // Get card brand and card type
                        $stripe_card_brand      = $stripe_capture_payment['stripe']['card_brand'];
                        $stripe_card_type       = $stripe_capture_payment['stripe']['card_type'];
                        // Get Stripe Balance Transaction
                        $stripe_balance_transaction                 = $stripe_capture_payment['stripe']['stripe_balance_transaction'];
                        $stripeBalanceRes                           = $paymentObj->retrieveBalance($stripe_balance_transaction);

                        if($stripeBalanceRes['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                        $stripe_payment->stripe_payment_id          = $stripeBalanceRes['stripe']['stripe_payment_id'];
                        $stripe_payment->stripe_balance_transaction = $stripeBalanceRes['stripe']['stripe_balance_transaction'];
                        $stripe_payment->stripe_payment_amt         = $stripeBalanceRes['stripe']['stripe_payment_amt'];
                        $stripe_payment->stripe_payment_fee         = $stripeBalanceRes['stripe']['stripe_payment_fee'];
                        $stripe_payment->stripe_payment_net         = $stripeBalanceRes['stripe']['stripe_payment_net'];
                        $stripe_payment->status                     = 2;
                        $stripe_payment_update_res                  = $stripeRepo->update($stripe_payment);
                        if($stripe_payment_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                        /* Payment is complete. So, we need to change status of booking, booking_room, booking_payment.*/
                        // Update status of Booking Payment
                        $b_payment->payment_amount_w_tax            = $stripeBalanceRes['stripe']['stripe_payment_net'];
                        $b_payment->payment_gateway_tax_amt         = $stripeBalanceRes['stripe']['stripe_payment_fee'];
                        $b_payment->total_payable_amt               = $stripeBalanceRes['stripe']['stripe_payment_amt'];
                        $b_payment->status                          = 5;
                        $b_payment_update_res                       = $b_paymentRepo->update($b_payment);
                        if($b_payment_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            return \Response::json($response);
                        }
                        // Update status of Booking Room
                        foreach($b_room as $room){
                            $room->status                           = 5;
                            $b_room_update_res                      = $b_roomRepo->update($room);
                            if($b_room_update_res['aceplusStatusCode'] != ReturnMessage::OK){
                                DB::rollback();
                                return \Response::json($response);
                            }
                        }
                        //Update status of Booking
                        $booking->status                            = 5;
                        $booking->total_stripe_fee_percent          = $stripeBalanceRes['stripe']['stripe_payment_fee']-$this->stripe_fee_cents;
                        $booking->stripe_fee_default_cent           = $this->stripe_fee_cents;
                        $booking->total_stripe_fee_amt              = $stripeBalanceRes['stripe']['stripe_payment_fee'];
                        $booking->total_stripe_net_amt              = $stripeBalanceRes['stripe']['stripe_payment_net'];
                        $booking->total_vendor_net_amt              = $stripeBalanceRes['stripe']['stripe_payment_net'];
                        $booking->card_brand                        = $stripe_card_brand;
                        $booking->card_type                         = $stripe_card_type;
                        $booking_update_res                         = $this->repo->update($booking);
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
                    //create change dates error log
                    $currentUser                        = Utility::getCurrentCustomerID();
                    $date                               = date("Y-m-d H:i:s");
                    $errorMessage                       = "booking status is not 2(confirm) and user is not allowed to change dates";

                    $message                            = '['. $date .'] '. 'error: ' . 'Customer id - '.$currentUser.
                        ' updated booking check_in and check_out date and got error : '.$errorMessage. PHP_EOL;
                    LogCustom::create($date,$message);

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
            $cancel_room_payable_amt_wo_tax     = $bCancelRoom->room_payable_amt_wo_tax;
            $cancel_room_payable_amt_w_tax      = $bCancelRoom->room_payable_amt_w_tax;
            $cancel_room_price                  = $bCancelRoom->room_price_per_night;
            $cancel_room_discount_amt           = $bCancelRoom->discount_amt;
            $cancel_room_discount_percent       = number_format(($cancel_room_discount_amt/$cancel_room_price)*100,2);
            $cancel_room_added_extra_bed        = $bCancelRoom->added_extra_bed;
            $cancel_room_extra_bed_price        = $bCancelRoom->extra_bed_price;
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
                 * (2) Change status 3 for booking_payment
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
                    }
                    $total_stripe_fee_amt                   = $total_stripe_fee_percent+$this->stripe_fee_cents;
                    $total_stripe_net_amt                   = $total_price_w_tax-$total_stripe_fee_amt;
                }
                /* End checking */
                /* Update Booking */
                $booking->price_wo_tax                      = $total_price_wo_tax;
                $booking->price_w_tax                       = $total_price_w_tax;
                $booking->total_government_tax_amt          = $total_gst_amt;
                // $booking->total_government_tax_percentage   = $total_government_tax_percentage;
                $booking->total_service_tax_amt             = $total_service_amt;
                // $booking->total_service_tax_percentage      = $total_service_tax_percentage;
                $booking->total_payable_amt                 = $total_price_w_tax;
                $booking->total_discount_amt                = $total_discount_amt;
                // $booking->total_discount_percentage         = $total_discount_percentage;
                $booking->status                            = $bookingStatus;
                $booking->total_stripe_fee_percent          = $total_stripe_fee_percent;
                $booking->total_stripe_fee_amt              = $total_stripe_fee_amt;
                $booking->total_stripe_net_amt              = $total_stripe_net_amt;
                $booking->total_vendor_net_amt              = $total_stripe_net_amt;
                $bookingUpdateRes                           = $this->repo->update($booking);
                if($bookingUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->error('Cancellation of room is fail.')->persistent('OK');
                }
                /* START changing status for booking payment */
                $bPayment                           = $bPaymentRepo->getObjsByBookingId($b_id);
                // $bPayment->status                   = $bookingStatus;
                $bPayment->payment_amount_wo_tax    = $total_price_w_tax;
                $bPayment->payment_amount_w_tax     = $total_stripe_net_amt;
                $bPayment->payment_gateway_tax_amt  = $total_stripe_fee_amt;
                $bPayment->total_government_tax_amt = $total_gst_amt;
                // $bPayment->total_government_tax_percentage = ;
                $bPayment->total_service_tax_amt    = $total_service_amt;
                // $bPayment->total_service_tax_percentage = ;
                $bPayment->total_payable_amt        = $total_price_w_tax;
                $bookPaymentResult                  = $bPaymentRepo->update($bPayment);
                if($bookPaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->error('Cancellation of room is fail.')->persistent('OK');
                }
                /* END changing status for booking payment */

                //if customer cancel room with status 2 was successful, then create date and message for cancel booking success log
                $currentUser = Utility::getCurrentCustomerID(); //get currently logged in customer
                $date     = date('Y-m-d H:i:s');
                $message  = '['. $date .'] '. 'info: ' . 'Customer '. $currentUser.' cancelled booking_room id = '.$bCancelRoom->id.' with status 2 is successful'. PHP_EOL;
                LogCustom::create($date,$message);

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
                $h_config                                       = $h_configRepo->getObjByID($h_id);
                $first_cancel_days                              = 0;
                $second_cancel_days                             = 0;
                if(isset($h_config) && count($h_config) > 0){
                    $first_cancel_days                          = $h_config->first_cancellation_day_count;
                    $second_cancel_days                         = $h_config->second_cancellation_day_count;
                }

                $first_cancel_date                              = Carbon::parse($booking->check_in_date)->subDays($first_cancel_days);
                $second_cancel_date                             = Carbon::parse($booking->check_in_date)->subDays($second_cancel_days);
                $today_date                                     = Carbon::now();
                if($today_date >= $first_cancel_date && $today_date < $second_cancel_date){
                    // dd('first');
                    // first cancellation
                    // refund 50% of room payable amount with tax
                    $cancel_room_refund_amt                     = round($cancel_room_payable_amt_w_tax/2,2);
                    // Calculate discount amount
                    $cancel_room_discount_amt_af                = round($cancel_room_discount_amt/2,2);
                    // Calculate extra_bed_price
                    $cancel_room_extra_bed_price_af             = $cancel_room_added_extra_bed == 1? round($cancel_room_extra_bed_price/2,2) : 0.00;
                    $cancel_room_payable_amt_wo_tax_af          = round($cancel_room_payable_amt_wo_tax/2,2);
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
                    $cancel_room_payable_amt_w_tax_af           = $cancel_room_payable_amt_wo_tax_af+$government_tax_amt+$service_tax_amt;
                    $cancel_stripe_fee_amt_af                   = round($cancel_room_payable_amt_w_tax_af*$this->stripe_fee_percent,2);
                    $cancel_room_net_amt_af                     = $cancel_room_payable_amt_w_tax_af-$cancel_stripe_fee_amt_af;
                    /* End Calculating Total Service Tax Amount and Percentage */

                    /* START Refund Operation */
                    $stripePayment                              = $paymentStripeRepo->getStripePaymentId($b_id);
                    //Get data of stripe payment to calculate refund amount
                    $stripeStatus                               = $stripePayment->status;
                    $stripePaymentId                            = $stripePayment->stripe_payment_id;
                    $stripeId                                   = $stripePayment->id;
                    $customer_id                                = $stripePayment->stripe_user_id;
                    $stripe_email                               = $stripePayment->email;
                    $stripe_booking_id                          = $stripePayment->booking_id;
                    $stripePaymentObj                           = new PaymentUtility();
                    $refundResult                               = $stripePaymentObj->refundPayment($customer_id,$cancel_room_refund_amt,$stripePaymentId);
                    if($refundResult['aceplusStatusCode'] != ReturnMessage::OK) {
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /* END Refund Operation */

                    /* START retrieve balance transaction */
                    $refund_balance_transaction                 = $refundResult['stripe']['stripe_balance_transaction'];
                    $stripeBalanceRes                           = $stripePaymentObj->retrieveBalance($refund_balance_transaction);
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
                    $stripe_blanace_payment_id                      = $stripeBalanceRes['stripe']['stripe_payment_id'];
                    /* END retrieve balance transaction */

                    /* START Booking Payment */

                    // $test = abs($stripe_payment_amt);
                    // $te = $cancel_room_payable_amt_w_tax - $test;
                    // dd($test);

                    $newBookPayment                                 = new BookingPayment();
                    $newBookPayment->payment_amount_wo_tax          = abs($stripe_payment_amt);
                    $newBookPayment->payment_amount_w_tax           = abs($stripe_payment_net);
                    $newBookPayment->description                    = "";
                    $newBookPayment->booking_id                     = $b_id;
                    $newBookPayment->payment_gateway_tax_amt        = abs($stripe_payment_fee);
                    $newBookPayment->status                         = 7;
                    $newBookPayment->total_government_tax_amt       = $government_tax_amt;
//                $newBookPayment->total_government_tax_percentage = $oldBookPayment->$service_tax_amt;
                    $newBookPayment->total_service_tax_amt          = $service_tax_amt;
//                $newBookPayment->total_service_tax_percentage    = $oldBookPayment->total_service_tax_percentage;
                    $newBookPayment->total_payable_amt              = abs($stripe_payment_amt);
                    $newBookPayment->payment_reference_no           = null;
                    $bookPaymentResult                              = $bPaymentRepo->create($newBookPayment);
                    if($bookPaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    $new_b_payment_id                               = $bookPaymentResult['object']->id;
                    /* END Booking Payment */

                    /* START Booking Payment Stripe */
                    $newStripePayment                               = new BookingPaymentStripe();
                    $newStripePayment->stripe_user_id               = $customer_id;
                    $newStripePayment->stripe_payment_id            = $stripe_blanace_payment_id;
                    $newStripePayment->stripe_balance_transaction   = $stripe_balance_transaction;
                    $newStripePayment->stripe_payment_amt           = $stripe_payment_amt;
                    $newStripePayment->stripe_payment_net           = $stripe_payment_net;
                    $newStripePayment->stripe_payment_fee           = $stripe_payment_fee;
                    $newStripePayment->status                       = 3; // refund status
                    $newStripePayment->email                        = $stripe_email;
                    $newStripePayment->booking_id                   = $stripe_booking_id;
                    $newStripePayment->booking_payment_id           = $new_b_payment_id;
                    $newStripePaymentRes                            = $paymentStripeRepo->create($newStripePayment);
                    if($newStripePaymentRes['aceplusStatusCode'] != ReturnMessage::OK){
                        // shouldn't rollback, write log or do something bcz refundPayment method is already executed.
                        DB::rollback();

                        //create Booking Payment Stripe error log
                        $currentUser                        = Utility::getCurrentCustomerID();
                        $date                               = date("Y-m-d H:i:s");

                        $message                            = '['. $date .'] '. 'error: ' . 'Customer id - '.$currentUser.' start booking payment stripe '.$stripe_balance_transaction.' and got error'. PHP_EOL;
                        LogCustom::create($date,$message);

                        alert()->warning('Cancellation of room is success.')->persistent('OK');
                    }
                    /* END Booking Payment Stripe */

                    /* START booking room */
                    $bCancelRoom->status                            = 7;
                    $bCancelRoom->refund_amt                        = $cancel_room_refund_amt;
                    $bCancelRoom->discount_amt_af                   = $cancel_room_discount_amt_af;
                    $bCancelRoom->extra_bed_price_af                = $cancel_room_extra_bed_price_af;
                    $bCancelRoom->room_payable_amt_wo_tax_af        = $cancel_room_payable_amt_wo_tax_af;
                    $bCancelRoom->government_tax_amt_af             = $government_tax_amt;
                    $bCancelRoom->service_tax_amt_af                = $service_tax_amt;
                    $bCancelRoom->room_payable_amt_w_tax_af         = $cancel_room_payable_amt_w_tax_af;
                    $bCancelRoom->stripe_fee_percent_af             = abs($stripe_payment_fee);
                    $bCancelRoom->room_net_amt_af                   = abs($stripe_payment_net);
                    $bRoomUpdateRes                                 = $bRoomRepo->update($bCancelRoom);
                    if($bRoomUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /* END booking room */
                    /*
                     * Before updating booking, need to check the cancel room is last room or not
                     * Start checking
                     */
                    $total_price_wo_tax                             = 0.00;
                    $total_price_w_tax                              = 0.00;
                    $total_gst_amt                                  = 0.00;
                    $total_service_amt                              = 0.00;
                    $total_discount_amt                             = 0.00;
                    $total_stripe_fee_percent                       = 0.00;
                    $total_stripe_fee_amt                           = 0.00;
                    $total_stripe_net_amt                           = 0.00;

                    $bActiveRoom                                    = $bRoomRepo->getActiveBookingRoom($b_id);
                    $bookingStatus                                  = 7;
                    $active                                         = 0;
                    if(isset($bActiveRoom) && count($bActiveRoom) > 0){
                        // If the canceled room is not the last room, booking status doesn't change.
                        $bookingStatus                              = $bStatus;
                        $active                                     = 1;
                    }
                    /* End checking */
                    /* START */
                    $allBookingRoom                                 = $bRoomRepo->getBookingRoomByBookingId($b_id);
                    if(isset($allBookingRoom) && count($allBookingRoom) > 0){
                        foreach($allBookingRoom as $bookingRoom){

                            switch($bookingRoom->status){
                                case 2:
                                    $total_price_wo_tax             += $bookingRoom->room_payable_amt_wo_tax;
                                    $total_price_w_tax              += $bookingRoom->room_payable_amt_w_tax;
                                    $total_gst_amt                  += $bookingRoom->government_tax_amt;
                                    $total_service_amt              += $bookingRoom->service_tax_amt;
                                    $total_discount_amt             += $bookingRoom->discount_amt;
                                    // $total_stripe_fee_percent       += $bookingRoom->stripe_fee_percent;
                                    // $total_stripe_net_amt           += $bookingRoom->room_net_amt;
                                    break;
                                case 5:
                                    $total_price_wo_tax             += $bookingRoom->room_payable_amt_wo_tax;
                                    $total_price_w_tax              += $bookingRoom->room_payable_amt_w_tax;
                                    $total_gst_amt                  += $bookingRoom->government_tax_amt;
                                    $total_service_amt              += $bookingRoom->service_tax_amt;
                                    $total_discount_amt             += $bookingRoom->discount_amt;
                                    // $total_stripe_fee_percent       += $bookingRoom->stripe_fee_percent;
                                    // $total_stripe_net_amt           += $bookingRoom->room_net_amt;
                                    break;
                                case 7:
                                    $total_price_wo_tax             += $bookingRoom->room_payable_amt_wo_tax_af;
                                    $total_price_w_tax              += $bookingRoom->room_payable_amt_w_tax_af;
                                    $total_gst_amt                  += $bookingRoom->government_tax_amt_af;
                                    $total_service_amt              += $bookingRoom->service_tax_amt_af;
                                    $total_discount_amt             += $bookingRoom->discount_amt_af;
                                    // $total_stripe_fee_percent       += $bookingRoom->stripe_fee_percent_af;
                                    // $total_stripe_net_amt           += $bookingRoom->room_net_amt_af;
                                    break;
                                case 9:
                                    $total_price_wo_tax             += $bookingRoom->room_payable_amt_wo_tax_af;
                                    $total_price_w_tax              += $bookingRoom->room_payable_amt_w_tax_af;
                                    $total_gst_amt                  += $bookingRoom->government_tax_amt_af;
                                    $total_service_amt              += $bookingRoom->service_tax_amt_af;
                                    $total_discount_amt             += $bookingRoom->discount_amt_af;
                                    // $total_stripe_fee_percent       += $bookingRoom->stripe_fee_percent_af;
                                    // $total_stripe_net_amt           += $bookingRoom->room_net_amt_af;
                                    break;
                                default : break;
                            }
                        }
                        // $total_stripe_fee_amt                       = $total_stripe_fee_percent+$this->stripe_fee_cents;
                        // $total_stripe_net_amt                       = $total_stripe_net_amt-$this->stripe_fee_cents;
                    }
                    /* END */

                    /* START booking */
                    $total_cancel_income                            = $booking->total_cancel_income+$cancel_room_net_amt_af;
                    if($active < 1){
                        // If the canceled room is the last room, subtract 30 cents from total_cancel_income.
                        $total_cancel_income                        = $total_cancel_income-$this->stripe_fee_cents;
                    }

                    /* Recalculate total stripe fee amt, net amt and fee percent with data from booking payment stripe */
                    $bPaymentStripes                                = $paymentStripeRepo->getAllBookingPaymentStripeByBookingId($b_id);
                    foreach($bPaymentStripes as $bStripe){
                        $total_stripe_fee_amt                      += $bStripe->stripe_payment_fee;
                        $total_stripe_net_amt                      += $bStripe->stripe_payment_net;

                    }
                    $total_stripe_fee_percent                       = $total_stripe_fee_amt-$this->stripe_fee_cents;

                    $booking->price_wo_tax                          = $total_price_wo_tax;
                    $booking->price_w_tax                           = $total_price_w_tax;
                    $booking->total_government_tax_amt              = $total_gst_amt;
//                $booking->total_government_tax_percentage     = $total_government_tax_percentage;
                    $booking->total_service_tax_amt                 = $total_service_amt;
//                $booking->total_service_tax_percentage        = $total_service_tax_percentage;
                    $booking->total_payable_amt                     = $total_price_w_tax;
                    $booking->total_discount_amt                    = $total_discount_amt;
//                $booking->total_discount_percentage           = $total_discount_percentage;
                    $booking->status                                = $bookingStatus;
                    $booking->total_cancel_income                   = $total_cancel_income;
                    $booking->total_stripe_fee_percent              = $total_stripe_fee_percent;
                    $booking->total_stripe_fee_amt                  = $total_stripe_fee_amt;
                    $booking->total_stripe_net_amt                  = $total_stripe_net_amt;
                    $booking->total_vendor_net_amt                  = $total_stripe_net_amt;
                    $bookingUpdateRes                               = $this->repo->update($booking);
                    if($bookingUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /* END booking */

                    //if customer cancel room with status 5 was successful, then create date and message for cancel booking success log
                    $currentUser = Utility::getCurrentCustomerID(); //get currently logged in customer
                    $date     = date('Y-m-d H:i:s');
                    $message  = '['. $date .'] '. 'info: ' . 'Customer '. $currentUser.' cancelled booking_room id = '.$bCancelRoom->id.' with status 5 is successful'. PHP_EOL;
                    LogCustom::create($date,$message);

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
                    // dd('second');
                    /*
                     * Update booking room with refund amount 0.00 and status 9.
                     * Update booking.
                     * Update booking payment status if the canceled room is last room.
                     */
                    $bCancelRoom->status                        = 9; // cancel within second cancellation days
                    $bCancelRoom->refund_amt                    = 0.00;
                    $bCancelRoom->discount_amt_af               = $cancel_room_discount_amt;
                    $bCancelRoom->extra_bed_price_af            = $cancel_room_extra_bed_price;
                    $bCancelRoom->room_payable_amt_wo_tax_af    = $cancel_room_payable_amt_wo_tax;
                    $bCancelRoom->government_tax_amt_af         = $cancel_room_gst_amt;
                    $bCancelRoom->service_tax_amt_af            = $cancel_room_service_amt;
                    $bCancelRoom->room_payable_amt_w_tax_af     = $cancel_room_payable_amt_w_tax;
                    $bCancelRoom->stripe_fee_percent_af         = $cancel_room_stripe_fee_percent;
                    $bCancelRoom->room_net_amt_af               = $cancel_room_net_amt;
                //    dd('booking cancel room within second',$bCancelRoom);
                    $bRoomUpdateRes                             = $bRoomRepo->update($bCancelRoom);
                    if($bRoomUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }
                    /*
                     * Before updating booking, need to check the cancel room is last room or not
                     * Start checking
                     */
                    $total_price_wo_tax                             = 0.00;
                    $total_price_w_tax                              = 0.00;
                    $total_gst_amt                                  = 0.00;
                    $total_service_amt                              = 0.00;
                    $total_discount_amt                             = 0.00;
                    $total_stripe_fee_percent                       = 0.00;
                    $total_stripe_net_amt                           = 0.00;
                    $total_stripe_fee_amt                           = 0.00;
                    $bActiveRoom                                    = $bRoomRepo->getActiveBookingRoom($b_id);
                    $bookingStatus                                  = 9;
                    $active                                         = 0;
                    if(isset($bActiveRoom) && count($bActiveRoom) > 0){
//                        dd('active');
                        // If the canceled room is not the last room, booking status doesn't change.
                        $bookingStatus                              = $bStatus;
                        $active                                     = 1;
                    }
                    /* End checking */

                    /* Update Booking */
                    // Calculate total cancel income
                    $cancel_room_net_amt_af                         = $bRoomUpdateRes['object']->room_net_amt_af;
                    $total_cancel_income                            = $booking->total_cancel_income+$cancel_room_net_amt_af;
                    if($active < 1){
                        // If the canceled room is the last room, subtract 30 cents from total_cancel_income.
                        $total_cancel_income                        = $total_cancel_income-$this->stripe_fee_cents;
                    }
                    /*
                    $booking->price_wo_tax                          = $total_price_wo_tax;
                    $booking->price_w_tax                           = $total_price_w_tax;
                    $booking->total_government_tax_amt              = $total_gst_amt;
//                $booking->total_government_tax_percentage     = $total_government_tax_percentage;
                    $booking->total_service_tax_amt                 = $total_service_amt;
//                $booking->total_service_tax_percentage        = $total_service_tax_percentage;
                    $booking->total_payable_amt                     = $total_price_w_tax;
                    $booking->total_discount_amt                    = $total_discount_amt;
//                $booking->total_discount_percentage           = $total_discount_percentage;
                    $booking->status                                = $bookingStatus;
                    $booking->total_cancel_income                   = $total_cancel_income;
                    $booking->total_stripe_fee_percent              = $total_stripe_fee_percent;
                    $booking->total_stripe_fee_amt                  = $total_stripe_fee_amt;
                    $booking->total_stripe_net_amt                  = $total_stripe_net_amt;
                    $booking->total_vendor_net_amt                  = $total_stripe_net_amt;
                    */
                    $booking->status                                = $bookingStatus;
                    $booking->total_cancel_income                   = $total_cancel_income;
                    $bookingUpdateRes                               = $this->repo->update($booking);
                    if($bookingUpdateRes['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->error('Cancellation of room is fail.')->persistent('OK');
                    }

                    //if customer cancel room in second cancellation was successful, then create date and message for cancel booking success log
                    $currentUser = Utility::getCurrentCustomerID(); //get currently logged in customer
                    $date     = date('Y-m-d H:i:s');
                    $message  = '['. $date .'] '. 'info: ' . 'Customer '. $currentUser.' cancelled booking_room id = '.$bCancelRoom->id.' in second cancellation is successful'. PHP_EOL;
                    LogCustom::create($date,$message);

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
                //create cancel room error log
                    $currentUser                        = Utility::getCurrentCustomerID();
                    $date                               = date("Y-m-d H:i:s");
                    $errorMessage                       = "booking status is not 2(confirm) and 5(complete)";

                    $message                            = '['. $date .'] '. 'error: ' . 'Customer id - '.$currentUser.
                        ' cancel room and got error : '.$errorMessage. PHP_EOL;
                    LogCustom::create($date,$message);

                alert()->warning('You could not cancel your reserved room!')->persistent('OK');
                return redirect()->back();
            }
        }
        catch(\Exception $e){
            // dd('catch',$e);
            $currentUser                        = Utility::getCurrentCustomerID();
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Customer - '.$currentUser.
                                                  ' cancel the booking room and got error -------'.$e->getMessage(). ' ----- line ' .
                                                  $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::create($date,$message);
            alert()->warning('You could not cancel your reserved room!')->persistent('OK');
            return redirect()->back();
        }
    }


}
