<?php
/**
 * Created by PhpStorm.
 * User: william
 * Author: Wai Yan Aung
 * Date: 1/14/2017
 * Time: 10:55 AM
 */

namespace App\Http\Controllers\Frontend;

use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests;
//use App\Session;
use App\Setup\Booking\Booking;
use App\Setup\Booking\BookingRepository;
use App\Setup\BookingPayment\BookingPayment;
use App\Setup\BookingPayment\BookingPaymentRepository;
use App\Setup\BookingPaymentStripe\BookingPaymentStripe;
use App\Setup\BookingPaymentStripe\BookingPaymentStripeRepository;
use App\Setup\BookingRequest\BookingRequest;
use App\Setup\BookingRequest\BookingRequestRepository;
use App\Setup\BookingRoom\BookingRoom;
use App\Setup\BookingRoom\BookingRoomRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelConfig\HotelConfig;
use App\Setup\HotelConfig\HotelConfigRepository;
use App\Setup\HotelFacility\HotelFacilityRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\Payment\Payment;
use App\Setup\Payment\PaymentRepository;
use App\Setup\Room\RoomRepository;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Redirect;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class PaymentController extends Controller
{

    public function __construct() {

    }

    public function enterDetails(){
        $available_room_categories             = Input::get('available_room_categories');

        $number_array = array();
        foreach($available_room_categories as $available_room_category){
            $number_array[$available_room_category]             = Input::get('number_'.$available_room_category);
        }

        $roomCategoryRepo   = new HotelRoomCategoryRepository();
        $available_room_category_array = array();
        foreach($available_room_categories as $available){
            $room_category      = $roomCategoryRepo->getObjByID($available);

            if(isset($number_array[$available]) && $number_array[$available] != "" && $number_array[$available] != 0){
                $room_category->number = $number_array[$available];
                array_push($available_room_category_array,$room_category);
            }
        }

        $hotel_id           = $available_room_category_array[0]->hotel_id;

        $hotelRepo          = new HotelRepository();
        $hotel              = $hotelRepo->getObjByID($hotel_id);

        $check_in           = session('check_in');
        $check_out          = session('check_out');

        //calculate the number of night stay
        $difference = strtotime($check_out) - strtotime($check_in);
        $nights     = floor($difference/(60*60*24));

        $hotelFacilitiesRepo    = new HotelFacilityRepository();
        $hotelFacilities        = $hotelFacilitiesRepo->getHotelFacilitiesByHotelID($hotel_id);

        //calculate total number of rooms
        $totalRooms = 0;
        foreach($number_array as $room_category_id=>$number_of_room){
            if($number_of_room > 0){
                $totalRooms += $number_of_room;
            }
        }

        //calculate total amount
        $total_amount = 0.0;
        foreach($number_array as $room_category_id=>$number_of_room){
            if($number_of_room > 0){
                $room_category = $roomCategoryRepo->getObjByID($room_category_id);
                $amount_per_category = $room_category->price * $number_of_room * $nights;
                $total_amount += $amount_per_category;
            }
        }

        /*if(isset($available_room_category_array) && count($available_room_category_array) > 0){
            //get first index of available room categories
            $first_category = array_slice($available_room_category_array,0,1)[0];
        }
        else{
            $first_category = null;
        }

        if(count($available_room_category_array) > 1){
            $available_room_category_array = array_slice($available_room_category_array,1);
        } */

        $tax = 0.0;
        $hotelConfigRepo = new HotelConfigRepository();
        $hotel_config = $hotelConfigRepo->getConfigByHotel($hotel_id);
        if(isset($hotel_config) && count($hotel_config) > 0){
            $tax = $hotel_config->tax;
        }

        $tax_amount = ($tax / 100) * $total_amount;
        $payable_amount = $total_amount + $tax_amount;

        Session::forget('total_amount');
        Session::forget('tax');
        Session::forget('tax_amount');
        Session::forget('payable_amount');
//        Session::forget('total_payable_amount_w_extrabed');
        Session::forget('total_payable_amount_wo_extrabed');
        Session::forget('total_extrabed_fee');

        $total_payable_amount_wo_extrabed = 0.00;
        $total_payable_amount_wo_extrabed = $total_amount;

        if(isset($total_payable_amount_wo_extrabed) && $total_payable_amount_wo_extrabed != 0.00){
            session(['total_payable_amount_wo_extrabed' => $total_payable_amount_wo_extrabed]);
        }


        if(isset($total_amount) && $total_amount != null && $total_amount != ""){
            session(['total_amount' => $total_amount]);
        }
        if(isset($tax) && $tax != null && $tax != ""){
            session(['tax' => $tax]);
        }
        if(isset($tax_amount) && $tax_amount != null && $tax_amount != ""){
            session(['tax_amount' => $tax_amount]);
        }
        if(isset($payable_amount) && $payable_amount != null && $payable_amount != ""){
            session(['payable_amount' => $payable_amount]);
        }

        return view('frontend.enterdetails')
                    ->with('available_room_category_array',$available_room_category_array)
                    ->with('hotel',$hotel)
                    ->with('nights',$nights)
                    ->with('hotelFacilities',$hotelFacilities)
                    ->with('totalRooms',$totalRooms)
                    ->with('tax',$tax)
                    ->with('tax_amount',$tax_amount)
                    ->with('total_amount',$total_amount)
                    ->with('payable_amount',$payable_amount);
    }

    public function confirmReservation() {
        $hotel_id           = Input::get('hotel_id');

        $available_room_categories = Input::get('available_room_categories');

        $travel_for_work    = (Input::has('travel_for_work')) ? 1 : 0;
        $first_name         = Input::get('first_name');
        $last_name          = Input::get('last_name');
        $email              = Input::get('email');

        $booking_taxi       = (Input::has('booking_taxi')) ? 1 : 0;
        $booking_tour_guide = (Input::has('booking_tour_guide')) ? 1 : 0;

        $non_smoking_request        = (Input::has('non_smoking_request')) ? 1 : 0;
        $late_check_in_request      = (Input::has('late_check_in_request')) ? 1 : 0;
        $high_floor_request         = (Input::has('high_floor_request')) ? 1 : 0;
        $large_bed_request          = (Input::has('large_bed_request')) ? 1 : 0;
        $early_check_in_request     = (Input::has('early_check_in_request')) ? 1 : 0;
        $twin_bed_request           = (Input::has('twin_bed_request')) ? 1 : 0;
        $quiet_room_request         = (Input::has('quiet_room_request')) ? 1 : 0;
        $airport_transfer_request   = (Input::has('airport_transfer_request')) ? 1 : 0;
        $private_parking_request    = (Input::has('private_parking_request')) ? 1 : 0;
        $baby_cot_request           = (Input::has('baby_cot_request')) ? 1 : 0;
        $special_request            = (Input::has('special_request')) ? Input::get('special_request') : "";

        Session::forget('hotel_id');
        Session::forget('travel_for_work');
        Session::forget('first_name');
        Session::forget('last_name');
        Session::forget('email');
        Session::forget('available_room_categories');

        Session::forget('booking_taxi');
        Session::forget('booking_tour_guide');

        Session::forget('non_smoking_request');
        Session::forget('late_check_in_request');
        Session::forget('high_floor_request');
        Session::forget('large_bed_request');
        Session::forget('early_check_in_request');
        Session::forget('twin_bed_request');
        Session::forget('quiet_room_request');
        Session::forget('airport_transfer_request');
        Session::forget('private_parking_request');
        Session::forget('baby_cot_request');
        Session::forget('special_request');

        Session::forget('total_amount');
        Session::forget('tax_amount');


        //store general data fields in session
        if(isset($hotel_id) && $hotel_id != null && $hotel_id != ""){
            session(['hotel_id' => $hotel_id]);
        }

        if(isset($travel_for_work)){
            session(['travel_for_work' => $travel_for_work]);
        }
        if(isset($first_name) && $first_name != null && $first_name != ""){
            session(['first_name' => $first_name]);
        }
        if(isset($last_name) && $last_name != null && $last_name != ""){
            session(['last_name' => $last_name]);
        }
        if(isset($email) && $email != null && $email != ""){
            session(['email' => $email]);
        }

        foreach($available_room_categories as $key=>$temp){
            $temp = json_decode($temp);
            $available_room_categories[$key] = $temp;
        }

        //push to session array
        if(isset($available_room_categories) && $available_room_categories != null && count($available_room_categories)>0){
            foreach($available_room_categories as $available_room_cat){
                Session::push('available_room_categories',$available_room_cat);
            }
        }

        $guest_array    = array();
        $smoking_array  = array();
        $name_array     = array();
        $email_array    = array();
        $extrabed_array = array();
        $extrabed_fee_array = array();

        if(isset($available_room_categories) && count($available_room_categories)){
            foreach($available_room_categories as $category){
                if(isset($category->number) && $category->number !=0 && $category->number != ""){
                    for($i=0;$i<$category->number;$i++){
                        //for guest array
                        Session::forget($category->id."_".($i+1)."_guest");  //forget old session
                        $temp_guest = (Input::has($category->id."_".($i+1)."_guest")) ? Input::get($category->id."_".($i+1)."_guest") : 1;
                        $guest_array[$category->id."_".($i+1)] = $temp_guest;
                        //store in session
                        session([$category->id."_".($i+1)."_guest" => $temp_guest]);

                        //for smoking array
                        Session::forget($category->id."_".($i+1)."_smoking");  //forget old session
                        $temp_smoking = (Input::has($category->id."_".($i+1)."_smoking")) ? Input::get($category->id."_".($i+1)."_smoking") : "yes";
                        $smoking_array[$category->id."_".($i+1)] = $temp_smoking;
                        //store in session
                        session([$category->id."_".($i+1)."_smoking" => $temp_smoking]);

                        //for extrabed array
                        Session::forget($category->id."_".($i+1)."_extrabed");  //forget old session
                        $temp_extrabed = (Input::has($category->id."_".($i+1)."_extrabed")) ? Input::get($category->id."_".($i+1)."_extrabed") : "no";
                        $extrabed_array[$category->id."_".($i+1)] = $temp_extrabed;
                        //store in session
                        session([$category->id."_".($i+1)."_extrabed" => $temp_extrabed]);
                        //if extrabed value is yes, store extrabed fee in extrabed_fee_array()
                        if($temp_extrabed == "yes"){
                            array_push($extrabed_fee_array,$category->extra_bed_price);
                        }


                        //for name array
                        Session::forget($category->id."_".($i+1)."_name");  //forget old session
                        $temp_name = (Input::has($category->id."_".($i+1)."_name")) ? Input::get($category->id."_".($i+1)."_name") : "";
                        $name_array[$category->id."_".($i+1)] = $temp_name;
                        //store in session
                        session([$category->id."_".($i+1)."_name" => $temp_name]);

                        //for email array
                        Session::forget($category->id."_".($i+1)."_email");  //forget old session
                        $temp_email = (Input::has($category->id."_".($i+1)."_email")) ? Input::get($category->id."_".($i+1)."_email") : "";
                        $email_array[$category->id."_".($i+1)] = $temp_email;
                        //store in session
                        session([$category->id."_".($i+1)."_email" => $temp_email]);
                    }
                }
            }
        }

        if(isset($booking_taxi)){
            session(['booking_taxi' => $booking_taxi]);
        }

        if(isset($booking_tour_guide)){
            session(['booking_tour_guide' => $booking_tour_guide]);
        }

        if(isset($non_smoking_request)){
            session(['non_smoking_request' => $non_smoking_request]);
        }
        if(isset($late_check_in_request)){
            session(['late_check_in_request' => $late_check_in_request]);
        }
        if(isset($high_floor_request)){
            session(['high_floor_request' => $high_floor_request]);
        }
        if(isset($large_bed_request)){
            session(['large_bed_request' => $large_bed_request]);
        }
        if(isset($early_check_in_request)){
            session(['early_check_in_request' => $early_check_in_request]);
        }
        if(isset($twin_bed_request)){
            session(['twin_bed_request' => $twin_bed_request]);
        }
        if(isset($quiet_room_request)){
            session(['quiet_room_request' => $quiet_room_request]);
        }
        if(isset($airport_transfer_request)){
            session(['airport_transfer_request' => $airport_transfer_request]);
        }
        if(isset($private_parking_request)){
            session(['private_parking_request' => $private_parking_request]);
        }
        if(isset($baby_cot_request)){
            session(['baby_cot_request' => $baby_cot_request]);
        }
        if(isset($special_request)){
            session(['special_request' => $special_request]);
        }

        $hotelRepo          = new HotelRepository();
        $hotel              = $hotelRepo->getObjByID($hotel_id);

        $check_in           = session('check_in');
        $check_out          = session('check_out');

        //calculate the number of night stay
        $difference = strtotime($check_out) - strtotime($check_in);
        $nights     = floor($difference/(60*60*24));

        $hotelFacilitiesRepo    = new HotelFacilityRepository();
        $hotelFacilities        = $hotelFacilitiesRepo->getHotelFacilitiesByHotelID($hotel_id);

        //calculate total number of rooms
        $totalRooms = 0;
        foreach($available_room_categories as $available_category){
            if($available_category->number > 0){
                $totalRooms += $available_category->number;
            }
        }

        //calculate total extrabed fees
        $total_extrabed_fee = 0.0;
        foreach($extrabed_fee_array as $extrabed_fee){
            $total_extrabed_fee += $extrabed_fee;
        }
        //save in session
        session(['total_extrabed_fee' => $total_extrabed_fee]);

        //calculate total amount
        $total_amount = 0.0;
        foreach($available_room_categories as $available_room_category_amount){
            if($available_room_category_amount->number > 0){
                $amount_per_category = $available_room_category_amount->price * $available_room_category_amount->number * $nights;
                $total_amount += $amount_per_category;
            }
        }

        //save in session
        session(['total_amount' => $total_amount]);

        //calculate total payable amount including extrabed
        $total_payable_amount_w_extrabed = 0.00;
        $total_payable_amount_wo_extrabed = 0.00;
        $total_payable_amount_wo_extrabed = $total_amount;
        $total_payable_amount_w_extrabed = $total_amount + $total_extrabed_fee;

        $tax = 0.0;
        $hotelConfigRepo = new HotelConfigRepository();
        $hotel_config = $hotelConfigRepo->getConfigByHotel($hotel_id);
        if(isset($hotel_config) && count($hotel_config) > 0){
            $tax = $hotel_config->tax;
        }
        $tax_amount = ($tax / 100) * $total_payable_amount_w_extrabed;
        $payable_amount = $total_payable_amount_w_extrabed + $tax_amount;

        if(isset($total_payable_amount_w_extrabed) && $total_payable_amount_w_extrabed != 0.00){
            session(['total_payable_amount_w_extrabed' => $total_payable_amount_w_extrabed]);
        }

        if(isset($total_payable_amount_wo_extrabed) && $total_payable_amount_wo_extrabed != 0.00){
            session(['total_payable_amount_wo_extrabed' => $total_payable_amount_wo_extrabed]);
        }

        if(isset($tax_amount) && $tax_amount != 0.00){
            session(['tax_amount' => $tax_amount]);
        }

        if(isset($total_extrabed_fee) && $total_extrabed_fee != 0.00){
            session(['total_extrabed_fee' => $total_extrabed_fee]);
        }

        if(isset($payable_amount) && $payable_amount != 0.00){
            session(['payable_amount' => $payable_amount]);
        }

        return view('frontend.confirm_reservation')
            ->with('available_room_category_array',$available_room_categories)
            ->with('hotel',$hotel)
            ->with('nights',$nights)
            ->with('hotelFacilities',$hotelFacilities)
            ->with('totalRooms',$totalRooms)
            ->with('total_amount',$total_amount);
    }

    public function bookAndPay() {
        //get input fields
        $country = Input::get('country');
        $phone = Input::get('phone');

        //get session data
        $hotel_id = session('hotel_id');
        $hotelRepo = new HotelRepository();
        $hotel = $hotelRepo->getObjByID($hotel_id);

        $user_id = session('customer')['id'];

        $check_in_date_session = session('check_in');
        $check_out_date_session = session('check_out');

        //change date formats to store in DB
        $check_in_date = date('Y-m-d', strtotime($check_in_date_session));
        $check_out_date = date('Y-m-d', strtotime($check_out_date_session));

        $check_in_time = $hotel->check_in_time;
        $check_out_time = $hotel->check_out_time;
        $total_amount = session('total_amount');
        $tax_amount = session('tax_amount');
        $tax_percent = session('tax');

        $total_payable_amount_w_extrabed  = session('total_payable_amount_w_extrabed');
        $total_payable_amount_wo_extrabed = session('total_payable_amount_wo_extrabed');
        $payable_amount                   = session('payable_amount');

        $travel_for_work = session('travel_for_work');


        //start checking cancellation dates
        $hotelConfigRepo = new HotelConfigRepository();
        $h_config = $hotelConfigRepo->getConfigByHotel($hotel_id);
        $first_cancellation_day_count = $h_config->first_cancellation_day_count;
        $second_cancellation_day_count = $h_config->second_cancellation_day_count;

        //calculate the day to be charged by subtracting first_cancellation_date
        $today_date = date("Y-m-d");   //today's date
//        $check_in_date = $booking_result['object']->check_in_date;

        $date = strtotime(date("Y-m-d", strtotime($check_in_date)) . "-".$first_cancellation_day_count."days");   //date to be charged //after subtracting 1st cancellation date
        $charge_date = date("Y-m-d",$date); //re-format the date
        //end checking cancellation dates

        //Compare today date with charge_date and if today is greater than charge_date(i.e. today is within first cancellation day), charge the customer
        if($today_date > $charge_date){
            $status = 5; //today is within cancellation date and so, user will be charged immediately and booking_status will be "complete"
        }
        else{
            $status = 2; //booking_status = "confirm"
        }

        //////////////////////////////////////////////////
//        $available_room_categories = session('available_room_categories');

//        $roomRepo = New RoomRepository();
        //get rooms that are within available_period and not within black_out period and not booked
//        $rooms    = $roomRepo->getRoomCountByRoomCategoryId($r_category->id,$check_in,$check_out);

        try{
            DB::beginTransaction();

            $bookingObj = new Booking();
            $bookingObj->user_id = $user_id;
            $bookingObj->status = $status;
            $bookingObj->check_in_date = $check_in_date;
            $bookingObj->check_out_date = $check_out_date;
            $bookingObj->check_in_time = $check_in_time;
            $bookingObj->check_out_time = $check_out_time;
            $bookingObj->price_wo_tax = $total_payable_amount_w_extrabed;
            $bookingObj->price_w_tax = $payable_amount;
            $bookingObj->total_tax_amt = $tax_amount;
            $bookingObj->total_tax_percentage = $tax_percent;
            $bookingObj->total_payable_amt = $payable_amount;
            $bookingObj->total_discount_amt = 0.0;
            $bookingObj->total_discount_percentage = 0;
            $bookingObj->hotel_id = $hotel_id;
            $bookingObj->travel_for_work = $travel_for_work;

            $bookingRepo = new BookingRepository();
            $booking_result = $bookingRepo->create($bookingObj);

            //if booking creation fails, alert and redirect to homepage
            if ($booking_result['aceplusStatusCode'] != ReturnMessage::OK){
                DB::rollback();
                alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
                return redirect('/');
            }
            //if booking creation was successful, start booking room creation
            else {
    //            $room_array = array();
                $available_room_categories = session('available_room_categories');
                $roomRepo = New RoomRepository();

                foreach ($available_room_categories as $r_category) {
                    //get available rooms for each room category
                    $rooms = $roomRepo->getRoomArrayByRoomCategoryId($r_category->id, $check_in_date_session, $check_out_date_session);

                    //get only required number of rooms from available rooms
                    $booked_rooms = array_slice($rooms, 0, $r_category->number);

                    foreach ($booked_rooms as $key => $booked_room) {
                        $booking_id = $booking_result["object"]->id;
                        $room_id = $booked_room['id'];
                        $room_status = 2; //confirm
                        $remark = "";
                        $added_extra_bed = 0;
                        $extra_bed_price = 0.0;

                        //get username for each room from session
                        $user_name = session($r_category->id . '_' . ($key + 1) . '_name');
                        $user_email = session($r_category->id . '_' . ($key + 1) . '_email');
                        $guest_count = session($r_category->id . '_' . ($key + 1) . '_guest');
                        $smoking_session = session($r_category->id . '_' . ($key + 1) . '_smoking');
                        $extrabed_session = session($r_category->id . '_' . ($key + 1) . '_extrabed');

                        if ($smoking_session == "yes") {
                            $smoking = 1;
                        } else {
                            $smoking = 0;
                        }

                        if ($extrabed_session == "yes") {
                            $added_extra_bed = 1;
                        } else {
                            $added_extra_bed = 0;
                        }

                        if($added_extra_bed == 1){
                            $extra_bed_price = $r_category->extra_bed_price;
                        }

                        //create booking room obj
                        $bookingRoomObj = new BookingRoom();
                        $bookingRoomObj->booking_id = $booking_id;
                        $bookingRoomObj->user_id = $user_id;
                        $bookingRoomObj->room_id = $room_id;
                        $bookingRoomObj->hotel_id = $hotel_id;
                        $bookingRoomObj->status = $room_status;
                        $bookingRoomObj->check_in_date = $check_in_date;
                        $bookingRoomObj->check_out_date = $check_out_date;
                        $bookingRoomObj->check_in_time = $check_in_time;
                        $bookingRoomObj->check_out_time = $check_out_time;
                        $bookingRoomObj->remark = $remark;
                        $bookingRoomObj->room_price = $r_category->price;
                        $bookingRoomObj->added_extra_bed = $added_extra_bed;
                        $bookingRoomObj->extra_bed_price = $extra_bed_price;
                        $bookingRoomObj->user_first_name = $user_name;
                        $bookingRoomObj->user_last_name = "";
                        $bookingRoomObj->user_email = $user_email;
                        $bookingRoomObj->guest_count = $guest_count;
                        $bookingRoomObj->smoking = $smoking;

                        $bookingRoomRepo = new BookingRoomRepository();
                        $booking_room_result = $bookingRoomRepo->create($bookingRoomObj);

                        //if booking room creation fails, alert and redirect to homepage
                        if ($booking_room_result['aceplusStatusCode'] != ReturnMessage::OK){
                            DB::rollback();
                            alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
                            return redirect('/');
                        }
                    }
                }
            }

            //if booking creation fails, alert and redirect to homepage
            if ($booking_result['aceplusStatusCode'] != ReturnMessage::OK){
                DB::rollback();
                alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
                return redirect('/');
            }
            //if booking creation was successful, start booking request creation
            else {
                $booking_id = $booking_result["object"]->id;
                $non_smoking_request = session('non_smoking_request');
                $late_check_in_request = session('late_check_in_request');
                $early_check_in_request = session('early_check_in_request');
                $high_floor_request = session('high_floor_request');
                $large_bed_request = session('large_bed_request');
                $twin_bed_request = session('twin_bed_request');
                $quiet_room_request = session('quiet_room_request');
                $baby_cot_request = session('baby_cot_request');
                $airport_transfer_request = session('airport_transfer_request');
                $private_parking_request = session('private_parking_request');
                $special_request = session('special_request');
                $booking_taxi = session('booking_taxi');
                $booking_tour_guide = session('booking_tour_guide');

                $bookingRequestObj = new BookingRequest();
                $bookingRequestObj->booking_id = $booking_id;
                $bookingRequestObj->non_smoking_room = $non_smoking_request;
                $bookingRequestObj->late_check_in = $late_check_in_request;
                $bookingRequestObj->early_check_in = $early_check_in_request;
                $bookingRequestObj->high_floor_room = $high_floor_request;
                $bookingRequestObj->large_bed = $large_bed_request;
                $bookingRequestObj->twin_bed = $twin_bed_request;
                $bookingRequestObj->quiet_room = $quiet_room_request;
                $bookingRequestObj->baby_cot = $baby_cot_request;
                $bookingRequestObj->airport_transfer = $airport_transfer_request;
                $bookingRequestObj->private_parking = $private_parking_request;
                $bookingRequestObj->special_request = $special_request;
                $bookingRequestObj->booking_taxi = $booking_taxi;
                $bookingRequestObj->booking_tour_guide = $booking_tour_guide;

                $bookingRequestRepo = new BookingRequestRepository();
                $booking_request_result = $bookingRequestRepo->create($bookingRequestObj);

                //if booking request creation fails, alert and redirect to homepage
                if ($booking_request_result['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
                    return redirect('/');
                }
            }
            //Start Stripe Payment Section
                //Set your secret key: remember to change this to your live secret key in production
                //See your keys here: https://dashboard.stripe.com/account/apikeys
            Stripe::setApiKey("sk_test_pfDJKF6zoTRgCuHdPptjcgQX");

            // Token is created using Stripe.js or Checkout!
            // Get the payment token submitted by the form:
            $token = $_POST['stripeToken'];
            $email = $_POST['stripeEmail'];


            $total_amount = session('total_amount');
            $tax = session('tax');
            $tax_amount = session('tax_amount');
            $payable_amount = session('payable_amount');

            // Create a Customer:
            $customer = Customer::create(array(
                "email" => $email,
                "source" => $token,
            ));

            $customer_id = $customer['id'];

            //Compare today date with charge_date and if today is greater than charge_date(i.e. today is within first cancellation day), charge the customer
            if($today_date > $charge_date){
                // Charge the Customer
                $charge = Charge::create(array(
                    "amount" => $payable_amount,
                    "currency" => "mmk",
                    "customer" => $customer_id
                ));

            }

            //Insert Stripe Customer
    //        DB::table('stripe_user')->insert(['stripe_user_id'=>$customer_id,'email'=>$email,'status'=>1]);

            $paymentObj = new Payment();
            $paymentObj->name = "Stripe Payment";
            $paymentObj->type = 1;
            $paymentObj->description = "";

            $paymentRepo = new PaymentRepository();
            $payment_result = $paymentRepo->create($paymentObj);

            //if payment creation fails, alert and redirect to homepage
            if ($payment_result['aceplusStatusCode'] != ReturnMessage::OK){
                DB::rollback();
                alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
                return redirect('/');
            }
            //if payment creation was successful, start booking payment creation
            else{
                $payment_id = $payment_result["object"]->id;
                $bookingPaymentObj = new BookingPayment();
                $bookingPaymentObj->payment_amount_wo_tax = $total_payable_amount_w_extrabed;
                $bookingPaymentObj->payment_amount_w_tax = $payable_amount;
                $bookingPaymentObj->description = "";
                $bookingPaymentObj->booking_id = $booking_id;
                $bookingPaymentObj->payment_id = $payment_id;
                $bookingPaymentObj->payment_gateway_tax_amt = 0.0;
                $bookingPaymentObj->status = 1;
                $bookingPaymentObj->payment_tax_percentage = $tax_percent;
                $bookingPaymentObj->payment_tax_amt = $tax_amount;
                $bookingPaymentObj->total_payable_amt = $payable_amount;
                $bookingPaymentObj->payment_reference_no = null;

                $bookingPaymentRepo = new BookingPaymentRepository();
                $booking_payment_result = $bookingPaymentRepo->create($bookingPaymentObj);

                //if booking payment creation fails, alert and redirect to homepage
                if ($booking_payment_result['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
                    return redirect('/');
                }
                //if booking payment creation was successful, start booking payment stripe creation
                else {
                    $booking_payment_id = $booking_payment_result["object"]->id;
                    $bookingPaymentStripeObj = new BookingPaymentStripe();
                    $bookingPaymentStripeObj->stripe_user_id = $customer_id;
                    $bookingPaymentStripeObj->email = $email;
                    $bookingPaymentStripeObj->status = 1;
                    $bookingPaymentStripeObj->booking_id = $booking_id;
                    $bookingPaymentStripeObj->booking_payment_id = $booking_payment_id;

                    $bookingPaymentStripeRepo = new BookingPaymentStripeRepository();
                    $booking_payment_stripe_result = $bookingPaymentStripeRepo->create($bookingPaymentStripeObj);

                    //if booking payment stripe creation fails, alert and redirect to homepage
                    if ($booking_payment_stripe_result['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
                        return redirect('/');
                    }
                }
            }

            //if all insertions were successful, commit DB and redirect to congratulation page
            DB::commit();

            return redirect('/congratulations');
        }
        catch(\Exception $e){
            DB::rollback();
            alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
            return redirect('/');
        }
    }

    public function congratulations(){
        $hotel_id   = session('hotel_id');
        $hotelRepo  = new HotelRepository();
        $hotel      = $hotelRepo->getObjByID($hotel_id);

        return view('frontend.congratulations')->with('hotel',$hotel);
    }
}
