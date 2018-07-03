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
use App\Core\Utility;
use App\Http\Controllers\Controller;
use App\Http\Requests;
//use App\Session;
use App\Payment\PaymentUtility;
use App\Setup\Booking\Booking;
use App\Setup\Booking\BookingRepository;
use App\Setup\Booking\Communication;
use App\Setup\Booking\CommunicationRepository;
use App\Setup\BookingPayment\BookingPayment;
use App\Setup\BookingPayment\BookingPaymentRepository;
use App\Setup\BookingPaymentStripe\BookingPaymentStripe;
use App\Setup\BookingPaymentStripe\BookingPaymentStripeRepository;
use App\Setup\BookingRequest\BookingRequest;
use App\Setup\BookingRequest\BookingRequestRepository;
use App\Setup\BookingRoom\BookingRoom;
use App\Setup\BookingRoom\BookingRoomRepository;
use App\Setup\BookingSpecialRequest\BookingSpecialRequest;
use App\Setup\Country\CountryRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelConfig\HotelConfig;
use App\Setup\HotelConfig\HotelConfigRepository;
use App\Setup\HotelFacility\HotelFacilityRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\Payment\Payment;
use App\Setup\Payment\PaymentRepository;
use App\Setup\Room\Room;
use App\Setup\Room\RoomRepository;
use App\Setup\RoomCategoryAmenity\RoomCategoryAmenityRepository;
use App\Setup\RoomCategoryFacility\RoomCategoryFacility;
use App\Setup\RoomCategoryFacility\RoomCategoryFacilityRepository;
use App\Setup\RoomDiscount\RoomDiscountRepository;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Redirect;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use App\Payment\PaymentConstance;
use URL;

class PaymentController extends Controller
{
    private $stripe_fee_percent;
    private $stripe_fee_cents;

    public function __construct() {
        /* Stripe transaction fee */
        $this->stripe_fee_percent       = PaymentConstance::STIRPE_FEE_PERCENT;
        $this->stripe_fee_cents         = PaymentConstance::STRIPE_FEE_FIXED;
    }

    public function enterDetails(Request $request){
        try{
            /* Check request method is post or get */
            if($request->isMethod('POST')){
                /* Get hidden booked room category id */
                $available_room_categories                  = Input::get('available_room_categories');
                /* Merge Room Category Id and number of booked room.*/
                $number_array                               = array();
                foreach($available_room_categories as $available_room_category){
                    $number_array[$available_room_category] = Input::get('number_'.$available_room_category);
                }

                //if method is post, add available_room_categories and number_array in session
                Session::put('available_room_categories',$available_room_categories);
                Session::put('number_array',$number_array);

            }
            else{
                $available_room_categories                  = Session::get('available_room_categories');
                $number_array                               = Session::get('number_array');
            }

            /* Get room category objects By room category id */
            $roomCategoryRepo                               = new HotelRoomCategoryRepository();
            $available_room_category_array                  = array();

            foreach($available_room_categories as $available){
                $room_category      = $roomCategoryRepo->getObjByID($available);
                if(isset($number_array[$available]) && $number_array[$available] != "" && $number_array[$available] != 0){
                    $room_category->number = $number_array[$available];
                    array_push($available_room_category_array,$room_category);
                }
            }

            /* Get hotel data by hotel id of booked room category */
            $hotel_id               = $available_room_category_array[0]->hotel_id;
            $hotelRepo              = new HotelRepository();
            $hotel                  = $hotelRepo->getObjByID($hotel_id);

            $check_in               = session('check_in');
            $check_out              = session('check_out');

            /* Calculate the number of night stay */
            $difference             = strtotime($check_out) - strtotime($check_in);
            $nights                 = floor($difference/(60*60*24));

            /* Get facilities of hotel */
            $hotelFacilitiesRepo    = new HotelFacilityRepository();
            $hotelFacilities        = $hotelFacilitiesRepo->getHotelFacilitiesByHotelID($hotel_id);

            /* Calculate total number of rooms */
            $totalRooms = 0;
            foreach($number_array as $room_category_id=>$number_of_room){
                if($number_of_room > 0){
                    $totalRooms += $number_of_room;
                }
            }

            $roomDiscountRepo                       = new RoomDiscountRepository();

            /* Calculate total amount */
            $total_amount_wo_discount               = 0.0;
            $total_amount_w_discount                = 0.0;
            $discount_array                         = array();
            foreach($number_array as $room_category_id=>$number_of_room){
                if($number_of_room > 0){
                    /* Get room category object and it's properties. */
                    $room_category                      = $roomCategoryRepo->getObjByID($room_category_id);
                    // Price for one room
                    $room_category_price                = $room_category->price;
                    $reserved_date                      = date('Y-m-d', strtotime($check_in));
                    /* Start checking discount for each room_category */
                    for($i=1;$i<=$nights;$i++){
                        /*
                        * Get room discount by room category id and reserved date.
                        * If room discount is null, there's no discount.
                        * If not, need to calculate for each reserved date.
                        */
                        // Amount of all reserved rooms without discount amount.
                        $amount_per_category_wo_discount    = $room_category_price* $number_of_room;
                        // Amount of all reserved rooms with discount amount.
                        $amount_per_category_w_discount     = $amount_per_category_wo_discount;
                        // Get room discount by reserved_date and room_category _id
                        $room_discount                      = $roomDiscountRepo->getRoomCategoryDiscount($room_category_id,$reserved_date);
                        /* Initialize or reset discount_percent and discount_amt */
                        $discount_percent                   = 0.00;
                        $discount_amt                       = 0.00;

                        if(isset($room_discount) && count($room_discount)>0){
                            /*
                            * If discount is defined by percent, change percent to amount for each room.
                            * If discount is defined by amount, get discount amount for each room.
                            */
                            if(isset($room_discount->discount_percent) && $room_discount->discount_percent != 0){
                                $discount_percent           = $room_discount->discount_percent;
                                $discount_amt               = round(($discount_percent / 100) * $room_category_price,2);
                            }
                            if(($room_discount->discount_amount) && $room_discount->discount_amount != 0){
                                $discount_amt               = $room_discount->discount_amount;
                                $discount_percent           = round(($discount_amt/$room_category_price)*100,2);
                            }

                            /*
                            * Calculate amount with discount for all reserved room per category.
                            * Subtract discount amount of all reserved room per category from the amount of all reserved rooms
                            * without discount amount.
                            * And create discount amount array.
                            */

                            $amount_per_category_w_discount = $amount_per_category_wo_discount-($discount_amt*$number_of_room);
                            array_push($discount_array,$discount_amt*$number_of_room);
                        }
                        // Total amount of all reserved rooms without discount amount.
                        $total_amount_wo_discount          += $amount_per_category_wo_discount;
                        // Total amount of all reserved rooms with discount.
                        $total_amount_w_discount           += $amount_per_category_w_discount;
                        // next reserved date
                        $reserved_date                      = date("Y-m-d", strtotime("1 day", strtotime($reserved_date)));
                    }
                }
            }
            /* Calculate total discount amount */
            $total_discount_amount                  = 0.00;
            foreach($discount_array as $disc){
                $total_discount_amount             += $disc;
            }

            //get hotel_service_tax if exists, else, get service_tax from core_configs
            $service_tax                            = Utility::getServiceTax($hotel_id);
            $service_tax_amount                     = round(($service_tax / 100) * $total_amount_w_discount,2);

            //get government tax
            $gov_tax_temp                           = DB::select("SELECT * FROM core_configs WHERE `code` = 'GST'");
            if(isset($gov_tax_temp) && count($gov_tax_temp)>0){
                $gov_tax                            = number_format((float)$gov_tax_temp[0]->value,2);
            }
            else{
                $gov_tax                            = 0.00;
            }

            $gov_tax_amount                         = round(($gov_tax / 100) * $total_amount_w_discount,2);
            $payable_amount                         = $total_amount_w_discount + $service_tax_amount + $gov_tax_amount;

            /* Start deleting Session */
            Session::forget('total_amount');
            Session::forget('total_amount_wo_discount');
            Session::forget('total_amount_w_discount');
            Session::forget('total_discount_amount');

            Session::forget('service_tax');
            Session::forget('service_tax_amount');
            Session::forget('gov_tax');
            Session::forget('gov_tax_amount');

            Session::forget('payable_amount');
    //        Session::forget('total_payable_amount_w_extrabed');
            Session::forget('total_payable_amount_wo_extrabed');
            Session::forget('total_extrabed_fee');

            Session::forget('total_discount_amount');

            /* End deleting Session */

            /* Calculate total amount without extra bed price or with extra bed price */
            $total_payable_amount_wo_extrabed = 0.00;
            $total_payable_amount_wo_extrabed = $total_amount_w_discount;

            if(isset($total_payable_amount_wo_extrabed) && $total_payable_amount_wo_extrabed != 0.00){
                session(['total_payable_amount_wo_extrabed' => $total_payable_amount_wo_extrabed]);
            }

    //        if(isset($total_amount) && $total_amount != null && $total_amount != ""){
    //            session(['total_amount' => $total_amount]);
    //        }

            if(isset($total_amount_wo_discount) && $total_amount_wo_discount != null && $total_amount_wo_discount != ""){
                session(['total_amount_wo_discount' => $total_amount_wo_discount]);
            }

            if(isset($total_amount_w_discount) && $total_amount_w_discount != null && $total_amount_w_discount != ""){
                session(['total_amount_w_discount' => $total_amount_w_discount]);
            }

            if(isset($total_discount_amount) && $total_discount_amount != null && $total_discount_amount != ""){
                session(['total_discount_amount' => $total_discount_amount]);
            }

            if(isset($service_tax) && $service_tax != null && $service_tax != ""){
                session(['service_tax' => $service_tax]);
            }

            if(isset($service_tax_amount) && !is_null($service_tax_amount)){
                session(['service_tax_amount' => $service_tax_amount]);
            }

    //        if(isset($gov_tax) && $gov_tax != null && $gov_tax != ""){
            if(isset($gov_tax)){
                session(['gov_tax' => $gov_tax]);
            }

            if(isset($gov_tax_amount)){
                session(['gov_tax_amount' => $gov_tax_amount]);
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
                        ->with('payable_amount',$payable_amount);
        }
        catch(\Exception $e){
            //write log here
            Session::flush(); // destroy all sessions
            return redirect('/');
        }

    }

    public function confirmReservation(Request $request) {
        try{
            $hotel_id                   = Input::get('hotel_id');
            $available_room_categories  = Input::get('available_room_categories');

            $travel_for_work            = (Input::has('travel_for_work')) ? 1 : 0;
            $first_name                 = Input::get('first_name');
            $last_name                  = Input::get('last_name');
            $email                      = Input::get('email');

            $booking_taxi               = (Input::has('booking_taxi')) ? 1 : 0;
            $booking_tour_guide         = (Input::has('booking_tour_guide')) ? 1 : 0;

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

            if($request->isMethod('POST')){
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
                Session::forget('total_payable_amount_w_extrabed');

                Session::forget('service_tax');
                Session::forget('service_tax_amount');
                Session::forget('gov_tax');
                Session::forget('gov_tax_amount');

                Session::forget('payable_amount');

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

            }
            else{
                $hotel_id                   = Session::get('hotel_id');
                $travel_for_work            = Session::get('travel_for_work');
                $first_name                 = Session::get('first_name');
                $last_name                  = Session::get('last_name');
                $email                      = Session::get('email');
                $available_room_categories  = Session::get('available_room_categories');

                $booking_taxi               = Session::get('booking_taxi');
                $booking_tour_guide         = Session::get('booking_tour_guide');

                $non_smoking_request        = Session::get('non_smoking_request');
                $late_check_in_request      = Session::get('late_check_in_request');
                $high_floor_request         = Session::get('high_floor_request');
                $large_bed_request          = Session::get('large_bed_request');
                $early_check_in_request     = Session::get('early_check_in_request');
                $twin_bed_request           = Session::get('twin_bed_request');
                $quiet_room_request         = Session::get('quiet_room_request');
                $airport_transfer_request   = Session::get('airport_transfer_request');
                $private_parking_request    = Session::get('private_parking_request');
                $baby_cot_request           = Session::get('baby_cot_request');
                $special_request            = Session::get('special_request');

            }

            //store general data fields in session
            if(isset($hotel_id) && $hotel_id != null && $hotel_id != ""){
                // session(['hotel_id' => $hotel_id]);
                Session::put('hotel_id',$hotel_id);
            }

            if(isset($travel_for_work)){
                // session(['travel_for_work' => $travel_for_work]);
                Session::put('travel_for_work',$travel_for_work);
            }
            if(isset($first_name) && $first_name != null && $first_name != ""){
                // session(['first_name' => $first_name]);
                Session::put('first_name',$first_name);
            }
            if(isset($last_name) && $last_name != null && $last_name != ""){
                // session(['last_name' => $last_name]);
                Session::put('last_name',$last_name);
            }
            if(isset($email) && $email != null && $email != ""){
                // session(['email' => $email]);
                Session::put('email',$email);
            }

            $guest_array            = array();
            $smoking_array          = array();
            $name_array             = array();
            $email_array            = array();
            $extrabed_array         = array();
            $extrabed_fee_array     = array();
            $room_no_extra_array    = array();
            $category_extra_array   = array();

            /* Get check_in and check_out date from session */
            $check_in               = session('check_in');
            $check_out              = session('check_out');

            /* Calculate the number of night stay */
            $difference             = strtotime($check_out) - strtotime($check_in);
            $nights                 = floor($difference/(60*60*24));
            $total_extrabed_fee     = 0.00;

            if(isset($available_room_categories) && count($available_room_categories)){
                foreach($available_room_categories as $category){
                    /*
                     * Delete some session.
                     * Get guest information for each room that exist in the same category.
                     */
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
                                /* Calculate total extra bed price */
                                $extra_bed_price                    = $category->extra_bed_price*$nights;
                                $total_extrabed_fee                += $extra_bed_price;
                            }

                            /* Create array for extra bed info. Key is room no and Value is extra bed info array. */
                            $temp_room_extra_array['room_no']       = $i;
                            $temp_room_extra_array['add_extra']     = $temp_extrabed;
                            $temp_room_extra_array['extra_price']   = $category->extra_bed_price;
                            $temp_room_extra_array['category_id']   = $category->id;
                            $room_no_extra_array[$i+1]              = $temp_room_extra_array;

                            //for first name array
                            Session::forget($category->id."_".($i+1)."_firstname");  //forget old session
                            $temp_firstname = (Input::has($category->id."_".($i+1)."_firstname")) ? Input::get($category->id."_".($i+1)."_firstname") : "";
                            $firstname_array[$category->id."_".($i+1)] = $temp_firstname;
                            //store in session
                            session([$category->id."_".($i+1)."_firstname" => $temp_firstname]);

                            //for last name array
                            Session::forget($category->id."_".($i+1)."_lastname");  //forget old session
                            $temp_lastname = (Input::has($category->id."_".($i+1)."_lastname")) ? Input::get($category->id."_".($i+1)."_lastname") : "";
                            $lastname_array[$category->id."_".($i+1)] = $temp_lastname;
                            //store in session
                            session([$category->id."_".($i+1)."_lastname" => $temp_lastname]);

                            //for email array
                            Session::forget($category->id."_".($i+1)."_email");  //forget old session
                            $temp_email = (Input::has($category->id."_".($i+1)."_email")) ? Input::get($category->id."_".($i+1)."_email") : "";
                            $email_array[$category->id."_".($i+1)] = $temp_email;
                            //store in session
                            session([$category->id."_".($i+1)."_email" => $temp_email]);
                        }
                    }
                    /* Create array using category id as key.Merge with array using room no as key. */
                    $category_extra_array[$category->id]      = $room_no_extra_array;
                    $temp_room_extra_array                      = array(); // Reset temp array.
                }
            }

            if(isset($total_extrabed_fee)){
                session(['total_extrabed_fee' => $total_extrabed_fee]);
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

            $hotelRepo              = new HotelRepository();
            $hotel                  = $hotelRepo->getObjByID($hotel_id);

            $hotelFacilitiesRepo    = new HotelFacilityRepository();
            $hotelFacilities        = $hotelFacilitiesRepo->getHotelFacilitiesByHotelID($hotel_id);

            /* Calculate total number of rooms */
            $totalRooms             = 0;
            foreach($available_room_categories as $available_category){
                if($available_category->number > 0){
                    $totalRooms    += $available_category->number;
                }
            }

            //calculate total amount
    //        $total_amount = 0.0;
            $total_amount_wo_discount = 0.0;
            $total_amount_w_discount = 0.0;

    //        foreach($available_room_categories as $available_room_category_amount){
    //            if($available_room_category_amount->number > 0){
    //                $amount_per_category = $available_room_category_amount->price * $available_room_category_amount->number * $nights;
    //                $total_amount += $amount_per_category;
    //            }
    //        }

            //save in session
    //        session(['total_amount' => $total_amount]);

            /* Calculate total payable amount including extra bed fee */
            $total_payable_amount_w_extrabed    = 0.00;
            $total_payable_amount_wo_extrabed   = 0.00;
            $total_amount_w_discount            = session('total_amount_w_discount');

            $total_payable_amount_w_extrabed    = $total_amount_w_discount + $total_extrabed_fee;

            //get hotel_service_tax if exists, else, get service_tax from core_configs
            $service_tax                        = Utility::getServiceTax($hotel_id);
    //        $service_tax_amount = ($service_tax / 100) * $total_amount;
            $service_tax_amount                 = round(($service_tax / 100) * $total_payable_amount_w_extrabed,2);

            //get government tax
            $gov_tax_temp = DB::select("SELECT * FROM core_configs WHERE `code` = 'GST'");
            if(isset($gov_tax_temp) && count($gov_tax_temp)>0){
                $gov_tax = number_format((float)$gov_tax_temp[0]->value,2);
            }
            else{
                $gov_tax = 0.0;
            }
            $gov_tax_amount = round(($gov_tax / 100) * $total_payable_amount_w_extrabed,2);

            //calculate payable amount
    //        $payable_amount = $total_amount + $service_tax_amount + $gov_tax_amount;
            $payable_amount = $total_payable_amount_w_extrabed + $service_tax_amount + $gov_tax_amount;

            if(isset($total_payable_amount_w_extrabed) && $total_payable_amount_w_extrabed != 0.00){
                session(['total_payable_amount_w_extrabed' => $total_payable_amount_w_extrabed]);
            }

    //        if(isset($total_payable_amount_wo_extrabed) && $total_payable_amount_wo_extrabed != 0.00){
    //            session(['total_payable_amount_wo_extrabed' => $total_payable_amount_wo_extrabed]);
    //        }

            if(isset($service_tax) && $service_tax != null && $service_tax != ""){
                session(['service_tax' => $service_tax]);
            }

            if(isset($service_tax_amount) && !is_null($service_tax_amount)){
                session(['service_tax_amount' => $service_tax_amount]);
            }

    //        if(isset($gov_tax) && $gov_tax != null && $gov_tax != ""){
            if(isset($gov_tax)){
                session(['gov_tax' => $gov_tax]);
            }
    //        if(isset($gov_tax_amount) && $gov_tax_amount != null && $gov_tax_amount != ""){
            if(isset($gov_tax_amount)){
                session(['gov_tax_amount' => $gov_tax_amount]);
            }
            if(isset($payable_amount) && $payable_amount != null && $payable_amount != ""){
                session(['payable_amount' => $payable_amount]);
            }

            if(isset($total_extrabed_fee) && $total_extrabed_fee != 0.00){
                session(['total_extrabed_fee' => $total_extrabed_fee]);
            }
    //
    //        if(isset($payable_amount) && $payable_amount != 0.00){
    //            session(['payable_amount' => $payable_amount]);
    //        }

            $countryRepo    = new CountryRepository();
            $countries      = $countryRepo->getObjs();

            // for passing publishable key to stripe js checkout form i
            $pub_key        = PaymentConstance::STIRPE_PUBLISHABLE_KEY;

            return view('frontend.confirm_reservation')
                ->with('available_room_category_array',$available_room_categories)
                ->with('hotel',$hotel)
                ->with('nights',$nights)
                ->with('hotelFacilities',$hotelFacilities)
                ->with('totalRooms',$totalRooms)
                ->with('countries',$countries)
                ->with('pub_key',$pub_key);
    //            ->with('total_amount',$total_amount);
        }
        catch(\Exception $e){
            // write log here
            Session::flush(); // destroy all session.
            return redirect('/');
        }

    }

    public function bookAndPay() {
        try{
            //get input fields
            $country                            = Input::get('country');
            $phone                              = Input::get('phone');

            //get session data
            $hotel_id                           = session('hotel_id');
            $hotelRepo                          = new HotelRepository();
            $hotel                              = $hotelRepo->getObjByID($hotel_id);
            //Generate Booking Number
            $booking_number                     = Utility::generateBookingNumber();

            $user_id                            = session('customer')['id'];

            $check_in_date_session              = session('check_in');
            $check_out_date_session             = session('check_out');

            //change date formats to store in DB
            $check_in_date                      = date('Y-m-d', strtotime($check_in_date_session));
            $check_out_date                     = date('Y-m-d', strtotime($check_out_date_session));

            //Get check_in, check_out time of hotel
            $check_in_time                      = $hotel->check_in_time;
            $check_out_time                     = $hotel->check_out_time;

            //Get Tax,Discount, and payable amount from session.
            $total_payable_amount_w_extrabed    = session('total_payable_amount_w_extrabed');
            $total_payable_amount_wo_extrabed   = session('total_payable_amount_wo_extrabed');
            $payable_amount                     = session('payable_amount');

            $gov_tax_amount                     = session('gov_tax_amount');
            $gov_tax                            = session('gov_tax');
            $service_tax_amount                 = session('service_tax_amount');
            $service_tax                        = session('service_tax');

            $total_discount_amount              = session('total_discount_amount');

            $travel_for_work                    = session('travel_for_work');

            $first_cancellation_day_count       = 0;
            $second_cancellation_day_count      = 0;

            /* Declare Repository */
            $roomDiscountRepo                   = new RoomDiscountRepository();

            /* Start checking cancellation dates */
            // Get cancellation day from hotel config
            $hotelConfigRepo                    = new HotelConfigRepository();
            $h_config                           = $hotelConfigRepo->getConfigByHotel($hotel_id);
            if(isset($h_config) && count($h_config)>0){
                $first_cancellation_day_count   = $h_config->first_cancellation_day_count;
                $second_cancellation_day_count  = $h_config->second_cancellation_day_count;
            }

            // Calculate the day to be charged by subtracting first_cancellation_date
            $today_date                         = date("Y-m-d");   //today's date

            $date                               = strtotime(date("Y-m-d", strtotime($check_in_date)) . "-".
                                                $first_cancellation_day_count."days");

            //date to be charged //after subtracting 1st cancellation date
            $charge_date                        = date("Y-m-d",$date); //re-format the date

            /* End checking cancellation dates */

            /* Compare today date with charge_date and if today is greater than charge_date
            (i.e. today is within first cancellation day or second cancellation day), charge the customer */
            if($today_date >= $charge_date){
                $status                         = 5;
                //today is within cancellation date and so, user will be charged immediately and booking_status will be "complete"
            }
            else{
                $status                         = 2;
                //booking_status = "confirm"
            }

            /* START Operation for stripe */
            // Get email from stripe checkout form
            $email                                          = $_POST['stripeEmail'];
            // Create a customer in stripe
            $stripePaymentObj                               = new PaymentUtility();
            $stripeCustomerResult                           = $stripePaymentObj->createCustomer($_POST);
            /*
            $stripeCustomerResult['aceplusStatusCode'] = ReturnMessage::OK;
            $stripeCustomerResult['stripe']['stripe_user_id'] = 'cus_BjGveSLGYFVUgb';
            $stripeCustomerResult['stripe']['stripe_payment_id'] = '';
            $stripeCustomerResult['stripe']['stripe_payment_amt'] = '';*/
            if($stripeCustomerResult['aceplusStatusCode'] != ReturnMessage::OK){
                DB::rollback();
                alert()->warning(trans('frontend_details.unsuccessful_alert'))->persistent('OK');
                return redirect('/');
            }
            // Get Stripe Customer Id
            $customer_id                                    = $stripeCustomerResult["stripe"]["stripe_user_id"];
            $stripe_card_brand                              = "";
            $stripe_card_type                               = "";
            $stripe_fee_default_cent                        = 0.00;
            $total_stripe_fee_percent                       = 0.00;
            $total_stripe_fee_amt                           = 0.00;
            $total_cancel_income                            = 0.00;
            $total_stripe_net_amt                           = 0.00;
            $total_vendor_net_amt                           = 0.00;
            //Compare today date with charge_date and if today is greater than charge_date(i.e. today is within first cancellation day), charge the customer
            if($today_date >= $charge_date){
                // Capture payment
                $stripePaymentResult                        = $stripePaymentObj->capturePayment($customer_id, $payable_amount);

                if($stripePaymentResult['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->warning(trans('frontend_details.unsuccessful_alert'))->persistent('OK');
                    return redirect('/');
                }
                $stripe_user_id                             = $stripePaymentResult["stripe"]["stripe_user_id"];
                $stripe_payment_id                          = $stripePaymentResult["stripe"]["stripe_payment_id"];
                $stripe_payment_amt                         = $stripePaymentResult["stripe"]["stripe_payment_amt"];
                $stripe_balance_transaction                 = $stripePaymentResult['stripe']['stripe_balance_transaction'];
                $stripe_card_brand                          = $stripePaymentResult['stripe']['card_brand'];
                $stripe_card_type                           = $stripePaymentResult['stripe']['card_type'];

                // Retrieve Balance
                $stripeBalanceResult                        = $stripePaymentObj->retrieveBalance($stripe_balance_transaction);

                if($stripeBalanceResult['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->warning(trans('frontend_details.unsuccessful_alert'))->persistent('OK');
                    return redirect('/');
                }
                $stripe_payment_fee                         = $stripeBalanceResult['stripe']['stripe_payment_fee'];
                $stripe_payment_net                         = $stripeBalanceResult['stripe']['stripe_payment_net'];
                /* Start Calculation for stripe */
                $stripe_fee_default_cent                    = $this->stripe_fee_cents;
                $total_stripe_fee_percent                   = $stripe_payment_fee-$stripe_fee_default_cent;
                $total_stripe_fee_amt                       = $stripe_payment_fee;
                $total_cancel_income                        = 0.00;
                $total_stripe_net_amt                       = $stripe_payment_net;
                $total_vendor_net_amt                       = $total_stripe_net_amt;
                /* End Calculation for stripe */
            }
            /* END Operation for stripe */

            DB::beginTransaction();
            $bookingObj                                     = new Booking();
            $bookingObj->booking_no                         = $booking_number;
            $bookingObj->user_id                            = $user_id;
            $bookingObj->status                             = $status;
            $bookingObj->check_in_date                      = $check_in_date;
            $bookingObj->check_out_date                     = $check_out_date;
            $bookingObj->check_in_time                      = $check_in_time;
            $bookingObj->check_out_time                     = $check_out_time;
            $bookingObj->price_wo_tax                       = $total_payable_amount_w_extrabed;
            $bookingObj->price_w_tax                        = $payable_amount;
            $bookingObj->total_government_tax_amt           = $gov_tax_amount;
            $bookingObj->total_government_tax_percentage    = $gov_tax;
            $bookingObj->total_service_tax_amt              = $service_tax_amount;
            $bookingObj->total_service_tax_percentage       = $service_tax;
            $bookingObj->total_payable_amt                  = $payable_amount;
            $bookingObj->total_discount_amt                 = $total_discount_amount;
            $bookingObj->total_discount_percentage          = 0;
            $bookingObj->total_cancel_income                = $total_cancel_income;
            $bookingObj->total_stripe_fee_percent           = $total_stripe_fee_percent;
            $bookingObj->stripe_fee_default_cent            = $stripe_fee_default_cent;
            $bookingObj->total_stripe_fee_amt               = $total_stripe_fee_amt;
            $bookingObj->total_stripe_net_amt               = $total_stripe_net_amt;
            $bookingObj->total_vendor_net_amt               = $total_vendor_net_amt;
            $bookingObj->hotel_id                           = $hotel_id;
            $bookingObj->travel_for_work                    = $travel_for_work;
            $bookingObj->country_id                         = $country;
            $bookingObj->phone                              = $phone;
            $bookingObj->card_brand                         = $stripe_card_brand;
            $bookingObj->card_type                          = $stripe_card_type;
            $bookingRepo                                    = new BookingRepository();
            $booking_result                                 = $bookingRepo->create($bookingObj);

            //if booking creation fails, alert and redirect to homepage
            if ($booking_result['aceplusStatusCode'] != ReturnMessage::OK){
                DB::rollback();
                alert()->warning(trans('frontend_details.unsuccessful_alert'))->persistent('OK');
                return redirect('/');
            }
            //if booking creation was successful, start booking room creation
//            $room_array = array();
            $available_room_categories  = session('available_room_categories');
            $roomRepo                   = new RoomRepository();
            /* START Operation for Booking Room */
            $cat_id_arr                 = array();

            foreach($available_room_categories as $category){
                array_push($cat_id_arr,$category->id);
            }

            $rooms                      = $roomRepo->getRoomArrayByRoomCategoryId($cat_id_arr, $check_in_date_session, $check_out_date_session);
            $booked_rooms               = array();
            foreach($available_room_categories as $catKey=>$catValue){
                $room_count             = 1;

                foreach($rooms as $roomKey=>$room){
                    if($catValue->id == $room['h_room_category_id'] && $room_count <= $catValue->number){
                        $room['room_price']     = $catValue->price;
                        $room['first_name']     = session($catValue->id. '_' . $room_count . '_firstname');
                        $room['last_name']      = session($catValue->id. '_' . $room_count . '_lastname');
                        $room['email']          = session($catValue->id. '_' . $room_count . '_email');
                        $room['guest']          = session($catValue->id. '_' . $room_count . '_guest');
                        $smoking_session        = session($catValue->id. '_' . $room_count . '_smoking');
                        $extrabed_session       = session($catValue->id. '_' . $room_count . '_extrabed');
                        $room['smoking']        = isset($smoking_session) && $smoking_session == "yes"?1:0;
                        $added_extra_bed        = isset($extrabed_session)&& $extrabed_session == "yes"?1:0;
                        $room['extra_bed']      = $added_extra_bed;
                        $room['extra_bed_price']= isset($added_extra_bed) && $added_extra_bed == 1?$catValue->extra_bed_price:0.00;
                        array_push($booked_rooms,$room);
                        $room_count++;
                    }
                }
            }

            /* Calculate the number of night stay */
            $difference                         = strtotime($check_out_date) - strtotime($check_in_date);
            $nights                             = floor($difference/(60*60*24));
            $discount_array                     = array();
//            $reserved_date                      = $check_in_date;
            foreach($booked_rooms as $b_roomKey=>$b_roomValue){
                $category_id                    = $b_roomValue['h_room_category_id'];
                $booking_id                     = $booking_result["object"]->id;
                $room_id                        = $b_roomValue['id'];
                $room_status                    = $today_date >= $charge_date?5:2;
                $room_price                     = $b_roomValue['room_price'];
                $room_extra_bed_price           = $b_roomValue['extra_bed_price'];
                $remark                         = "";
//                $added_extra_bed                = 0;
//                $extra_bed_price                = 0.0;
                $discount_amt_per_room          = 0.00;
                $total_room_extra_price         = 0.00;
                $reserved_date                  = $check_in_date;

                /* Start checking discount for each room */
                for($i=1;$i<=$nights;$i++){
                    /*
                     * Get room discount by room category id and reserved date.
                     * If room discount is null, there's no discount.
                     * If not, need to calculate for each reserved date.
                     */
                    $room_discount              = $roomDiscountRepo->getRoomCategoryDiscount($category_id,$reserved_date);
                    $discount_percent           = 0.00;
                    $discount_amt               = 0.00;

                    if(isset($room_discount) && count($room_discount)>0){
                        /*
                         * If discount is defined by percent, change percent to amount for each room.
                         * If discount is defined by amount, get discount amount for each room.
                         */
                        if(isset($room_discount->discount_percent) && $room_discount->discount_percent != 0){
                            $discount_percent           = $room_discount->discount_percent;
                            $discount_amt               = round(($discount_percent / 100) * $room_price,2);
                        }
                        if(($room_discount->discount_amount) && $room_discount->discount_amount != 0){
                            $discount_amt               = $room_discount->discount_amount;
                            $discount_percent           = round(($discount_amt/$room_price)*100,2);
                        }
                        $discount_amt_per_room         += $discount_amt;
                    }
                    /* Calculate extra bed price for all reserved day(night) */
                    $total_room_extra_price            += $room_extra_bed_price;
                    // next reserved date
                    $reserved_date                      = date("Y-m-d", strtotime("1 day", strtotime($reserved_date)));
                }

                /* End checking discount for each room */

                $price_for_all_nights                       = $room_price*$nights;
                $room_payable_amount_wo_tax                 = ($price_for_all_nights-$discount_amt_per_room)+$total_room_extra_price;
                $gst_amt                                    = round(($gov_tax / 100) * $room_payable_amount_wo_tax,2);
                $service_amt                                = round(($service_tax / 100) * $room_payable_amount_wo_tax,2);
                $room_payable_amount_w_tax                  = $room_payable_amount_wo_tax+$gst_amt+$service_amt;
                $room_stripe_fee_amt                        = round($room_payable_amount_w_tax*$this->stripe_fee_percent,2);
                $room_net_amt                               = $room_payable_amount_w_tax-$room_stripe_fee_amt;

                /* Start creating booking room */
                $bookingRoomObj                             = new BookingRoom();
                $bookingRoomObj->booking_id                 = $booking_id;
                $bookingRoomObj->user_id                    = $user_id;
                $bookingRoomObj->room_id                    = $room_id;
                $bookingRoomObj->hotel_id                   = $hotel_id;
                $bookingRoomObj->status                     = $room_status;
                $bookingRoomObj->check_in_date              = $check_in_date;
                $bookingRoomObj->check_out_date             = $check_out_date;
                $bookingRoomObj->check_in_time              = $check_in_time;
                $bookingRoomObj->check_out_time             = $check_out_time;
                $bookingRoomObj->remark                     = $remark;
                $bookingRoomObj->number_of_night            = $nights;
                $bookingRoomObj->room_price_per_night       = $b_roomValue['room_price'];
                $bookingRoomObj->discount_amt               = $discount_amt_per_room;
                $bookingRoomObj->room_payable_amt_wo_tax    = $room_payable_amount_wo_tax;
                $bookingRoomObj->government_tax_amt         = $gst_amt;
                $bookingRoomObj->service_tax_amt            = $service_amt;
                $bookingRoomObj->room_payable_amt_w_tax     = $room_payable_amount_w_tax;
                $bookingRoomObj->stripe_fee_percent         = $room_stripe_fee_amt;
                $bookingRoomObj->room_net_amt               = $room_net_amt;
                $bookingRoomObj->added_extra_bed            = $b_roomValue['extra_bed'];
                $bookingRoomObj->extra_bed_price            = $total_room_extra_price;
                $bookingRoomObj->user_first_name            = $b_roomValue['first_name'];
                $bookingRoomObj->user_last_name             = $b_roomValue['last_name'];
                $bookingRoomObj->user_email                 = $b_roomValue['email'];
                $bookingRoomObj->guest_count                = $b_roomValue['guest'];
                $bookingRoomObj->smoking                    = $b_roomValue['smoking'];
                $bookingRoomObj->refund_amt                 = 0.00;
                $bookingRoomObj->room_payable_amt_wo_tax_af = 0.00;
                $bookingRoomObj->government_tax_amt_af      = 0.00;
                $bookingRoomObj->service_tax_amt_af         = 0.00;
                $bookingRoomObj->room_payable_amt_w_tax_af  = 0.00;
                $bookingRoomObj->stripe_fee_percent_af      = 0.00;
                $bookingRoomObj->room_net_amt_af            = 0.00;
                $bookingRoomRepo                            = new BookingRoomRepository();
                $booking_room_result                        = $bookingRoomRepo->create($bookingRoomObj);

                //if booking room creation fails, alert and redirect to homepage
                if ($booking_room_result['aceplusStatusCode'] != ReturnMessage::OK){
                    DB::rollback();
                    alert()->warning(trans('frontend_details.unsuccessful_alert'))->persistent('OK');
                    return redirect('/');
                }
                /* End creating booking room */

            }
            /* END Operation for Booking Room*/

            /* START Operation for Booking Request */
            $booking_id                             = $booking_result["object"]->id;
            $non_smoking_request                    = session('non_smoking_request');
            $late_check_in_request                  = session('late_check_in_request');
            $early_check_in_request                 = session('early_check_in_request');
            $high_floor_request                     = session('high_floor_request');
            $large_bed_request                      = session('large_bed_request');
            $twin_bed_request                       = session('twin_bed_request');
            $quiet_room_request                     = session('quiet_room_request');
            $baby_cot_request                       = session('baby_cot_request');
            $airport_transfer_request               = session('airport_transfer_request');
            $private_parking_request                = session('private_parking_request');
            $special_request                        = session('special_request');
            $booking_taxi                           = session('booking_taxi');
            $booking_tour_guide                     = session('booking_tour_guide');

            $bookingRequestObj                      = new BookingRequest();
            $bookingRequestObj->booking_id          = $booking_id;
            $bookingRequestObj->non_smoking_room    = $non_smoking_request;
            $bookingRequestObj->late_check_in       = $late_check_in_request;
            $bookingRequestObj->early_check_in      = $early_check_in_request;
            $bookingRequestObj->high_floor_room     = $high_floor_request;
            $bookingRequestObj->large_bed           = $large_bed_request;
            $bookingRequestObj->twin_bed            = $twin_bed_request;
            $bookingRequestObj->quiet_room          = $quiet_room_request;
            $bookingRequestObj->baby_cot            = $baby_cot_request;
            $bookingRequestObj->airport_transfer    = $airport_transfer_request;
            $bookingRequestObj->private_parking     = $private_parking_request;
            $bookingRequestObj->special_request     = "";  //special request is not stored in BookingRequest anymore
            $bookingRequestObj->booking_taxi        = $booking_taxi;
            $bookingRequestObj->booking_tour_guide  = $booking_tour_guide;

            $bookingRequestRepo                     = new BookingRequestRepository();
            $booking_request_result                 = $bookingRequestRepo->create($bookingRequestObj);

            if ($booking_request_result['aceplusStatusCode'] != ReturnMessage::OK){
                DB::rollback();
                alert()->warning(trans('frontend_details.unsuccessful_alert'))->persistent('OK');
                return redirect('/');
            }
            /* END Operation for Booking Request */

            /* START Operation for communication */
            $communicationObj                       = new Communication(); //for booking_special_request table
            $communicationObj->booking_id           = $booking_id;
            //get max order from current table
            $order                                  = Communication::whereNull('deleted_at')->max('order');
            if($order == null){
                $communicationObj->order            = 1;
            }
            else{
                $communicationObj->order            = $order + 1;
            }
            $communicationObj->special_request      = $special_request;
            $communicationObj->type                 = 2;  //type 1 is admin, 2 is user

            $communicationRepo                      = new CommunicationRepository();
            $communication_result                   = $communicationRepo->createForFrontend($communicationObj);

            //if communication creation fails, alert and redirect to homepage
            if ($communication_result['aceplusStatusCode'] != ReturnMessage::OK){
                DB::rollback();
                alert()->warning(trans('frontend_details.unsuccessful_alert'))->persistent('OK');
                return redirect('/');
            }
            /* END Operation for communication */

            /* START Operation for Booking Payment */
            $bookingPaymentObj                                  = new BookingPayment();
            $bookingPaymentObj->payment_amount_wo_tax           = $payable_amount;
            $bookingPaymentObj->payment_amount_w_tax            = $total_stripe_net_amt;
            $bookingPaymentObj->description                     = "";
            $bookingPaymentObj->booking_id                      = $booking_id;
            $bookingPaymentObj->payment_gateway_tax_amt         = $total_stripe_fee_amt;
            $bookingPaymentObj->status                          = $status;
            $bookingPaymentObj->total_government_tax_amt        = $gov_tax_amount;
            $bookingPaymentObj->total_government_tax_percentage = $gov_tax;
            $bookingPaymentObj->total_service_tax_amt           = $service_tax_amount;
            $bookingPaymentObj->total_service_tax_percentage    = $service_tax;
            $bookingPaymentObj->total_payable_amt               = $payable_amount;
            $bookingPaymentObj->payment_reference_no            = null;

            $bookingPaymentRepo                                 = new BookingPaymentRepository();
            $booking_payment_result                             = $bookingPaymentRepo->create($bookingPaymentObj);

            if ($booking_payment_result['aceplusStatusCode'] != ReturnMessage::OK){
                DB::rollback();
                alert()->warning(trans('frontend_details.unsuccessful_alert'))->persistent('OK');
                return redirect('/');
            }
            /* END Operation for Booking Payment */

            /* START Operation for Booking Payment Stripe */
            //if booking payment creation was successful, start booking payment stripe creation
            $booking_payment_id                                 = $booking_payment_result["object"]->id;
            $bookingPaymentStripeObj                            = new BookingPaymentStripe();
            $bookingPaymentStripeObj->stripe_user_id            = $customer_id;
            if(isset($stripe_payment_id)){
                $bookingPaymentStripeObj->stripe_payment_id     = $stripe_payment_id;
            }
            if(isset($stripe_payment_amt)){
                $bookingPaymentStripeObj->stripe_payment_amt    = $stripe_payment_amt;
            }
            if(isset($stripe_balance_transaction)){
                $bookingPaymentStripeObj->stripe_balance_transaction    = $stripe_balance_transaction;
            }
            if(isset($stripe_payment_fee)){
                $bookingPaymentStripeObj->stripe_payment_fee    = $stripe_payment_fee;
            }
            if(isset($stripe_payment_net)){
                $bookingPaymentStripeObj->stripe_payment_net    = $stripe_payment_net;
            }
            $bookingPaymentStripeObj->email                     = $email;
            // 2 is capture, 1 is create_customer
            $bookingPaymentStripeObj->status                    = $today_date >= $charge_date? 2:1;
            $bookingPaymentStripeObj->booking_id                = $booking_id;
            $bookingPaymentStripeObj->booking_payment_id        = $booking_payment_id;
            $bookingPaymentStripeRepo                           = new BookingPaymentStripeRepository();
            $booking_payment_stripe_result                      = $bookingPaymentStripeRepo->create($bookingPaymentStripeObj);

            if($booking_payment_stripe_result['aceplusStatusCode'] != ReturnMessage::OK){
                //
                DB::rollback();
                alert()->warning(trans('frontend_details.unsuccessful_alert'))->persistent('OK');
                return redirect('/');
            }
            //if all insertions were successful, commit DB and redirect to congratulation page
            DB::commit();
            /* END Operation for Booking Payment Stripe */

            $booking_id                                         = $bookingObj->id;
            /*
             * Compare today date with charge_date and if today is greater than charge_date
             * (i.e. today is within first cancellation day), send booking COMPLETE mail
             */
            if($today_date >= $charge_date){
                //Start sending complete email
                $email              = $bookingObj->user->email;
                $hotel_email        = $hotelConfigRepo->getEmailByHotelId($hotel_id);
                $hotel_email_str    = $hotel_email->email;
                $system_email       = "testingmps2017@gmail.com";
                $emails             = array($email,$hotel_email_str,$system_email);
                $template           = "booking_cancellation_start";
                $subject            = "Booking Complete Email";
                $logMessage         = "created a booking";
                $mailResult         = Utility::sendMail($template,$emails,$subject,$logMessage);
                if ($mailResult['aceplusStatusCode'] != ReturnMessage::OK){
                    alert()->success('Your Booking was successful, but there was a problem in sending email to you!')->persistent('OK');
                }
                else{
                    alert()->success(trans('frontend_details.successful_alert'))->persistent('OK');
                }
                //End sending complete email
            }
            //else, send booking CONFIRM mail
            else{
                //Start sending confirm email
                $email              = $bookingObj->user->email;
                $hotel_email        = $hotelConfigRepo->getEmailByHotelId($hotel_id);
                $hotel_email_str    = $hotel_email->email;
                $system_email       = "testingmps2017@gmail.com";
                $emails             = array($email,$hotel_email_str,$system_email);
                $template           = "booking_cancellation_start";
                $subject            = "Booking Confirm Email";
                $logMessage         = "created a booking";
                $mailResult         = Utility::sendMail($template,$emails,$subject,$logMessage);
                if ($mailResult['aceplusStatusCode'] != ReturnMessage::OK){
                    alert('Your Booking was successful, but there was a problem in sending email to you!')->persistent('OK');
                }
                else{
                    alert(trans('frontend_details.successful_alert'))->persistent('OK');
                }
                //End sending confirm email
            }

            return redirect('/congratulations/'.$booking_id);
        }
        catch(\Exception $e){
            DB::rollback();
            alert()->warning(trans('frontend_details.unsuccessful_alert'))->persistent('OK');
            return redirect('/');
        }
    }

    public function congratulations($booking_id){
        $bookingRepo = new BookingRepository();
        $booking     = $bookingRepo->getBookingById($booking_id);

        $hotel_id   = $booking->hotel_id;
        $hotelRepo  = new HotelRepository();
        $hotel      = $hotelRepo->getObjByID($hotel_id);

        $bookingRoomRepo = new BookingRoomRepository();
        // $booking_rooms = $bookingRoomRepo->getBookingRoomByBookingId($booking_id);
        //show only uncancelled rooms
        $booking_rooms = $bookingRoomRepo->getNotCancelledBookingRoomByBookingId($booking_id);

        $number_of_rooms = count($booking_rooms);

        if(isset($booking_rooms) && count($booking_rooms)>0){
          $number_of_nights = $booking_rooms[0]->number_of_night; //all number_of_nights for the same booking_id are the same, so take the number_of_nights of the first booking_room
        }else{
          $number_of_nights = 0;
        }

        /*
        $r_cat_array = array();
        foreach($booking_rooms as $booking_room){
            $room_cat_id = $booking_room->room->h_room_category_id;
            array_push($r_cat_array,$room_cat_id);
        }

        $temp_array = array_unique($r_cat_array);  //remove duplicate elements
        $room_category_id_array = array_values($temp_array);

        $room_category_array = array();

        $roomCategoryRepo = new HotelRoomCategoryRepository();
        foreach($room_category_id_array as $room_category_id){
            $room_category = $roomCategoryRepo->getObjByID($room_category_id);
            array_push($room_category_array,$room_category);
        }  */

        //for facilities and amenities
        $roomRepo = new RoomRepository();
        $roomCategoryFacilityRepo = new RoomCategoryFacilityRepository();
        $roomCategoryAmenityRepo = new RoomCategoryAmenityRepository();
        foreach($booking_rooms as $booking_room){
            $room = $roomRepo->getObjByID($booking_room->room_id);
            $room_category_id = $room->h_room_category_id;
            $facilities = $roomCategoryFacilityRepo->getObjByRoomCategoryID($room_category_id);
            $amenities  = $roomCategoryAmenityRepo->getAmenitiesByRoomCategoryId($room_category_id);
            $booking_room->facilities = $facilities;
            $booking_room->amenities  = $amenities;
        }
        //for facilities and amenities

        //start cancellation section
        //start checking cancellation dates
        //initialize cancellation day_counts
        $first_cancellation_day_count = 0;
        $second_cancellation_day_count = 0;

        $hotelConfigRepo = new HotelConfigRepository();
        $h_config = $hotelConfigRepo->getConfigByHotel($hotel_id);
        if(isset($h_config) && count($h_config)>0){
            $first_cancellation_day_count = $h_config->first_cancellation_day_count;
            $second_cancellation_day_count = $h_config->second_cancellation_day_count;
        }

        $check_in_date = $booking->check_in_date;
        $date = strtotime(date("Y-m-d", strtotime($check_in_date)) . "-".$first_cancellation_day_count."days");   //date to be charged //after subtracting 1st cancellation date
        $charge_date = date("Y-m-d",$date); //re-format the date //i.e. first_cancellation_date

        $second_cancellation_date_temp = strtotime(date("Y-m-d", strtotime($check_in_date)) . "-".$second_cancellation_day_count."days");   //date to be charged //after subtracting 1st cancellation date
        $second_cancellation_date = date("Y-m-d",$second_cancellation_date_temp); //re-format the date

        $today_date = date("Y-m-d");   //today's date

//        if($today_date < $charge_date){
            $charge_create = date_create($charge_date);
            $today_create  = date_create($today_date);
            $diff=date_diff($charge_create,$today_create);

            $free_cancellation_year = $diff->y;
            $free_cancellation_month = $diff->m;
            $free_cancellation_day = $diff->d;

            //units
            $free_cancellation_year_unit = ($free_cancellation_year > 1)? "years":"year";
            $free_cancellation_month_unit = ($free_cancellation_month > 1)? "months":"month";
            $free_cancellation_day_unit = ($free_cancellation_day > 1)? "days":"day";
            //units

            //construct free cancellation
            $free_cancellation = $free_cancellation_year." ".$free_cancellation_year_unit." ".$free_cancellation_month." ".$free_cancellation_month_unit." ".$free_cancellation_day." ".$free_cancellation_day_unit;
            //end cancellation section

            if($free_cancellation_year == 0 && $free_cancellation_month == 0 && $free_cancellation_day == 0){
                $free_cancellation = null;
            }
//        }
//        else{
//            $free_cancellation = null;
//        }

//        if($today_date < $second_cancellation_date) {
            $half_amt = $booking->total_payable_amt / 2;
//        }
//        else{
//            $half_amt = 0.0;
//        }

//        if($today_date > $charge_date){
//            $charge_date = null;
//        }
//
//        if($today_date > $second_cancellation_date){
//            $second_cancellation_date = null;
//        }

        return view('frontend.congratulations')
            ->with('booking',$booking)
            ->with('booking_rooms',$booking_rooms)
            ->with('number_of_rooms',$number_of_rooms)
            ->with('number_of_nights',$number_of_nights)
            ->with('free_cancellation',$free_cancellation)
            ->with('charge_date',$charge_date)
            ->with('second_cancellation_date',$second_cancellation_date)
            ->with('half_amt',$half_amt)
//            ->with('room_category_array',$room_category_array)
            ->with('hotel',$hotel);
    }

    public function getDirections($hotel_id) {
        $hotelRepo  = new HotelRepository();
        $hotel      = $hotelRepo->getObjByID($hotel_id);
        return view('frontend.getdirections')->with('hotel',$hotel);
    }
}
