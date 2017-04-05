<?php

namespace App\Http\Controllers\Setup\City;

use App\Core\Utility;
use App\Setup\City\CityRepository;
use App\Setup\City\PopularCityRepositoryInterface;
use App\Setup\Country\CountryRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\CityEntryRequest;
use App\Backend\Infrastructure\Forms\CityEditRequest;

use App\Setup\City\City;
use App\Setup\Country\Country;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;
class PopularCityController extends Controller
{
    private $repo;

    public function __construct(PopularCityRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $cityRepo = new CityRepository();
            $cities = $cityRepo->getObjs();
            $city_count = $cityRepo->getObjs()->count();


            foreach($cities as $city){
                //set city order label to use as name and id of form elements
                $city->order_label = preg_replace('/\s/', '', strtolower($city->name))."_order";

                //check whether this city_id is already in popular_cities table
                $check_city_order = $this->repo->getOrderByCityId($city->id);

                if(isset($check_city_order) && count($check_city_order)>0){
                    //if already in popular table send that order to view
                    $city->order = $check_city_order->order;
                }
                else{
                    //else, set order to null
                    $city->order = null;
                }
            }

            return view('backend.city.popularcity')->with('cities',$cities)->with('city_count',$city_count);
        }
        return redirect('/');
    }

    public function store()
    {
        //get cities
        $cityRepo = new CityRepository();
        $cities = $cityRepo->getObjs();
        $city_count = $cityRepo->getObjs()->count();

        //set city order label to use as name and id of form elements
        foreach($cities as $cityOrder){
            $cityOrder->order_label = preg_replace('/\s/', '', strtolower($cityOrder->name))."_order";
        }

        $cityArray = array();
        foreach($cities as $cityInput){
//            $city_input_data = Input::get($cityInput->order_label);
            $city_input_data = (Input::has($cityInput->order_label)) ? Input::get($cityInput->order_label) : "";
            $cityArray[$cityInput->id] = $city_input_data;
        }

        $result = $this->repo->create($cityArray);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\City\PopularCityController@create')
                ->withMessage(FormatGenerator::message('Success', 'Popular City set ...'));
        }
        else{
            return redirect()->action('Setup\City\PopularCityController@create')
                ->withMessage(FormatGenerator::message('Fail', 'Popular City did not set ...'));
        }

    }
}
