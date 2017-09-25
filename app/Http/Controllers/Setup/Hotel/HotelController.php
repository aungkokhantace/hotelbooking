<?php

namespace App\Http\Controllers\Setup\Hotel;

use App\Core\User\UserRepository;
use App\Core\Utility;
use App\Setup\City\CityRepository;
use App\Setup\Country\CountryRepository;
use App\Setup\Facilities\FacilitiesRepository;
use App\Setup\Feature\FeatureRepository;
use App\Setup\HotelConfig\HotelConfig;
use App\Setup\HotelConfig\HotelConfigRepository;
use App\Setup\HotelFacility\HotelFacility;
use App\Setup\HotelFeature\HotelFeature;
use App\Setup\HotelLandmark\HotelLandmark;
use App\Setup\HotelLandmark\HotelLandmarkRepository;
use App\Setup\HotelNearby\HotelNearby;
use App\Setup\HotelNearby\HotelNearbyRepository;
use App\Setup\Hotel\Hotel;
use App\Setup\Landmark\Landmark;
use App\Setup\Landmark\LandmarkRepository;
use App\Setup\Township\TownshipRepository;
use App\Setup\Hnearby\Hnearby;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\HotelEntryRequest;
use App\Backend\Infrastructure\Forms\HotelEditRequest;
use App\Setup\Hotel\HotelRepositoryInterface;


use Illuminate\Support\Facades\Auth;
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

            $hotel_configsRepo =  new HotelConfigRepository();
            $hotel_configs = $hotel_configsRepo->getObjs();

            $landmarkRepo       = new LandmarkRepository();
            $landmarks          = $landmarkRepo->getObjs();

            $facilityRepo       = new FacilitiesRepository();
            $facilities         = $facilityRepo->getObjsForHotel();

            $featureRepo= new FeatureRepository();
            $features   = $featureRepo->getObjs();

            return view('backend.hotel.hotel')->with('countries',$countries)->with('cities',$cities)
                ->with('townships',$townships)
                ->with('hotel_nearby',$hotel_nearby)
                ->with('hotel_configs',$hotel_configs)
                ->with('landmarks',$landmarks)
                ->with('facilities',$facilities)
                ->with('features',$features);
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
            // $image                  = Utility::resizeImage($photo,$photo_name,$path);
            $imgWidth               = 340;
            $imgHeight              = 260;
            $image                  = Utility::resizeImageWithDefaultWidthHeight($photo,$photo_name,$path,$imgWidth,$imgHeight);
        }
        else{
            $photo_name = "";
        }

        if($removeImageFlag == 1){
            $photo_name = "";
        }
        //End Saving Image

        $star                   = (Input::has('star')) ? Input::get('star') : "";
//        $email                  = (Input::has('email')) ? Input::get('email') : "";
        $email                  = (Input::has('user_email')) ? Input::get('user_email') : "";
        $country_id             = (Input::has('country_id')) ? Input::get('country_id') : "";
        $city_id                = (Input::has('city_id')) ? Input::get('city_id') : "";
        $township_id            = (Input::has('township_id')) ? Input::get('township_id') : "";
        $description            = (Input::has('description')) ? Input::get('description') : "";
        $number_of_floors       = (Input::has('number_of_floors')) ? Input::get('number_of_floors') : "";
        // $hotel_class            = (Input::has('hotel_class')) ? Input::get('hotel_class') : "";
        $website                = (Input::has('website')) ? Input::get('website') : "";
        $check_in_time          = (Input::has('check_in_time')) ? Input::get('check_in_time') : "";
        $check_out_time         = (Input::has('check_out_time')) ? Input::get('check_out_time') : "";
        $breakfast_start_time   = (Input::has('breakfast_start_time')) ? Input::get('breakfast_start_time') : "";
        $breakfast_end_time     = (Input::has('breakfast_end_time')) ? Input::get('breakfast_end_time') : "";

        //start getting hotel_admin information
        $user_name              = (Input::has('user_name')) ? trim(Input::get('user_name')) : "";
        $display_name           = (Input::has('display_name')) ? trim(Input::get('display_name')) : "";
//        $user_email             = (Input::has('user_email')) ? Input::get('user_email') : "";
        $password               = (Input::has('password')) ? trim(bcrypt(Input::get('password'))) : "";
        $user_address           = (Input::has('user_address')) ? Input::get('user_address') : "";
        $role_id                = 3; //for hotel_admin
        //end getting hotel_admin information

        //start getting hotel config info
        $first_cancellation_day     = (Input::has('first_cancellation_day')) ? Input::get('first_cancellation_day') : "";
        $second_cancellation_day    = (Input::has('second_cancellation_day')) ? Input::get('second_cancellation_day') : "";
        $breakfast_fees             = (Input::has('breakfast_fees')) ? Input::get('breakfast_fees') : "";
        $tax                        = (Input::has('tax')) ? Input::get('tax') : "";
        //end getting hotel config info

        //start getting landmark
        $landmark = (Input::has('landmark')) ? Input::get('landmark') : "";
        $landmarkAry = array();
        $landmark_count = count($landmark);
        for($l=0;$l<$landmark_count;$l++){
            if($landmark != ""){
                $landmarkAry[$l]['landmark'] = $landmark[$l];
            }else{
                $landmarkAry[$l]['landmark'] = "";
            }

        }
        //end getting landmark

        //start getting hotel nearby
        $nearby_place = (Input::has('nearby_place')) ? Input::get('nearby_place') : "";


        if($nearby_place == ""){
            $nearby_place = (Input::has('nearby_place')) ? Input::get('nearby_place') : "";
            $nearby_distance = (Input::has('$nearby_distance_'.$nearby_place)) ? Input::get('$nearby_distance_'.$nearby_place) : "";
        }else {
            $nearby_distance = array();
            foreach ($nearby_place as $n_place) {
                $nearby_distance_temp = (Input::has('nearby_distance_' . $n_place)) ? Input::get('nearby_distance_' . $n_place) : "";
                array_push($nearby_distance, $nearby_distance_temp);
            }
        }

        $nearby_mainAry = array();
        $nearby_count = count($nearby_place);


        for($n=0;$n<$nearby_count;$n++){
            if($nearby_place != ""){
                $nearby_mainAry[$n]['nearby_place']= $nearby_place[$n];
            }else{
                $nearby_mainAry[$n]['nearby_place']= "";
            }
            if($nearby_distance != ""){
                $nearby_mainAry[$n]['nearby_distance'] = $nearby_distance[$n];
            }else{
                $nearby_mainAry[$n]['nearby_distance'] = "";
            }
        }
        //end getting hotel nearby

        //start getting hotel feature
        $feature_id = (Input::has('feature_id')) ? Input::get('feature_id') : "";

        if($feature_id == ""){
            $qty = (Input::has('qty_'.$feature_id)) ? Input::get('qty_'.$feature_id) : "";
            $capacity = (Input::has('capacity_'.$feature_id)) ? Input::get('capacity_'.$feature_id) : "";
            $area = (Input::has('area_'.$feature_id)) ? Input::get('area_'.$feature_id) : "";
            $open_hour = (Input::has('open_hour_'.$feature_id)) ? Input::get('open_hour_'.$feature_id) : "";
            $close_hour = (Input::has('close_hour_'.$feature_id)) ? Input::get('close_hour_'.$feature_id) : "";
            $remark = (Input::has('remark_'.$feature_id)) ? Input::get('remark_'.$feature_id) : "";
        }else{
            $qty = array();
            foreach($feature_id as $f_id){
                $qty_temp = (Input::has('qty_'.$f_id)) ? Input::get('qty_'.$f_id) : "";
                array_push($qty,$qty_temp);
            }
            $capacity = array();
            foreach($feature_id as $f_id){
                $capacity_temp = (Input::has('capacity_'.$f_id)) ? Input::get('capacity_'.$f_id) : "";
                array_push($capacity,$capacity_temp);
            }
            $area = array();
            foreach($feature_id as $f_id){
                $area_temp = (Input::has('area_'.$f_id)) ? Input::get('area_'.$f_id) : "";
                array_push($area,$area_temp);
            }
            $open_hour = array();
            foreach($feature_id as $f_id){
                $open_hour_temp = (Input::has('open_hour_'.$f_id)) ? Input::get('open_hour_'.$f_id) : "";
                array_push($open_hour,$open_hour_temp);
            }
            $close_hour = array();
            foreach($feature_id as $f_id){
                $close_hour_temp = (Input::has('close_hour_'.$f_id)) ? Input::get('close_hour_'.$f_id) : "";
                array_push($close_hour,$close_hour_temp);
            }
            $remark = array();
            foreach($feature_id as $f_id){
                $remark_temp = (Input::has('remark_'.$f_id)) ? Input::get('remark_'.$f_id) : "";
                array_push($remark,$remark_temp);
            }
        }

        $h_feature_mainAry = array();
        $h_feature_count = count($feature_id);

        for($fe=0;$fe<$h_feature_count;$fe++){
            if($feature_id != ""){
                $h_feature_mainAry[$fe]['feature_id'] = $feature_id[$fe];
            }else{
                $h_feature_mainAry[$fe]['feature_id'] = "";
            }
            if($feature_id != ""){
                $h_feature_mainAry[$fe]['qty'] = $qty[$fe];
            }else{
                $h_feature_mainAry[$fe]['qty'] = "";
            }
            if($feature_id != "") {
                $h_feature_mainAry[$fe]['capacity'] = $capacity[$fe];
            }else{
                $h_feature_mainAry[$fe]['capacity'] = "";
            }
            if($feature_id != "") {
                $h_feature_mainAry[$fe]['area'] = $area[$fe];
            }else{
                $h_feature_mainAry[$fe]['area'] = "";
            }
            if($feature_id != "") {
                $h_feature_mainAry[$fe]['open_hour'] = $open_hour[$fe];
            }else{
                $h_feature_mainAry[$fe]['open_hour'] = "";
            }
            if($feature_id != "") {
                $h_feature_mainAry[$fe]['close_hour'] = $close_hour[$fe];
            }else{
                $h_feature_mainAry[$fe]['close_hour'] = "";
            }
            if($feature_id != "") {
                $h_feature_mainAry[$fe]['remark'] = $remark[$fe];
            }else{
                $h_feature_mainAry[$fe]['remark'] = "";
            }
        }

        //end start getting hotel feature

        //start getting hotel facility
        $facility = (Input::has('facility')) ? Input::get('facility') : "";
        $facility_mainAry = array();
        $facility_count = count($facility);

        for($f=0;$f<$facility_count;$f++){
            if($facility != ""){
                $facility_mainAry[$f]['facility'] = $facility[$f];
            }else{
                $facility_mainAry[$f]['facility'] = "";
            }

        }
        //end getting hotel facility

        DB::beginTransaction();
        $userObj                        = new User();
        $userObj->user_name             = $user_name;
        $userObj->display_name          = $display_name;
//        $userObj->email                 = $user_email;
        $userObj->email                 = $email;
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
        // $paramObj->class                    = $hotel_class;
        $paramObj->website                  = $website;
        $paramObj->check_in_time            = $check_in_time;
        $paramObj->check_out_time           = $check_out_time;
        $paramObj->breakfast_start_time     = $breakfast_start_time;
        $paramObj->breakfast_end_time       = $breakfast_end_time;
        $paramObj->admin_id                 = $userObj->id;



        $result = $this->repo->create($paramObj);


        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            $hotel_configObj = new HotelConfig();
            $hotel_configObj->hotel_id =$paramObj->id;
            $hotel_configObj->first_cancellation_day_count  = $first_cancellation_day;
            $hotel_configObj->second_cancellation_day_count = $second_cancellation_day;
            $hotel_configObj->breakfast_fees   = $breakfast_fees;
            $hotel_configObj->tax              = $tax;
            $hotel_configResult = $this->repo->create($hotel_configObj);

            $landmarkResult = array();
            if($hotel_configResult['aceplusStatusCode'] == ReturnMessage::OK){
//                DB::commit();
                if($landmark != ""){
                    foreach($landmarkAry as $land_ary){
                        $landmarkObj = new HotelLandmark();
                        $landmarkObj->hotel_id = $paramObj->id;
                        $landmarkObj->landmark_id = $land_ary['landmark'];
                        $landmarkResult = $this->repo->create($landmarkObj);
                    }
                }else{
                    $landmarkResult['aceplusStatusCode'] = ReturnMessage::OK;
                }

                $h_nearby_result = array();
                if($landmarkResult['aceplusStatusCode'] == ReturnMessage::OK){
                    if($nearby_place != ""){
                        foreach($nearby_mainAry as $nearby_ary){
                            $h_nearbyObj = new Hnearby();
                            $h_nearbyObj->hotel_id = $paramObj->id;
                            $h_nearbyObj->nearby_id = $nearby_ary['nearby_place'];
                            $h_nearbyObj->km = $nearby_ary['nearby_distance'];
                            $h_nearby_result = $this->repo->create($h_nearbyObj);
                        }
                    }else{
                        $h_nearby_result['aceplusStatusCode'] = ReturnMessage::OK;
                    }
                    $h_feature_result = array();
                   if($h_nearby_result['aceplusStatusCode'] == ReturnMessage::OK){
//                       DB::commit();
                       if($feature_id != ""){
                           foreach($h_feature_mainAry as $h_feature){
                               $h_featureObj = new HotelFeature();
                               $h_featureObj->hotel_id = $paramObj->id;
                               $h_featureObj->feature_id = $h_feature['feature_id'];
                               $h_featureObj->qty = $h_feature['qty'];
                               $h_featureObj->capacity = $h_feature['capacity'];
                               $h_featureObj->area = $h_feature['area'];
                               $h_featureObj->open_hour = $h_feature['open_hour'];
                               $h_featureObj->close_hour = $h_feature['close_hour'];
                               $h_featureObj->remark = $h_feature['remark'];
                               $h_feature_result = $this->repo->create($h_featureObj);
                           }
                       }else{
                           $h_feature_result['aceplusStatusCode'] = ReturnMessage::OK;
                       }

                       $h_facility_result = array();
                       if($h_feature_result['aceplusStatusCode'] == ReturnMessage::OK){
//                           DB::commit();
                           if($facility != ""){
                               foreach($facility_mainAry as $facility_ary){
                                   $h_facilityObj = new HotelFacility();
                                   $h_facilityObj->hotel_id = $paramObj->id;
                                   $h_facilityObj->facility_id = $facility_ary['facility'];
                                   $h_facility_result = $this->repo->create($h_facilityObj);
                               }
                           }else{
                               $h_facility_result['aceplusStatusCode'] = ReturnMessage::OK;
                           }
                           if($h_facility_result['aceplusStatusCode'] == ReturnMessage::OK){
                               DB::commit();
                               return redirect()->action('Setup\Hotel\HotelController@index')
                                   ->withMessage(FormatGenerator::message('Success', 'Hotel created ...'));
                           }
                       }else{
                           DB::rollback();
                           return redirect()->action('Setup\Hotel\HotelController@index')
                               ->withMessage(FormatGenerator::message('Fail', 'Hotel did not create ...'));
                       }

                   }else{
                       DB::rollback();
                       return redirect()->action('Setup\Hotel\HotelController@index')
                           ->withMessage(FormatGenerator::message('Fail', 'Hotel did not create ...'));
                   }
//                    DB::commit();

                }else{
                    DB::rollback();
                    return redirect()->action('Setup\Hotel\HotelController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Hotel did not create ...'));
                }

            }else{
                DB::rollback();
                return redirect()->action('Setup\Hotel\HotelController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel did not create ...'));
            }
        }
        else{
            DB::rollback();
            return redirect()->action('Setup\Hotel\HotelController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel = $this->repo->getObjByID($id);
            $h_id = $hotel->id;
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

            $hotel_configsRepo =  new HotelConfigRepository();
            $hotel_configs = $hotel_configsRepo->getObjs();

            $landmarkRepo       = new LandmarkRepository();
            $landmarks          = $landmarkRepo->getObjs();

            $facilityRepo       = new FacilitiesRepository();
            $facilities         = $facilityRepo->getObjsForHotel();

            $featureRepo= new FeatureRepository();
            $features   = $featureRepo->getObjs();

            foreach ($landmarks as $landmark) {
                $h_landmarks = DB::select("SELECT landmark_id FROM h_landmark WHERE hotel_id = '$h_id'");
                $landmark->landmark_id = $h_landmarks;
            }
//            $h_nearby_places        = Hnearby::where('hotel_id',$id)->whereNull('deleted_at')->get();
            foreach ($hotel_nearby as $nearby){
                $h_nearby_places = DB::select("SELECT * FROM h_nearby WHERE hotel_id = '$h_id'");
                $nearby->nearby_id = $h_nearby_places;
//                dd($h_nearby_places);
            }
//            $h_configs        = HotelConfig::where('hotel_id',$id)->whereNull('deleted_at')->get();
//            dd(count($h_configs));
            foreach($hotel_configs as $hotel_config){
                $h_configs = DB::select("SELECT * FROM h_config WHERE hotel_id = '$h_id'");
                $hotel_config->hotel_config_id = $h_configs;
            }

            foreach ($facilities as $facility) {
                $h_facility = DB::select("SELECT facility_id FROM h_facility WHERE hotel_id = '$h_id'");
                $facility->facility_id = $h_facility;
            }

            foreach($features as $feature){
                $h_feature = DB::select("SELECT * FROM h_feature WHERE hotel_id = '$h_id'");
                $feature->feature_id = $h_feature;

            }

            $admin_id = $hotel->admin_id;
            $userRepo = new UserRepository();
            $hotel_admin = $userRepo->getObjByID($admin_id);

            return view('backend.hotel.hotel')
                ->with('hotel', $hotel)
                ->with('countries',$countries)
                ->with('cities',$cities)
                ->with('townships',$townships)
                ->with('h_configs',$h_configs)
                ->with('h_landmarks',$h_landmarks)
                ->with('h_nearby_places',$h_nearby_places)
                ->with('h_facility',$h_facility)
                ->with('h_feature',$h_feature)
                ->with('hotel_nearby',$hotel_nearby)
                ->with('hotel_admin',$hotel_admin)
                ->with('hotel_configs',$hotel_configs)
                ->with('landmarks',$landmarks)
                ->with('facilities',$facilities)
                ->with('features',$features);
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
            $photo_ext              = Utility::getImageExt($photo);
            $photo_name             = uniqid() . "." . $photo_ext;
            // $image          = Utility::resizeImage($photo,$photo_name,$path);
            $imgWidth               = 340;
            $imgHeight              = 260;
            $image                  = Utility::resizeImageWithDefaultWidthHeight($photo,$photo_name,$path,$imgWidth,$imgHeight);
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
        // $hotel_class            = (Input::has('hotel_class')) ? Input::get('hotel_class') : "";
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

        //start getting hotel config info
        $first_cancellation_day     = (Input::has('first_cancellation_day')) ? Input::get('first_cancellation_day') : "";
        $second_cancellation_day    = (Input::has('second_cancellation_day')) ? Input::get('second_cancellation_day') : "";
        $breakfast_fees             = (Input::has('breakfast_fees')) ? Input::get('breakfast_fees') : "";
        $tax                        = (Input::has('tax')) ? Input::get('tax') : "";
        //end getting hotel config info
        $hotel_config  =  $this->repo->getHConfigByID($id);
        $hotel_config_count = count($hotel_config);


        //start getting landmark
        $hotel_landmarks = $this->repo->getHLandmarkByID($id);
        foreach($hotel_landmarks as $hotel_landmark){
            $hotel_id = $hotel_landmark->hotel_id;
            HotelLandmark::where('hotel_id',$hotel_id)->delete();
        }

        $landmark = (Input::has('landmark')) ? Input::get('landmark') : "";
        $landmarkAry = array();
        $landmark_count = count($landmark);
        for($l=0;$l<$landmark_count;$l++){
            if($landmark != ""){
                $landmarkAry[$l]['landmark'] = $landmark[$l];
            }else{
                $landmarkAry[$l]['landmark'] = "";
            }

        }
        //end getting landmark

        //start getting hotel nearby
        $hotel_nearbys = $this->repo->getHNearbyID($id);
        foreach($hotel_nearbys as $hotel_nearby){
            $hotel_id = $hotel_nearby->hotel_id;
            Hnearby::where('hotel_id',$hotel_id)->delete();
        }
        $nearby_place = (Input::has('nearby_place')) ? Input::get('nearby_place') : "";

        if($nearby_place == ""){
            $nearby_place = (Input::has('nearby_place')) ? Input::get('nearby_place') : "";
        $nearby_distance = (Input::has('$nearby_distance_'.$nearby_place)) ? Input::get('$nearby_distance_'.$nearby_place) : "";
        }else{
            $nearby_distance = array();
            foreach($nearby_place as $n_place){
                $nearby_distance_temp = (Input::has('nearby_distance_'.$n_place)) ? Input::get('nearby_distance_'.$n_place) : "";
                array_push($nearby_distance,$nearby_distance_temp);
            }
        }
        $nearby_mainAry = array();
        $nearby_count = count($nearby_place);

        for($n=0;$n<$nearby_count;$n++){
            if($nearby_place != ""){
                $nearby_mainAry[$n]['nearby_place']= $nearby_place[$n];
            }else{
                $nearby_mainAry[$n]['nearby_place']= "";
            }
            if($nearby_distance != ""){
                $nearby_mainAry[$n]['nearby_distance'] = $nearby_distance[$n];
            }else{
                $nearby_mainAry[$n]['nearby_distance'] = "";
            }

        }
        //end getting hotel nearby

        //start getting hotel feature
        $hotel_features = $this->repo->getHFeatureID($id);
        foreach($hotel_features as $hotel_feature){
            $hotel_id = $hotel_feature->hotel_id;
            HotelFeature::where('hotel_id',$hotel_id)->delete();
        }
        $feature_id = (Input::has('feature_id')) ? Input::get('feature_id') : "";

        if($feature_id == ""){
            $qty = (Input::has('qty_'.$feature_id)) ? Input::get('qty_'.$feature_id) : "";
            $capacity = (Input::has('capacity_'.$feature_id)) ? Input::get('capacity_'.$feature_id) : "";
            $area = (Input::has('area_'.$feature_id)) ? Input::get('area_'.$feature_id) : "";
            $open_hour = (Input::has('open_hour_'.$feature_id)) ? Input::get('open_hour_'.$feature_id) : "";
            $close_hour = (Input::has('close_hour_'.$feature_id)) ? Input::get('close_hour_'.$feature_id) : "";
            $remark = (Input::has('remark_'.$feature_id)) ? Input::get('remark_'.$feature_id) : "";
        }else{
            $qty = array();
            foreach($feature_id as $f_id){
                $qty_temp = (Input::has('qty_'.$f_id)) ? Input::get('qty_'.$f_id) : "";
                array_push($qty,$qty_temp);
            }
            $capacity = array();
            foreach($feature_id as $f_id){
                $capacity_temp = (Input::has('capacity_'.$f_id)) ? Input::get('capacity_'.$f_id) : "";
                array_push($capacity,$capacity_temp);
            }
            $area = array();
            foreach($feature_id as $f_id){
                $area_temp = (Input::has('area_'.$f_id)) ? Input::get('area_'.$f_id) : "";
                array_push($area,$area_temp);
            }
            $open_hour = array();
            foreach($feature_id as $f_id){
                $open_hour_temp = (Input::has('open_hour_'.$f_id)) ? Input::get('open_hour_'.$f_id) : "";
                array_push($open_hour,$open_hour_temp);
            }
            $close_hour = array();
            foreach($feature_id as $f_id){
                $close_hour_temp = (Input::has('close_hour_'.$f_id)) ? Input::get('close_hour_'.$f_id) : "";
                array_push($close_hour,$close_hour_temp);
            }
            $remark = array();
            foreach($feature_id as $f_id){
                $remark_temp = (Input::has('remark_'.$f_id)) ? Input::get('remark_'.$f_id) : "";
                array_push($remark,$remark_temp);
            }
        }

        $h_feature_mainAry = array();
        $h_feature_count = count($feature_id);

        for($fe=0;$fe<$h_feature_count;$fe++){
            if($feature_id != ""){
                $h_feature_mainAry[$fe]['feature_id'] = $feature_id[$fe];
            }else{
                $h_feature_mainAry[$fe]['feature_id'] = "";
            }
            if($feature_id != ""){
                $h_feature_mainAry[$fe]['qty'] = $qty[$fe];
            }else{
                $h_feature_mainAry[$fe]['qty'] = "";
            }
            if($feature_id != "") {
                $h_feature_mainAry[$fe]['capacity'] = $capacity[$fe];
            }else{
                $h_feature_mainAry[$fe]['capacity'] = "";
            }
            if($feature_id != "") {
                $h_feature_mainAry[$fe]['area'] = $area[$fe];
            }else{
                $h_feature_mainAry[$fe]['area'] = "";
            }
            if($feature_id != "") {
                $h_feature_mainAry[$fe]['open_hour'] = $open_hour[$fe];
            }else{
                $h_feature_mainAry[$fe]['open_hour'] = "";
            }
            if($feature_id != "") {
                $h_feature_mainAry[$fe]['close_hour'] = $close_hour[$fe];
            }else{
                $h_feature_mainAry[$fe]['close_hour'] = "";
            }
            if($feature_id != "") {
                $h_feature_mainAry[$fe]['remark'] = $remark[$fe];
            }else{
                $h_feature_mainAry[$fe]['remark'] = "";
            }
        }

        //end start getting hotel feature

        //start getting hotel facility
        $hotel_facilities = $this->repo->getHFacilityID($id);
        foreach($hotel_facilities as $hotel_facility){
            $hotel_id = $hotel_facility->hotel_id;
            HotelFacility::where('hotel_id',$hotel_id)->delete();
        }
        $facility = (Input::has('facility')) ? Input::get('facility') : "";
        $facility_mainAry = array();
        $facility_count = count($facility);

        for($f=0;$f<$facility_count;$f++){
            if($facility != ""){
                $facility_mainAry[$f]['facility'] = $facility[$f];
            }else{
                $facility_mainAry[$f]['facility'] = "";
            }
        }
        //end getting hotel facility
        DB::beginTransaction();
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
        // $paramObj->class                    = $hotel_class;
        $paramObj->website                  = $website;
        $paramObj->check_in_time            = $check_in_time;
        $paramObj->check_out_time           = $check_out_time;
        $paramObj->breakfast_start_time     = $breakfast_start_time;
        $paramObj->breakfast_end_time       = $breakfast_end_time;

        $result = $this->repo->update($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            if(isset($hotel_config) && $hotel_config_count > 0){
                $hotel_configObj = $this->repo->getHConfigByID($id);
                $hotel_configObj->hotel_id = $paramObj->id;
                $hotel_configObj->first_cancellation_day_count  = $first_cancellation_day;
                $hotel_configObj->second_cancellation_day_count = $second_cancellation_day;
                $hotel_configObj->breakfast_fees   = $breakfast_fees;
                $hotel_configObj->tax              = $tax;
                $hotel_configResult = $this->repo->update($hotel_configObj);
            }else{
                $hotel_configObj = new HotelConfig();
                $hotel_configObj->hotel_id =$paramObj->id;
                $hotel_configObj->first_cancellation_day_count  = $first_cancellation_day;
                $hotel_configObj->second_cancellation_day_count = $second_cancellation_day;
                $hotel_configObj->breakfast_fees   = $breakfast_fees;
                $hotel_configObj->tax              = $tax;
                $hotel_configResult = $this->repo->create($hotel_configObj);
            }
            $landmarkResult = array();
            if($hotel_configResult['aceplusStatusCode'] ==  ReturnMessage::OK){
                if($landmark != ""){
                    foreach($landmarkAry as $land_ary){
                        $landmarkObj = new HotelLandmark();
                        $landmarkObj->hotel_id = $paramObj->id;
                        $landmarkObj->landmark_id = $land_ary['landmark'];
                        $landmarkResult = $this->repo->create($landmarkObj);
                    }
                }else{
                    $landmarkResult['aceplusStatusCode'] = ReturnMessage::OK;
                }
                $h_nearby_result = array();
                if($landmarkResult['aceplusStatusCode'] ==  ReturnMessage::OK){
                    if($nearby_place != "") {
                        foreach($nearby_mainAry as $nearby_ary){
                            $h_nearbyObj = new Hnearby();
                            $h_nearbyObj->hotel_id = $paramObj->id;
                            $h_nearbyObj->nearby_id = $nearby_ary['nearby_place'];
                            $h_nearbyObj->km = $nearby_ary['nearby_distance'];
                            $h_nearby_result = $this->repo->create($h_nearbyObj);
                        }
                    }else{
                        $h_nearby_result['aceplusStatusCode'] = ReturnMessage::OK;
                    }
                    $h_feature_result = array();
                    if($h_nearby_result['aceplusStatusCode'] ==  ReturnMessage::OK){
                        if($feature_id != ""){
                            foreach($h_feature_mainAry as $h_feature) {
                                $h_featureObj = new HotelFeature();
                                $h_featureObj->hotel_id = $paramObj->id;
                                $h_featureObj->feature_id = $h_feature['feature_id'];
                                $h_featureObj->qty = $h_feature['qty'];
                                $h_featureObj->capacity = $h_feature['capacity'];
                                $h_featureObj->area = $h_feature['area'];
                                $h_featureObj->open_hour = $h_feature['open_hour'];
                                $h_featureObj->close_hour = $h_feature['close_hour'];
                                $h_featureObj->remark = $h_feature['remark'];
                                $h_feature_result = $this->repo->create($h_featureObj);
                            }
                        }else{
                            $h_feature_result['aceplusStatusCode'] = ReturnMessage::OK;
                        }
                        $h_facility_result = array();
                        if($h_feature_result['aceplusStatusCode'] ==  ReturnMessage::OK){
                            if($facility != ""){
                                foreach($facility_mainAry as $facility_ary){
                                    $h_facilityObj = new HotelFacility();
                                    $h_facilityObj->hotel_id = $paramObj->id;
                                    $h_facilityObj->facility_id = $facility_ary['facility'];
                                    $h_facility_result = $this->repo->create($h_facilityObj);
                                }
                            }else{
                                $h_facility_result['aceplusStatusCode'] = ReturnMessage::OK;
                            }
                            if($h_facility_result['aceplusStatusCode'] ==  ReturnMessage::OK){
                                DB::commit();
                                return redirect()->action('Setup\Hotel\HotelController@index')
                                    ->withMessage(FormatGenerator::message('Success', 'Hotel updated ...'));
                            }else{
                                DB::rollback();
                                return redirect()->action('Setup\Hotel\HotelController@index')
                                    ->withMessage(FormatGenerator::message('Fail', 'Hotel did not update ...'));
                            }

                        }else{
                            DB::rollback();
                            return redirect()->action('Setup\Hotel\HotelController@index')
                                ->withMessage(FormatGenerator::message('Fail', 'Hotel did not update ...'));
                        }

                    }else{
                        DB::rollback();
                        return redirect()->action('Setup\Hotel\HotelController@index')
                            ->withMessage(FormatGenerator::message('Fail', 'Hotel did not update ...'));
                    }

                }else{
                    DB::rollback();
                    return redirect()->action('Setup\Hotel\HotelController@index')
                        ->withMessage(FormatGenerator::message('Fail', 'Hotel did not update ...'));
                }

            }else{
                DB::rollback();
                return redirect()->action('Setup\Hotel\HotelController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel did not update ...'));
            }

        }
        else{
            DB::rollback();
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
