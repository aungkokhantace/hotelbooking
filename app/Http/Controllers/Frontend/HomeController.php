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

use App\Setup\City\CityRepository;
use App\Setup\City\PopularCityRepository;
use App\Setup\Hotel\HotelRepository;
use Illuminate\Http\Request;
use Redirect;

class HomeController extends Controller
{

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $popularCityArray = array();

        $cityRepo    = new CityRepository();

        $popularCityRepo    = new PopularCityRepository();
        $popular_cities     = $popularCityRepo->getObjs();
        foreach($popular_cities as $popular_city){
            $cityObj = $cityRepo->getObjByID($popular_city->city_id);
            $cityObj->order = $popular_city->order; //bind order to city obj
            //add city obj to city array
            array_push($popularCityArray, $cityObj);
        }

        $recommendHotelRepo = new HotelRepository();
        $recommend_hotels   = $recommendHotelRepo->getObjs();
        return view('frontend.home')->with('popular_cities',$popularCityArray)->with('recommend_hotels',$recommend_hotels);
    }

    public function test(){
        return view('frontend.test');
    }

}
