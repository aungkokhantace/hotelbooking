<?php

namespace App\Http\Controllers\Setup\Hotel;

use App\Core\User\UserRepository;
use App\Core\Utility;
use App\Setup\City\CityRepository;
use App\Setup\Country\CountryRepository;
use App\Setup\HotelNearby\HotelNearbyRepository;
use App\Setup\Hotel\Hotel;
use App\Setup\Township\TownshipRepository;
use App\Setup\Hnearby\Hnearby;
use App\User;
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

            foreach($hotels as $hotel){
                if($hotel->h_type_id == 1){
                    $hotel->h_type_id = "Hotel";
                }
                elseif($hotel->h_type_id == 2){
                    $hotel->h_type_id = "Motel";
                }
                elseif($hotel->h_type_id == 3){
                    $hotel->h_type_id = "Guest House";
                }
                elseif($hotel->h_type_id == 4){
                    $hotel->h_type_id = "Inn";
                }
                else{
                    $hotel->h_type_id = "Hostel";
                }
            }

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

            $hotel_nearbyRepo     = new HotelNearbyRepository();
            $hotel_nearby     = $hotel_nearbyRepo->getObjs();

            return view('backend.hotel.hotel')->with('countries',$countries)->with('cities',$cities)
                ->with('townships',$townships)
                ->with('hotel_nearby',$hotel_nearby);
        }
        return redirect('/');
    }

    public function store(HotelEntryRequest $request)
    {
        $request->validate();
        $input              = $request->all();
        $name               = (Input::has('name')) ? Input::get('name') : "";
        $type               = (Input::has('h_type_id')) ? Input::get('h_type_id') : "";
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
            $photo_ext              = Utility::getImageExt($photo);
            $photo_name             = uniqid() . "." . $photo_ext;
            $image                  = Utility::resizeImage($photo,$photo_name,$path);
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

        //start getting hotel_admin information
        $user_name              = (Input::has('user_name')) ? trim(Input::get('user_name')) : "";
        $display_name           = (Input::has('display_name')) ? trim(Input::get('display_name')) : "";
        $user_email             = (Input::has('user_email')) ? Input::get('user_email') : "";
        $password               = (Input::has('password')) ? trim(bcrypt(Input::get('password'))) : "";
        $user_address           = (Input::has('user_address')) ? Input::get('user_address') : "";
        $role_id                = 3; //for hotel_admin
        //end getting hotel_admin information

        $userObj                        = new User();
        $userObj->user_name             = $user_name;
        $userObj->display_name          = $display_name;
        $userObj->email                 = $user_email;
        $userObj->password              = $password;
        $userObj->address               = $user_address;
        $userObj->role_id               = $role_id;

        $userRepo = new UserRepository();
        $userRepo->create($userObj);

        $paramObj                           = new Hotel();
        $paramObj->name                     = $name;
        $paramObj->h_type_id                = $type;
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
        $paramObj->admin_id                 = $userObj->id;

        $result = $this->repo->create($paramObj,$input);

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

            $hotel_nearbyRepo     = new HotelNearbyRepository();
            $hotel_nearby     = $hotel_nearbyRepo->getObjs();

            $h_nearby_places        = Hnearby::where('hotel_id',$id)->whereNull('deleted_at')->get();
            $nearby_places_count    = count($h_nearby_places) - 1;

            $admin_id = $hotel->admin_id;
            $userRepo = new UserRepository();
            $hotel_admin = $userRepo->getObjByID($admin_id);

            return view('backend.hotel.hotel')
                ->with('hotel', $hotel)
                ->with('countries',$countries)
                ->with('cities',$cities)
                ->with('townships',$townships)
                ->with('h_nearby_places',$h_nearby_places)
                ->with('nearby_places_count',$nearby_places_count)
                ->with('hotel_nearby',$hotel_nearby)
                ->with('hotel_admin',$hotel_admin);
        }
        return redirect('/backend/login');
    }

    public function update(HotelEditRequest $request){

        $request->validate();
        $input              = $request->all();
        $id                 = (Input::has('id')) ? Input::get('id') : "";

        $name               = (Input::has('name')) ? Input::get('name') : "";
        $type               = (Input::has('h_type_id')) ? Input::get('h_type_id') : "";
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

        //start getting hotel_admin information
        $user_name              = (Input::has('user_name')) ? trim(Input::get('user_name')) : "";
        $display_name           = (Input::has('display_name')) ? trim(Input::get('display_name')) : "";
        $user_email             = (Input::has('user_email')) ? Input::get('user_email') : "";
        $password               = (Input::has('password')) ? trim(bcrypt(Input::get('password'))) : "";
        $user_address           = (Input::has('user_address')) ? Input::get('user_address') : "";
//        $role_id                = 3; //for hotel_admin
        //end getting hotel_admin information

        $hotel          = $this->repo->getObjByID($id);
        $admin_id       = $hotel->admin_id;
        $userRepo = new UserRepository();
        $userObj                        = $userRepo->getObjByID($admin_id);
        $userObj->user_name             = $user_name;
        $userObj->display_name          = $display_name;
        $userObj->email                 = $user_email;
//        $userObj->password              = $password;
        $userObj->address               = $user_address;
//        $userObj->role_id               = $role_id;

        $userRepo->update($userObj);

        $paramObj                           = $this->repo->getObjByID($id);
        $paramObj->name                     = $name;
        $paramObj->h_type_id                = $type;
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

        $result = $this->repo->update($paramObj,$input);

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
