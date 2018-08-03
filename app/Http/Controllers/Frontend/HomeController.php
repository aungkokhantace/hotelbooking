<?php
/**
 * Created by PhpStorm.
 * User: william
 * Author: Wai Yan Aung
 * Date: 1/14/2017
 * Time: 10:55 AM
 */

namespace App\Http\Controllers\Frontend;

use App\Core\Utility;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Setup\Autocomplete\AutocompleteRepository;
use App\Setup\City\CityRepository;
use App\Setup\City\PopularCityRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\Hotel\RecommendHotelRepository;
use App\Setup\RoomDiscount\RoomDiscountRepository;
use App\Setup\Slider\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Redirect;
use App\Setup\Slider\SliderRepository;
use Illuminate\Support\Facades\DB;

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

        // $sliders            = Slider::select('image_url','title','description')
        //                             ->where('template_id',$template_id)
        //                             ->whereNull('deleted_at')
        //                             ->get();

        $sliderRepo         = new SliderRepository();
        $sliders            = $sliderRepo->getSlidersByTemplateId($template_id);

        //flag for first slider image(to be active)
        $first_slider       = 1;

        /*Create Session for check_in date and check_out date*/
        $check_in           = Carbon::today()->format('d-m-Y');
        $check_out          = Carbon::tomorrow()->format('d-m-Y');
        //Firstly, delete your session
        Utility::deleteSession('check_in');
        Utility::deleteSession('check_out');
        //Then, create your session
        Utility::createSession('check_in',$check_in);
        Utility::createSession('check_out',$check_out);

        //start display information text
        //start display information text for popular destination
        $temp_data = DB::select("SELECT * FROM `display_information` WHERE `type` = 'POPULARDESTINATION' LIMIT 1");
        if(isset($temp_data) && count($temp_data)>0){
          //check locale [language]
          if(Session::has('locale') && Session::get('locale') == "jp"){
            $popular_destination_text = $temp_data[0]->text_jp;
          }
          else{
            $popular_destination_text = $temp_data[0]->text_en;
          }
        }
        else{
            $popular_destination_text = "";
        }
        //end display information text for popular destination

        //start display information text for recommended hotels
        $temp_data = DB::select("SELECT * FROM `display_information` WHERE `type` = 'RECOMMENDEDHOTEL' LIMIT 1");
        if(isset($temp_data) && count($temp_data)>0){
          //check locale [language]
          if(Session::has('locale') && Session::get('locale') == "jp"){
            $recommended_hotel_text = $temp_data[0]->text_jp;
          }
          else{
            $recommended_hotel_text = $temp_data[0]->text_en;
          }
        }
        else{
            $recommended_hotel_text = "";
        }
        //end display information text for recommended hotels

        //start display information text for promotion for this month
        $temp_data = DB::select("SELECT * FROM `display_information` WHERE `type` = 'PROMOTION' LIMIT 1");
        if(isset($temp_data) && count($temp_data)>0){
          //check locale [language]
          if(Session::has('locale') && Session::get('locale') == "jp"){
            $promotion_text = $temp_data[0]->text_jp;
          }
          else{
            $promotion_text = $temp_data[0]->text_en;
          }
        }
        else{
            $promotion_text = "";
        }
        //end display information text for promotion for this month

        //start display information text for Terms and Condition
        $temp_data = DB::select("SELECT * FROM `display_information` WHERE `type` = 'TERMS_AND_CONDITION' LIMIT 1");
        if(isset($temp_data) && count($temp_data)>0){
          //check locale [language]
          if(Session::has('locale') && Session::get('locale') == "jp"){
            $terms_and_condition_text = $temp_data[0]->text_jp;
          }
          else{
            $terms_and_condition_text = $temp_data[0]->text_en;
          }
        }
        else{
            $terms_and_condition_text = "";
        }
        //end display information text for Terms and Condition
        //end display information text

        return view('frontend.home')
//            ->with('popular_cities',$popularCityArray)
            ->with('popular_cities',$popularCityEntries)
            ->with('recommended_hotels',$recommendedHotelArray)
            ->with('percent_promotions',$percentPromotionArray)
            ->with('amount_promotions',$amountPromotionArray)
            ->with('first_slider',$first_slider)
            ->with('sliders',$sliders)
            ->with('popular_destination_text',$popular_destination_text)
            ->with('recommended_hotel_text',$recommended_hotel_text)
            ->with('promotion_text',$promotion_text)
            ->with('terms_and_condition_text',$terms_and_condition_text);
    }

    public function autocompleteDestination(){
        $autocompleteRepo = new AutocompleteRepository();
        $results = $autocompleteRepo->getDestinations();
        //sort array values alphabetically
        sort($results);
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
