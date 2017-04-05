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

    /*public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $cities      = $this->repo->getObjs();
            return view('backend.city.index')->with('cities',$cities);
        }
        return redirect('/');
    }*/

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

    /*
    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $city        = City::find($id);

            $countryRepo = new CountryRepository();
            $countries   = $countryRepo->getObjs();

            return view('backend.city.city')->with('city', $city)->with('countries', $countries);
        }
        return redirect('/backend/login');
    }

    public function update(CityEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $city_name                  = Input::get('name');
        $country_id                 = Input::get('country_id');
        //Start Saving Image
        $removeImageFlag          = (Input::has('removeImageFlag')) ? Input::get('removeImageFlag') : 0;
        $path         = base_path().'/public/images/upload/';

        if(Input::hasFile('photo'))
        {
            $photo        = Input::file('photo');
            $photo_name_original    = Utility::getImage($photo);
            $photo_ext      = Utility::getImageExt($photo);
            $photo_name     = uniqid() . "." . $photo_ext;
            $image          = Utility::resizeImage($photo,$photo_name,$path);
        }
        else{
            $photo_name = "";
        }

        if($removeImageFlag == 1){
            $photo_name = "";
        }
        //End Saving Image

        $paramObj                   = City::find($id);
        $paramObj->name             = $city_name;
        $paramObj->country_id       = $country_id;
        if(Input::hasFile('photo')){
            $paramObj->image                 = $photo_name;
        }
        else{
            if($removeImageFlag == 1){
                $paramObj->image             = "";
            }
        }

        $result = $this->repo->update($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\City\CityController@index')
                ->withMessage(FormatGenerator::message('Success', 'City updated ...'));
        }
        else{

            return redirect()->action('Setup\City\CityController@index')
                ->withMessage(FormatGenerator::message('Fail', 'City did not update ...'));
        }
    }

    public function destroy(){

        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        $delete_flag = true;
        foreach($new_string as $id){
            $check = $this->repo->checkToDelete($id);
            if(isset($check) && count($check)>0){
                alert()->warning('There are townships under this city!')->persistent('OK');
                $delete_flag = false;
            }
            else{
                $this->repo->delete($id);
            }
        }
        if($delete_flag){
            return redirect()->action('Setup\City\CityController@index') //to redirect listing page
                ->withMessage(FormatGenerator::message('Success', 'Country deleted ...'));
        }
        else{
            return redirect()->action('Setup\City\CityController@index') //to redirect listing page
                ->withMessage(FormatGenerator::message('Fail', 'Country did not delete ...'));
        }
    }

    public function check_city_name(){
        $city_name     = Input::get('city_name');
        $country_id    = Input::get('country_id');
        $city          = City::where('country_id','=',$country_id)->where('city_name','=',$city_name)->whereNull('deleted_at')->get();
        $result        = false;
        if(count($city) == 0 ){
            $result = true;
        }

        return \Response::json($result);
    }
    */

}
