<?php
/**
 * Created by PhpStorm.
 * User: william
 * Author: Wai Yan Aung
 * Date: 1/14/2017
 * Time: 10:55 AM
 */

namespace App\Http\Controllers\Frontend;

use App\Payment\PaymentConstance;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Setup\Facilities\FacilitiesRepository;
use App\Setup\Hotel\Hotel;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelFacility\HotelFacilityRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\Landmark\LandmarkRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Core\Utility;

//use Redirect;

class SearchController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $hotelRepo  = new HotelRepository();
        $hotels     = $hotelRepo->getObjs();
        return view('frontend.searchresult')->with('hotels', $hotels);
    }

    public function search(Request $request)
    {
        $destination            = (Input::has('destination')) ? Input::get('destination') : "";
        $check_in               = (Input::has('check_in')) ? Input::get('check_in') : "";
        $check_out              = (Input::has('check_out')) ? Input::get('check_out') : "";
        $room                   = (Input::has('room')) ? Input::get('room') : "";
        $adults                 = (Input::has('adults')) ? Input::get('adults') : "";
        $children               = (Input::has('children')) ? Input::get('children') : "";

        $price_filter           = (Input::has('price_filter')) ? Input::get('price_filter') : "";
        $star_filter            = (Input::has('star_filter')) ? Input::get('star_filter') : "";
        $facility_filter        = (Input::has('facility_filter')) ? Input::get('facility_filter') : "";
        $landmark_filter        = (Input::has('landmark_filter')) ? Input::get('landmark_filter') : "";

        if($request->isMethod('post')){
            Session::forget('destination');
            Session::forget('check_in');
            Session::forget('check_out');
            Session::forget('room');
            Session::forget('adults');
            Session::forget('children');
            Session::forget('price_filter');
            Session::forget('star_filter');
            Session::forget('facility_filter');
            Session::forget('landmark_filter');

        }
        else{
            $destination        = Session::get('destination');
            $check_in           = Session::get('check_in');
            $check_out          = Session::get('check_out');
            $room               = Session::get('room');
            $adults             = Session::get('adults');
            $children           = Session::get('children');
            $price_filter       = Session::get('price_filter');
            $star_filter        = Session::get('star_filter');
            $facility_filter    = Session::get('facility_filter'); 
            $landmark_filter    = Session::get('landmark_filter');
        }
        
        if(isset($destination) && $destination != null && $destination != ""){
            // session(['destination' => $destination]);
            Session::put('destination',$destination);
        }
        if(isset($check_in) && $check_in != null && $check_in != ""){
            // session(['check_in' => $check_in]);
            Session::put('check_in',$check_in);
        }
        if(isset($check_out) && $check_out != null && $check_out != ""){
            // session(['check_out' => $check_out]);
            Session::put('check_out',$check_out);
        }
        if(isset($room) && $room != null && $room != ""){
            // session(['room' => $room]);
            Session::put('room',$room);
        }
        if(isset($adults) && $adults != null && $adults != ""){
            // session(['adults' => $adults]);
            Session::put('adults',$adults);
        }
        if(isset($children) && $children != null && $children != ""){
            // session(['children' => $children]);
            Session::put('children',$children);
        }
        if(isset($price_filter) && $price_filter != null && $price_filter != ""){
            // session(['price_filter' => $price_filter]);
            Session::put('price_filter',$price_filter);
        }
        if(isset($star_filter) && $star_filter != null && $star_filter != ""){
            // session(['star_filter' => $star_filter]);
            Session::put('star_filter',$star_filter);
        }
        if(isset($facility_filter) && $facility_filter != null && count($facility_filter)>0){
            foreach($facility_filter as $facility){
                Session::push('facility_filter',$facility);
            }
        }
        if(isset($landmark_filter) && $landmark_filter != null && count($landmark_filter)>0){
            foreach($landmark_filter as $landmark){
                Session::push('landmark_filter',$landmark);
            }
        }

        //start hotel search result
        $hotelRepo  = new HotelRepository();
//        $hotels     = $hotelRepo->getHotelsByDestination($destination); //search hotel by destination keyword
        $hotels     = $hotelRepo->getHotelsByFilters($destination,$price_filter,$star_filter,$facility_filter,$landmark_filter); //search hotel by filters
        $hRoomCategoryRepo = new HotelRoomCategoryRepository();
        foreach($hotels  as $hotel){
            $minRoomCategoryPrice = $hRoomCategoryRepo->getMinPriceByHotelId($hotel->id);
            $hotel->min_price = $minRoomCategoryPrice; //get mininum price to show in search result

            if(isset($minRoomCategoryPrice) && $minRoomCategoryPrice != null){
//                $minRoomCategoryPrice = $hRoomCategoryRepo->getRoomTypeByHotelIdAndPrice($hotel->id,$minRoomCategoryPrice);
                $roomCategoryWithMinPrice = $hRoomCategoryRepo->getRoomTypeByHotelIdAndPrice($hotel->id,$minRoomCategoryPrice);
                $hotel->room_type = $roomCategoryWithMinPrice; //get room type with minimum price to show in search result
            }
            else{
                $hotel->room_type = null;
            }
        }
        //end hotel search result

        //start suggested hotels

        //create hotel_id array
        $hotelIdArr = array();
        $countryIdArr = array();
        $cityIdArr = array();
        $townshipIdArr = array();
        $hotelFacilityArr = array();

        foreach($hotels as $suggested_hotel){
            array_push($hotelIdArr,$suggested_hotel->id);
            array_push($countryIdArr,$suggested_hotel->country_id);
            array_push($cityIdArr,$suggested_hotel->city_id);
            array_push($townshipIdArr,$suggested_hotel->township_id);
        }

        $hotelIdArr = array_unique($hotelIdArr); //remove duplicate indexes
        $hotelIdArr = array_values($hotelIdArr); //re-index array after using array_unique function

        $countryIdArr = array_unique($countryIdArr);  //remove duplicate indexes
        $countryIdArr = array_values($countryIdArr); //re-index array after using array_unique function

        $cityIdArr = array_unique($cityIdArr);  //remove duplicate indexes
        $cityIdArr = array_values($cityIdArr); //re-index array after using array_unique function

        $townshipIdArr = array_unique($townshipIdArr);  //remove duplicate indexes
        $townshipIdArr = array_values($townshipIdArr); //re-index array after using array_unique function

        $suggestedHotels= $hotelRepo->getSuggestedHotelsByDestination($hotelIdArr,$countryIdArr,$cityIdArr,$townshipIdArr);
        // dd($suggestedHotels); //get suggested hotels

        foreach($suggestedHotels  as $sugg_hotel){
            $minRoomCategoryPrice = $hRoomCategoryRepo->getMinPriceByHotelId($sugg_hotel->id);
            $sugg_hotel->min_price = $minRoomCategoryPrice; //get mininum price to show in search result

            if(isset($minRoomCategoryPrice) && $minRoomCategoryPrice != null){
//                $minRoomCategoryPrice = $hRoomCategoryRepo->getRoomTypeByHotelIdAndPrice($sugg_hotel->id,$minRoomCategoryPrice);
                $roomCategoryWithMinPrice = $hRoomCategoryRepo->getRoomTypeByHotelIdAndPrice($sugg_hotel->id,$minRoomCategoryPrice);
                $sugg_hotel->room_type = $roomCategoryWithMinPrice; //get room type with minimum price to show in search result
            }
            else{
                $sugg_hotel->room_type = null;
            }
        }
        //end suggested hotels

        //start getting facilities
        $facilityRepo = new FacilitiesRepository();
        $facilities   = $facilityRepo->getObjs();
        //end getting facilities

        //start getting landmarks
        $landmarkRepo = new LandmarkRepository();
        $landmarks    = $landmarkRepo->getObjs();
        //end getting landmarks

        //start getting hotel facility
        $hotelFacilityRepo  = new HotelFacilityRepository();
        $hotelFacilities    = $hotelFacilityRepo->getHotelFacilitiesByHotelIDArr($hotelIdArr);
    

        foreach($hotels as $hotel){
            $count = 0;
            foreach($hotelFacilities as $hFacility){
                if($hotel->id == $hFacility->hotel_id && $count < 3){
                    array_push($hotelFacilityArr,$hFacility);
                    $count++;
                }
            }
            $hotel->hotelFacilities     = $hotelFacilityArr;
            $hotelFacilityArr           = array();
        }
        
        //end getting hotel facility

        $price_filters                  = Utility::getPriceFilter();

        return view('frontend.searchresult')
            ->with('hotels', $hotels)
            ->with('suggestedHotels', $suggestedHotels)
            ->with('destination', $destination)
            ->with('facilities', $facilities)
            ->with('landmarks', $landmarks)
            ->with('price_filters',$price_filters);
    }

    public function getLocations()
    {
        //get parameters
        $destination     = (Input::has('destination')) ? Input::get('destination') : "";
        $price_filter    = (Input::has('price_filter')) ? Input::get('price_filter') : "";
        $star_filter     = (Input::has('star_filter')) ? Input::get('star_filter') : "";
        $facility_filter = (Input::has('facility_filter')) ? Input::get('facility_filter') : "";
        $landmark_filter = (Input::has('landmark_filter')) ? Input::get('landmark_filter') : "";

        //convert string parameters from ajax call back to array format (only parameters that are JSON.stringify)
        $price_filter = json_decode($price_filter, true);
        $star_filter  = json_decode($star_filter, true);
        $facility_filter = json_decode($facility_filter, true);
        $landmark_filter = json_decode($landmark_filter, true);

        //start hotel search result
        $hotelRepo  = new HotelRepository();
//        $hotels     = $hotelRepo->getHotelsByDestination($destination); //search hotel by destination keyword

        $hotels     = $hotelRepo->getHotelsByFilters($destination,$price_filter,$star_filter,$facility_filter,$landmark_filter); //search hotel by filters

        $result     = array();
        $index      = 0;

        $hRoomCategoryRepo = new HotelRoomCategoryRepository();

        foreach($hotels as $hotel){
            //start getting minimum price for each hotel
            $minRoomCategoryPrice = $hRoomCategoryRepo->getMinPriceByHotelId($hotel->id);
            if(isset($minRoomCategoryPrice) && $minRoomCategoryPrice != null){
                $hotel->min_price = 'MMK '.$minRoomCategoryPrice; //get mininum price to show in search result
            }
            else{
                $hotel->min_price = null; //set minimum price null
            }

            //end getting minimum price for each hotel

            $result[$index][0] = '<a href="/hotel_detail/'.$hotel->id.'"><img src="/images/upload/'.$hotel->logo.'" style="width:300px;height:180px;"></a>'.'<br/>'
                                    .'<h3>'.$hotel->name.'</h3>'
                                    .$hotel->address.'<br/>'
                                    .'<b>'.$hotel->min_price.'</b>';
            $result[$index][1] = $hotel->latitude;
            $result[$index][2] = $hotel->longitude;
            $index++;
        }
        //end hotel search result

        return response()->json($result);
    }

}
