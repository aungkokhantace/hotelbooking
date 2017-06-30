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

use App\Setup\Autocomplete\AutocompleteRepository;
use App\Setup\City\CityRepository;
use App\Setup\City\PopularCityRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\Hotel\RecommendHotelRepository;
use App\Setup\RoomDiscount\RoomDiscountRepository;
use App\Setup\Slider\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Redirect;

class HomeController extends Controller
{

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        //start popular cities
        $popularCityArray   = array();
        $cityRepo           = new CityRepository();
        $popularCityRepo    = new PopularCityRepository();
        $popular_cities     = $popularCityRepo->getObjs();

        foreach($popular_cities as $popular_city){
            $cityObj = $cityRepo->getObjByID($popular_city->city_id);
            $cityObj->order = $popular_city->order; //bind order to city obj
            //add city obj to city array
            array_push($popularCityArray, $cityObj);
        }
        //end popular cities

        //start paginating popular cities array
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $col = new Collection($popularCityArray);
        $perPage = 3;
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $popularCityEntries = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

        $popularCityEntries->setPath($request->url());
        $popularCityEntries->appends($request->except(['page']));
        //end paginating popular cities array

        //start recommended hotels
        $recommendedHotelArray  = array();
        $hotelRepo              = new HotelRepository();
        $recommendHotelRepo     = new RecommendHotelRepository();
        $recommend_hotels       = $recommendHotelRepo->getObjs();
        foreach($recommend_hotels as $recommend_hotel){
            $hotelObj = $hotelRepo->getObjByID($recommend_hotel->hotel_id);
            $hotelObj->order = $recommend_hotel->order; //bind order to hotel obj
            //add hotel obj to hotel array
            array_push($recommendedHotelArray, $hotelObj);
        }
        //end recommended hotels

    //start hotel promotions
        //start percentage promotions
        $percentPromotionArray = array();
        $promotionRepo  = new RoomDiscountRepository();
        $percent_promotions     = $promotionRepo->getDiscountPercentByUniqueHotel();

        foreach($percent_promotions as $percent_promotion){
            $percentPromotionHotelObj = $hotelRepo->getObjByID($percent_promotion->hotel_id);
            //bind discount percent to $promotionHotelObj
            $percentPromotionHotelObj->discount_percent = $percent_promotion->discount_percent;

            array_push($percentPromotionArray, $percentPromotionHotelObj);
        }
        //end percentage promotions

        //for assurance that hotel_ids that are already taken in percent_promotion not to be included in amount_promotion again
        $percentHotelIDs = array();
        foreach($percentPromotionArray as $percentPromo){
            array_push($percentHotelIDs,$percentPromo->id);
        }
        //for assurance that hotel_ids that are already taken in percent_promotion not to be included in amount_promotion again

        //start amount promotions
        $amountPromotionArray = array();
        $amount_promotions     = $promotionRepo->getDiscountAmountByUniqueHotel($percentHotelIDs);

        foreach($amount_promotions as $amount_promotion){
            $amountPromotionHotelObj = $hotelRepo->getObjByID($amount_promotion->hotel_id);
            //bind discount percent to $promotionHotelObj
            $amountPromotionHotelObj->discount_amount = $amount_promotion->discount_amount;

            array_push($amountPromotionArray, $amountPromotionHotelObj);
        }
        //end amount promotions
    //end hotel promotions
        //Get Slider For Home Page
        $template_id        = 1; //1 For Home Page
        $sliders            = Slider::select('image_url','title','description')->where('template_id',$template_id)->whereNull('deleted_at')->get();
        return view('frontend.home')
//            ->with('popular_cities',$popularCityArray)
            ->with('popular_cities',$popularCityEntries)
            ->with('recommended_hotels',$recommendedHotelArray)
            ->with('percent_promotions',$percentPromotionArray)
            ->with('amount_promotions',$amountPromotionArray)
            ->with('sliders',$sliders);
    }

    public function autocompleteDestination(){
        $autocompleteRepo = new AutocompleteRepository();
        $results = $autocompleteRepo->getDestinations();
        return \Response::json($results);
    }

    public function test(){
        return view('frontend.test');
    }

    public function aboutus(){
        return view('frontend.aboutus');
    }

    public function comingsoon(Request $request)
    {
        return view('frontend.comingsoon');
    }

}
