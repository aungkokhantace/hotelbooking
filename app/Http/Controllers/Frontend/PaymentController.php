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

class PaymentController extends Controller
{

    public function __construct() {

    }

    public function enterDetails(Request $request){
        if($request->isMethod('POST')){
            
            $available_room_categories                  = Input::get('available_room_categories');

            $number_array = array();
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
    
        $roomCategoryRepo                               = new HotelRoomCategoryRepository();
        $available_room_category_array                  = array();
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

        $roomDiscountRepo = new RoomDiscountRepository();

        //calculate total amount
//        $total_amount = 0.0;
        $total_amount_wo_discount = 0.0;
        $total_amount_w_discount = 0.0;

        $discount_array = array();

        foreach($number_array as $room_category_id=>$number_of_room){
            if($number_of_room > 0){
                $room_category = $roomCategoryRepo->getObjByID($room_category_id);
//                $amount_per_category = $room_category->price * $number_of_room * $nights;
                $amount_per_category_wo_discount = $room_category->price * $number_of_room * $nights;
                $amount_per_category_w_discount  = $amount_per_category_wo_discount;

                //start checking discount for each room_category
                //get room discount by room_category_id
                $room_discount = $roomDiscountRepo->getDiscountByRoomCategory($room_category_id);

                //initialize discount_percent and discount_amt
                $discount_percent = 0;
                $discount_amt = 0.00;

                if(isset($room_discount) && count($room_discount)>0){
                    if(isset($room_discount->discount_percent) && $room_discount->discount_percent != 0){
                        $discount_percent = $room_discount->discount_percent;
                    }
                    elseif(($room_discount->discount_amount) && $room_discount->discount_amount != 0){
                        $discount_amt = $room_discount->discount_amount;
                    }
                }

                //if there is discount_percent, change to amount and add to discount_array
                if($discount_percent != 0){
                    $discount_amount_per_category = ($discount_percent / 100) * $amount_per_category_wo_discount;
                    $amount_per_category_w_discount = $amount_per_category_wo_discount - $discount_amount_per_category;
                    array_push($discount_array,$discount_amount_per_category);
                }
                //else if there is discount_amt, add to discount_array
                elseif($discount_amt != 0.00){
                    $amount_per_category_w_discount = $amount_per_category_wo_discount - $discount_amt;
                    array_push($discount_array,$discount_amt);
                }
                //end checking discount for each room_category

//                $total_amount += $amount_per_category;
                $total_amount_wo_discount += $amount_per_category_wo_discount;
                $total_amount_w_discount += $amount_per_category_w_discount;
            }
        }

        $total_discount_amount = 0.00;
        //calculate total discount amount
        foreach($discount_array as $disc){
            $total_discount_amount += $disc;
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

//        $tax = 0.0;
//        $hotelConfigRepo = new HotelConfigRepository();
//        $hotel_config = $hotelConfigRepo->getConfigByHotel($hotel_id);
//        if(isset($hotel_config) && count($hotel_config) > 0){
//            $tax = $hotel_config->tax;
//        }

        //get hotel_service_tax if exists, else, get service_tax from core_configs
        $service_tax = Utility::getServiceTax($hotel_id);
        $service_tax_amount = ($service_tax / 100) * $total_amount_w_discount;

        //get government tax
        $gov_tax_temp = DB::select("SELECT * FROM core_configs WHERE `code` = 'GST'");
        if(isset($gov_tax_temp) && count($gov_tax_temp)>0){
            $gov_tax = $gov_tax_temp[0]->value;
        }
        else{
            $gov_tax = 0.0;
        }

        $gov_tax_amount = ($gov_tax / 100) * $total_amount_w_discount;

        $payable_amount = $total_amount_w_discount + $service_tax_amount + $gov_tax_amount;

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
        if(isset($service_tax_amount) && $service_tax_amount != null && $service_tax_amount != ""){
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

    public function confirmReservation(Request $request) {
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

        //calculate total payable amount including extrabed
        $total_payable_amount_w_extrabed = 0.00;
        $total_payable_amount_wo_extrabed = 0.00;
//        $total_payable_amount_wo_extrabed = $total_amount;
//        $total_payable_amount_wo_extrabed = session('total_payable_amount_wo_extrabed');
        $total_amount_w_discount = session('total_amount_w_discount');

        $total_payable_amount_w_extrabed = $total_amount_w_discount + $total_extrabed_fee;

//        $tax = 0.0;
//        $hotelConfigRepo = new HotelConfigRepository();
//        $hotel_config = $hotelConfigRepo->getConfigByHotel($hotel_id);
//        if(isset($hotel_config) && count($hotel_config) > 0){
//            $tax = $hotel_config->tax;
//        }
//        $tax_amount = ($tax / 100) * $total_payable_amount_w_extrabed;
//        $payable_amount = $total_payable_amount_w_extrabed + $tax_amount;

        //get hotel_service_tax if exists, else, get service_tax from core_configs
        $service_tax = Utility::getServiceTax($hotel_id);
//        $service_tax_amount = ($service_tax / 100) * $total_amount;
        $service_tax_amount = ($service_tax / 100) * $total_payable_amount_w_extrabed;

        //get government tax
        $gov_tax_temp = DB::select("SELECT * FROM core_configs WHERE `code` = 'GST'");
        if(isset($gov_tax_temp) && count($gov_tax_temp)>0){
            $gov_tax = $gov_tax_temp[0]->value;
        }
        else{
            $gov_tax = 0.0;
        }
        $gov_tax_amount = ($gov_tax / 100) * $total_payable_amount_w_extrabed;

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
        if(isset($service_tax_amount) && $service_tax_amount != null && $service_tax_amount != ""){
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

        $countryRepo = new CountryRepository();
        $countries = $countryRepo->getObjs();

        return view('frontend.confirm_reservation')
            ->with('available_room_category_array',$available_room_categories)
            ->with('hotel',$hotel)
            ->with('nights',$nights)
            ->with('hotelFacilities',$hotelFacilities)
            ->with('totalRooms',$totalRooms)
            ->with('countries',$countries);
//            ->with('total_amount',$total_amount);
    }

    public function bookAndPay() {
        //get input fields
        $country = Input::get('country');
        $phone = Input::get('phone');
       
        //get session data
        $hotel_id = session('hotel_id');
        $hotelRepo = new HotelRepository();
        $hotel = $hotelRepo->getObjByID($hotel_id);

        $booking_number = Utility::generateBookingNumber();

        $user_id = session('customer')['id'];

        $check_in_date_session = session('check_in');
        $check_out_date_session = session('check_out');

        //change date formats to store in DB
        $check_in_date = date('Y-m-d', strtotime($check_in_date_session));
        $check_out_date = date('Y-m-d', strtotime($check_out_date_session));

        $check_in_time = $hotel->check_in_time;
        $check_out_time = $hotel->check_out_time;

        $total_payable_amount_w_extrabed  = session('total_payable_amount_w_extrabed');
        $total_payable_amount_wo_extrabed = session('total_payable_amount_wo_extrabed');
        $payable_amount                   = session('payable_amount');

        $gov_tax_amount                   = session('gov_tax_amount');
        $gov_tax                          = session('gov_tax');
        $service_tax_amount               = session('service_tax_amount');
        $service_tax                      = session('service_tax');

        $total_discount_amount            = session('total_discount_amount');


        $travel_for_work = session('travel_for_work');

        $first_cancellation_day_count = 0;
        $second_cancellation_day_count = 0;

        //start checking cancellation dates
        $hotelConfigRepo = new HotelConfigRepository();
        $h_config = $hotelConfigRepo->getConfigByHotel($hotel_id);
        if(isset($h_config) && count($h_config)>0){
            $first_cancellation_day_count = $h_config->first_cancellation_day_count;
            $second_cancellation_day_count = $h_config->second_cancellation_day_count;
        }

        //calculate the day to be charged by subtracting first_cancellation_date
        $today_date = date("Y-m-d");   //today's date
//        $check_in_date = $booking_result['object']->check_in_date;

        $date = strtotime(date("Y-m-d", strtotime($check_in_date)) . "-".$first_cancellation_day_count."days");   //date to be charged //after subtracting 1st cancellation date
        $charge_date = date("Y-m-d",$date); //re-format the date
        //end checking cancellation dates

        //Compare today date with charge_date and if today is greater than charge_date(i.e. today is within first cancellation day), charge the customer
        if($today_date >= $charge_date){
            $status = 5; //today is within cancellation date and so, user will be charged immediately and booking_status will be "complete"
        }
        else{
            $status = 2; //booking_status = "confirm"
        }

        try{
            DB::beginTransaction();

            $bookingObj = new Booking();
            $bookingObj->booking_no = $booking_number;
            $bookingObj->user_id = $user_id;
            $bookingObj->status = $status;
            $bookingObj->check_in_date = $check_in_date;
            $bookingObj->check_out_date = $check_out_date;
            $bookingObj->check_in_time = $check_in_time;
            $bookingObj->check_out_time = $check_out_time;
            $bookingObj->price_wo_tax = $total_payable_amount_w_extrabed;
            $bookingObj->price_w_tax = $payable_amount;
            $bookingObj->total_government_tax_amt = $gov_tax_amount;
            $bookingObj->total_government_tax_percentage = $gov_tax;
            $bookingObj->total_service_tax_amt = $service_tax_amount;
            $bookingObj->total_service_tax_percentage = $service_tax;
            $bookingObj->total_payable_amt = $payable_amount;
            $bookingObj->total_discount_amt = $total_discount_amount;
            $bookingObj->total_discount_percentage = 0;
            $bookingObj->hotel_id = $hotel_id;
            $bookingObj->travel_for_work = $travel_for_work;
            $bookingObj->country_id = $country;
            $bookingObj->phone      = $phone;

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
//                        $room_status = 2; //confirm
                        if($today_date >= $charge_date){
                            $room_status = 5; //today is within cancellation date and so, user will be charged immediately and room_status will be "complete"
                        }
                        else{
                            $room_status = 2; //booking_status = "confirm"
                        }

                        $remark = "";
                        $added_extra_bed = 0;
                        $extra_bed_price = 0.0;

                        //get username for each room from session
//                        $user_name = session($r_category->id . '_' . ($key + 1) . '_name');
                        $user_firstname = session($r_category->id . '_' . ($key + 1) . '_firstname');
                        $user_lastname = session($r_category->id . '_' . ($key + 1) . '_lastname');
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

                        //calculate the number of night stay
                        $difference = strtotime($check_out_date) - strtotime($check_in_date);
                        $nights     = floor($difference/(60*60*24));

                        $room_price = $r_category->price;

                        $room_price_total = $room_price * $nights;

                        //start checking discount for each room
                        //get room discount by room_category_id
                        $roomDiscountRepo = new RoomDiscountRepository();
                        $room_discount = $roomDiscountRepo->getDiscountByRoomCategory($r_category->id);

                        //initialize discount_percent and discount_amt
                        $discount_percent = 0;
                        $discount_amt = 0.00;

                        //final discount amount
                        $discount_amount = 0.00;

                        if(isset($room_discount) && count($room_discount)>0){
                            if(isset($room_discount->discount_percent) && $room_discount->discount_percent != 0){
                                $discount_percent = $room_discount->discount_percent;
                            }
                            elseif(($room_discount->discount_amount) && $room_discount->discount_amount != 0){
                                $discount_amt = $room_discount->discount_amount;
                            }
                        }

                        //if there is discount_percent, change to amount and add to discount_array
                        if($discount_percent != 0){
                            $discount_amount = ($discount_percent / 100) * $room_price_total;
                        }
                        //else if there is discount_amt, add to discount_array
                        elseif($discount_amt != 0.00){
                            $discount_amount = $discount_amt;
                        }
                        //end checking discount for each room

                        $room_payable_amount = $room_price_total - $discount_amount + $extra_bed_price;


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
                        $bookingRoomObj->number_of_night = $nights;
                        $bookingRoomObj->room_price_per_night = $r_category->price;
                        $bookingRoomObj->discount_amt = $discount_amount;
                        $bookingRoomObj->room_payable_amt = $room_payable_amount;
                        $bookingRoomObj->added_extra_bed = $added_extra_bed;
                        $bookingRoomObj->extra_bed_price = $extra_bed_price;
                        $bookingRoomObj->user_first_name = $user_firstname;
                        $bookingRoomObj->user_last_name = $user_lastname;
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
//                $bookingRequestObj->special_request = $special_request;
                $bookingRequestObj->special_request = "";  //special request is not stored in BookingRequest anymore
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
                else{
                    $communicationObj = new Communication(); //for booking_special_request table
                    $communicationObj->booking_id = $booking_id;
                    $order = Communication::whereNull('deleted_at')->max('order'); //get max order from current table
                    if($order == null){
                        $communicationObj->order = 1;
                    }
                    else{
                        $communicationObj->order = $order + 1;
                    }
                    $communicationObj->special_request = $special_request;
                    $communicationObj->type = 2;  //type 1 is admin, 2 is user

                    $communicationRepo = new CommunicationRepository();
                    $communication_result = $communicationRepo->createForFrontend($communicationObj);

                    //if communication creation fails, alert and redirect to homepage
                    if ($communication_result['aceplusStatusCode'] != ReturnMessage::OK){
                        DB::rollback();
                        alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
                        return redirect('/');
                    }
                }
            }
            //Start Stripe Payment Section
            /*    //Set your secret key: remember to change this to your live secret key in production
                //See your keys here: https://dashboard.stripe.com/account/apikeys
            Stripe::setApiKey("sk_test_pfDJKF6zoTRgCuHdPptjcgQX");

            // Token is created using Stripe.js or Checkout!
            // Get the payment token submitted by the form:
            $token = $_POST['stripeToken'];
            $email = $_POST['stripeEmail'];


            $total_amount = session('total_amount');
//            $tax = session('tax');
//            $tax_amount = session('tax_amount');
            $payable_amount = session('payable_amount');

            // Create a Customer:
            $customer = Customer::create(array(
                "email" => $email,
                "source" => $token,
            ));

            $customer_id = $customer['id']; */

            $email = $_POST['stripeEmail'];

            //create a customer
            $stripePaymentObj           = new PaymentUtility();
            $stripeCustomerResult        = $stripePaymentObj->createCustomer($_POST);

            $customer_id = $stripeCustomerResult["stripe"]["stripe_user_id"];

            //Compare today date with charge_date and if today is greater than charge_date(i.e. today is within first cancellation day), charge the customer
            if($today_date >= $charge_date){
                // Charge the Customer
//                $charge = Charge::create(array(
//                    "amount" => $payable_amount,
//                    "currency" => "usd",
//                    "customer" => $customer_id
//                ));

                //capture payment
                $stripePaymentResult        = $stripePaymentObj->capturePayment($customer_id, $payable_amount);

                $stripe_user_id = $stripePaymentResult["stripe"]["stripe_user_id"];
                $stripe_payment_id = $stripePaymentResult["stripe"]["stripe_payment_id"];
                $stripe_payment_amt = $stripePaymentResult["stripe"]["stripe_payment_amt"];
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
//                $bookingPaymentObj->payment_tax_percentage = $tax_percent;
//                $bookingPaymentObj->payment_tax_amt = $tax_amount;
                $bookingPaymentObj->total_government_tax_amt = $gov_tax_amount;
                $bookingPaymentObj->total_government_tax_percentage = $gov_tax;
                $bookingPaymentObj->total_service_tax_amt = $service_tax_amount;
                $bookingPaymentObj->total_service_tax_percentage = $service_tax;
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
                    if(isset($stripe_payment_id)){
                        $bookingPaymentStripeObj->stripe_payment_id = $stripe_payment_id;
                    }
                    if(isset($stripe_payment_amt)){
                        $bookingPaymentStripeObj->stripe_payment_amt = $stripe_payment_amt;
                    }
                    $bookingPaymentStripeObj->email = $email;

                    if($today_date >= $charge_date) {
                        $bookingPaymentStripeObj->status = 2; //2 is capture
                    }
                    else{
                        $bookingPaymentStripeObj->status = 1; //1 is create_customer
                    }
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

            $booking_id = $bookingObj->id;
//            $booking_room_id = $bookingRoomObj->id;
//            $booking_request_id = $bookingRequestObj->id;
//            $booking_payment_id = $bookingPaymentObj->id;
//            $booking_payment_stripe_id = $bookingPaymentStripeObj->id;

            //Compare today date with charge_date and if today is greater than charge_date(i.e. today is within first cancellation day), send booking COMPLETE mail
            if($today_date >= $charge_date){
                //Start sending complete email
                $email            = $bookingObj->user->email;
                $hotel_email      = $hotelConfigRepo->getEmailByHotelId($hotel_id);
                $hotel_email_str  = $hotel_email->email;
                $system_email     = "naingsoens4321@gmail.com";
                $emails           = array($email,$hotel_email_str,$system_email);
//                Mail::send('booking_cancellation_start', [], function($message) use ($emails)
//                {
//                    $subject        = "Booking Complete Email";
//                    $message->to($emails)
//                        ->subject($subject);
//                });
                $template = "booking_cancellation_start";
                $subject  = "Booking Complete Email";
                $logMessage = "created a booking";
                $mailResult = Utility::sendMail($template,$emails,$subject,$logMessage);
                if ($mailResult['aceplusStatusCode'] != ReturnMessage::OK){
                    alert()->success('Your Booking was successful, but there was a problem in sending email to you!')->persistent('OK');
                }
                else{
                    alert()->success('Congratulations! Your Booking was successful!')->persistent('OK');
                }
                //End sending complete email
            }
            //else, send booking CONFIRM mail
            else{
                //Start sending confirm email
                $email            = $bookingObj->user->email;
                $hotel_email      = $hotelConfigRepo->getEmailByHotelId($hotel_id);
                $hotel_email_str  = $hotel_email->email;
                $system_email     = "naingsoens4321@gmail.com";
                $emails           = array($email,$hotel_email_str,$system_email);
//                Mail::send('booking_cancellation_start', [], function($message) use ($emails)
//                {
//                    $subject        = "Booking Confirm Email";
//                    $message->to($emails)
//                        ->subject($subject);
//                });

                $template = "booking_cancellation_start";
                $subject  = "Booking Confirm Email";
                $logMessage = "created a booking";
                $mailResult = Utility::sendMail($template,$emails,$subject,$logMessage);
                if ($mailResult['aceplusStatusCode'] != ReturnMessage::OK){
                    alert('Your Booking was successful, but there was a problem in sending email to you!');
                }
                else{
                    alert('Congratulations! Your Booking was successful!');
                }
                //End sending confirm email
            }

            return redirect('/congratulations/'.$booking_id);
        }
        catch(\Exception $e){
            DB::rollback();
            alert()->warning('Your payment and booking was unsuccessful!')->persistent('OK');
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
        $booking_rooms = $bookingRoomRepo->getBookingRoomByBookingId($booking_id);

        $number_of_rooms = count($booking_rooms);
        $number_of_nights = $booking_rooms[0]->number_of_night; //all number_of_nights for the same booking_id are the same, so take the number_of_nights of the first booking_room
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
