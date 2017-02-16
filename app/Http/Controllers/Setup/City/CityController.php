<?php

namespace App\Http\Controllers\Setup\City;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\CityEntryRequest;
use App\Backend\Infrastructure\Forms\CityEditRequest;
use App\Setup\City\CityRepositoryInterface;
use App\Setup\City\City;
use App\Setup\Country\Country;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;
class CityController extends Controller
{
    private $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $cities = City::all();
            return view('backend.city.index')->with('cities',$cities);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $countries = Country::lists('countries_name','id');

            return view('backend.city.city')->with('countries',$countries);
        }
        return redirect('/');
    }

    public function store(CityEntryRequest $request)
    {

        $request->validate();
        $city_name       = Input::get('city_name');
        $country_id      = Input::get('country_id');

        $paramObj = new City();
        $paramObj->city_name     = $city_name;
        $paramObj->country_id    = $country_id;

        $result = $this->cityRepository->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\City\CityController@index')
                ->withMessage(FormatGenerator::message('Success', 'City created ...'));
        }
        else{

            return redirect()->action('Setup\City\CityController@index')
                ->withMessage(FormatGenerator::message('Fail', 'City did not created ...'));
        }

    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $city      = City::find($id);
            $countries = Country::all();
            return view('backend.city.city')->with('city', $city)->with('countries', $countries);
        }
        return redirect('/backend/login');
    }

    public function update(CityEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $city_name                  = Input::get('city_name');
        $country_id                 = Input::get('country_id');
        $paramObj                   = City::find($id);
        $paramObj->city_name        = $city_name;
        $paramObj->country_id       = $country_id;

        $result = $this->cityRepository->update($paramObj);
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
        foreach($new_string as $id){
            $this->cityRepository->delete($id);
        }
        return redirect()->action('Setup\City\CityController@index'); //to redirect listing page
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

}
