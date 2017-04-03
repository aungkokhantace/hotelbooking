<?php

namespace App\Http\Controllers\Setup\Hotel;

use App\Core\Utility;
use App\Setup\City\CityRepository;
use App\Setup\Country\CountryRepository;
use App\Setup\Hotel\Hotel;
use App\Setup\Township\TownshipRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\HotelEntryRequest;
use App\Backend\Infrastructure\Forms\HotelEditRequest;
use App\Setup\Hotel\HotelRepositoryInterface;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;

class HotelController extends Controller
{
    private $repo;

    public function __construct(HotelRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotels = $this->repo->getObjs();
            return view('backend.hotel.index')->with('hotels',$hotels);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $countryRepo = new CountryRepository();
            $countries = $countryRepo->getObjs();

            $cityRepo = new CityRepository();
            $cities = $cityRepo->getObjs();

            $townshipRepo = new TownshipRepository();
            $townships = $townshipRepo->getObjs();

            return view('backend.hotel.hotel')->with('countries',$countries)->with('cities',$cities)->with('townships',$townships);
        }
        return redirect('/');
    }

    public function store(HotelEntryRequest $request)
    {
        $request->validate();

        $name               = (Input::has('name')) ? Input::get('name') : "";
        $address            = (Input::has('address')) ? Input::get('address') : "";
        $phone              = (Input::has('phone')) ? Input::get('phone') : "";
        $fax                = (Input::has('fax')) ? Input::get('fax') : "";
        $latitude           = (Input::has('latitude')) ? Input::get('latitude') : "";
        $longitude          = (Input::has('longitude')) ? Input::get('longitude') : "";


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

        $star                   = (Input::has('star')) ? Input::get('star') : "";
        $email                  = (Input::has('email')) ? Input::get('email') : "";
        $country_id             = (Input::has('country_id')) ? Input::get('country_id') : "";
        $city_id                = (Input::has('city_id')) ? Input::get('city_id') : "";
        $township_id            = (Input::has('township_id')) ? Input::get('township_id') : "";
        $description            = (Input::has('description')) ? Input::get('description') : "";
        $number_of_floors       = (Input::has('number_of_floors')) ? Input::get('number_of_floors') : "";
        $hotel_class            = (Input::has('hotel_class')) ? Input::get('hotel_class') : "";
        $website                = (Input::has('website')) ? Input::get('website') : "";
        $check_in_time          = (Input::has('check_in_time')) ? Input::get('check_in_time') : "";
        $check_out_time         = (Input::has('check_out_time')) ? Input::get('check_out_time') : "";
        $breakfast_start_time   = (Input::has('breakfast_start_time')) ? Input::get('breakfast_start_time') : "";
        $breakfast_end_time     = (Input::has('breakfast_end_time')) ? Input::get('breakfast_end_time') : "";

        $paramObj                           = new Hotel();
        $paramObj->name                     = $name;
        $paramObj->address                  = $address;
        $paramObj->phone                    = $phone;
        $paramObj->fax                      = $fax;
        $paramObj->latitude                 = $latitude;
        $paramObj->longitude                = $longitude;
        $paramObj->logo                     = $photo_name;
        $paramObj->star                     = $star;
        $paramObj->email                    = $email;
        $paramObj->country_id               = $country_id;
        $paramObj->city_id                  = $city_id;
        $paramObj->township_id              = $township_id;
        $paramObj->description              = $description;
        $paramObj->number_of_floors         = $number_of_floors;
        $paramObj->class                    = $hotel_class;
        $paramObj->website                  = $website;
        $paramObj->check_in_time            = $check_in_time;
        $paramObj->check_out_time           = $check_out_time;
        $paramObj->breakfast_start_time     = $breakfast_start_time;
        $paramObj->breakfast_end_time       = $breakfast_end_time;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\Hotel\HotelController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel created ...'));
        }
        else{
            return redirect()->action('Setup\Hotel\HotelController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel = $this->repo->getObjByID($id);

            $country_id = $hotel->country_id;
            $city_id = $hotel->city_id;
            $township_id = $hotel->township_id;

            $countryRepo = new CountryRepository();
            $countries = $countryRepo->getObjs();

            $cityRepo = new CityRepository();
            $cities = $cityRepo->getCityByCountryId($country_id);

            $townshipRepo = new TownshipRepository();
            $townships = $townshipRepo->getTownshipByCityId($city_id);

            return view('backend.hotel.hotel')->with('hotel', $hotel)->with('countries',$countries)->with('cities',$cities)->with('townships',$townships);
        }
        return redirect('/backend/login');
    }

    public function update(HotelEditRequest $request){

        $request->validate();
        $id                 = (Input::has('id')) ? Input::get('id') : "";

        $name               = (Input::has('name')) ? Input::get('name') : "";
        $address            = (Input::has('address')) ? Input::get('address') : "";
        $phone              = (Input::has('phone')) ? Input::get('phone') : "";
        $fax                = (Input::has('fax')) ? Input::get('fax') : "";
        $latitude           = (Input::has('latitude')) ? Input::get('latitude') : "";
        $longitude          = (Input::has('longitude')) ? Input::get('longitude') : "";


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

        $star                   = (Input::has('star')) ? Input::get('star') : "";
        $email                  = (Input::has('email')) ? Input::get('email') : "";
        $country_id             = (Input::has('country_id')) ? Input::get('country_id') : "";
        $city_id                = (Input::has('city_id')) ? Input::get('city_id') : "";
        $township_id            = (Input::has('township_id')) ? Input::get('township_id') : "";
        $description            = (Input::has('description')) ? Input::get('description') : "";
        $number_of_floors       = (Input::has('number_of_floors')) ? Input::get('number_of_floors') : "";
        $hotel_class            = (Input::has('hotel_class')) ? Input::get('hotel_class') : "";
        $website                = (Input::has('website')) ? Input::get('website') : "";
        $check_in_time          = (Input::has('check_in_time')) ? Input::get('check_in_time') : "";
        $check_out_time         = (Input::has('check_out_time')) ? Input::get('check_out_time') : "";
        $breakfast_start_time   = (Input::has('breakfast_start_time')) ? Input::get('breakfast_start_time') : "";
        $breakfast_end_time     = (Input::has('breakfast_end_time')) ? Input::get('breakfast_end_time') : "";

        $paramObj                           = $this->repo->getObjByID($id);
        $paramObj->name                     = $name;
        $paramObj->address                  = $address;
        $paramObj->phone                    = $phone;
        $paramObj->fax                      = $fax;
        $paramObj->latitude                 = $latitude;
        $paramObj->longitude                = $longitude;

        if(Input::hasFile('photo')){
            $paramObj->logo                 = $photo_name;
        }
        else{
            if($removeImageFlag == 1){
                $paramObj->logo             = "";
            }
        }

        $paramObj->star                     = $star;
        $paramObj->email                    = $email;
        $paramObj->country_id               = $country_id;
        $paramObj->city_id                  = $city_id;
        $paramObj->township_id              = $township_id;
        $paramObj->description              = $description;
        $paramObj->number_of_floors         = $number_of_floors;
        $paramObj->class                    = $hotel_class;
        $paramObj->website                  = $website;
        $paramObj->check_in_time            = $check_in_time;
        $paramObj->check_out_time           = $check_out_time;
        $paramObj->breakfast_start_time     = $breakfast_start_time;
        $paramObj->breakfast_end_time       = $breakfast_end_time;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\Hotel\HotelController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel updated ...'));
        }
        else{
            return redirect()->action('Setup\Hotel\HotelController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\Hotel\HotelController@index'); //to redirect listing page
    }

    public function getCities($country_id){
        $cities = DB::table('cities')->where('country_id', $country_id)->whereNull('deleted_at')->get();
        return \Response::json($cities);
    }

    public function getTownships($city_id){
        $townships = DB::table('townships')->where('city_id', $city_id)->whereNull('deleted_at')->get();
        return \Response::json($townships);
    }
}
