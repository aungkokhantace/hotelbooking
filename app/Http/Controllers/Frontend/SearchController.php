<?php
/**
 * Created by PhpStorm.
 * User: william
 * Author: Wai Yan Aung
 * Date: 1/14/2017
 * Time: 10:55 AM
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Setup\Hotel\Hotel;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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
        $destination    = (Input::has('destination')) ? Input::get('destination') : "";
        $check_in       = (Input::has('check_in')) ? Input::get('check_in') : "";
        $check_out      = (Input::has('check_out')) ? Input::get('check_out') : "";
        $room           = (Input::has('destination')) ? Input::get('room') : "";
        $adults         = (Input::has('adults')) ? Input::get('adults') : "";
        $children       = (Input::has('children')) ? Input::get('children') : "";

        //start hotel search result
        $hotelRepo  = new HotelRepository();
        $hotels     = $hotelRepo->getHotelsByDestination($destination); //search hotel by destination keyword

        $hRoomCategoryRepo = new HotelRoomCategoryRepository();
        foreach($hotels  as $hotel){
            $minRoomCategoryPrice = $hRoomCategoryRepo->getMinPriceByHotelId($hotel->id);
            $hotel->min_price = $minRoomCategoryPrice; //get mininum price to show in search result

            if(isset($minRoomCategoryPrice) && $minRoomCategoryPrice != null){
                $minRoomCategoryPrice = $hRoomCategoryRepo->getRoomTypeByHotelIdAndPrice($hotel->id,$minRoomCategoryPrice);
                $hotel->room_type = $minRoomCategoryPrice; //get room type with minimum price to show in search result
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

        $suggestedHotels= $hotelRepo->getSuggestedHotelsByDestination($hotelIdArr,$countryIdArr,$cityIdArr,$townshipIdArr); //get suggested hotels

        foreach($suggestedHotels  as $sugg_hotel){
            $minRoomCategoryPrice = $hRoomCategoryRepo->getMinPriceByHotelId($sugg_hotel->id);
            $sugg_hotel->min_price = $minRoomCategoryPrice; //get mininum price to show in search result

            if(isset($minRoomCategoryPrice) && $minRoomCategoryPrice != null){
                $minRoomCategoryPrice = $hRoomCategoryRepo->getRoomTypeByHotelIdAndPrice($sugg_hotel->id,$minRoomCategoryPrice);
                $sugg_hotel->room_type = $minRoomCategoryPrice; //get room type with minimum price to show in search result
            }
            else{
                $sugg_hotel->room_type = null;
            }
        }

        //end suggested hotels

        return view('frontend.searchresult')->with('hotels', $hotels)->with('suggestedHotels', $suggestedHotels);
    }
}
