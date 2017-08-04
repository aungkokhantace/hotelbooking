<?php

namespace App\Http\Controllers\Frontend;

use App\Core\Check;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use App\Payment\PaymentUtility;
use App\Setup\Amenities\AmenitiesRepository;
use App\Setup\Booking\Booking;
use App\Setup\Booking\BookingRepositoryInterface;
use App\Setup\Booking\CommunicationRepository;
use App\Setup\BookingPaymentStripe\BookingPaymentStripe;
use App\Setup\BookingPaymentStripe\BookingPaymentStripeRepository;
use App\Setup\BookingRequest\BookingRequestRepository;
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
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
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
    public function __construct(BookingRepositoryInterface $repo){
        $this->repo = $repo;
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
                    $first_cancel_days  = $h_config->first_cancellation_day_count;
                    $second_cancel_days = $h_config->second_cancellation_day_count;
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
        $h_config                       = $h_configRepo->getObjByID($booking->hotel_id);
        $first_cancel_days              = $h_config->first_cancellation_day_count;
        $second_cancel_days             = $h_config->second_cancellation_day_count;
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

                    /* Change Status */
                    $booking->status                        = 3;
                    $booking->booking_cancel_reason         = $reason;
                    $result                                 = $this->repo->changeBookingStatus($booking);
                    if($result['aceplusStatusCode'] == ReturnMessage::OK){
                        /* Send Mail */
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
                        $returnState                        = $this->repo->sendMail($mailTemplate,$emails,$subject,$logMessage);

                        if($returnState['aceplusStatusCode'] == ReturnMessage::OK){
                            $response['aceplusStatusCode']  = '200';
                            $response['param']              = $booking->id;
                        }
                        else{
                            $response['aceplusStatusCode']  = '503';
                            $response['param']              = $booking->id;
                        }
                        DB::commit();
                    }
                    else{
                        DB::rollback();
                        return \Response::json($response);

                    }

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
                    $first_cancel_days                  = $h_config->first_cancellation_day_count;
                    $second_cancel_days                 = $h_config->second_cancellation_day_count;
                    $first_cancel_date                  = Carbon::parse($booking->check_in_date)->subDays($first_cancel_days);
                    $second_cancel_date                 = Carbon::parse($booking->check_in_date)->subDays($second_cancel_days);
                    $today_date                         = Carbon::now();

                    /* For 1st Cancellation Day */
                    if($today_date >= $first_cancel_date && $today_date < $second_cancel_date){
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
                                $booking->status                = 3;
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
                                    $returnState                    = $this->repo->sendMail($mailTemplate,$emails,$subject,$logMessage);
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
                        /* Change Status */
                        $booking->status                    = 3;
                        $booking->booking_cancel_reason     = $reason;
                        $result                             = $this->repo->changeBookingStatus($booking);
                        /* Change Status */
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
                            $returnState                    = $this->repo->sendMail($mailTemplate,$emails,$subject,$logMessage);
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
                        else{
                            DB::rollback();
                            return \Response::json($response);

                        }
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

    public function cancel_room($id){
        //
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
                    $returnState                        = $this->repo->sendMail($mailTemplate,$emails,$subject,$logMessage);
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

    public function  communication(Request $request){
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

        return view('frontend.cancel_test')->with('reasons',$reasons)->with('booking',$booking);
    }




}
