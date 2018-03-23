<?php

namespace App\Http\Controllers\Setup\City;

use App\Core\Utility;
use App\Setup\Country\CountryRepository;
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
    private $repo;

    public function __construct(CityRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $cities      = $this->repo->getObjs();
            return view('backend.city.index')->with('cities',$cities);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $countryRepo = new CountryRepository();
            $countries = $countryRepo->getObjs();
            return view('backend.city.city')->with('countries',$countries);
        }
        return redirect('/');
    }

    public function store(CityEntryRequest $request)
    {
        $request->validate();
        $city_name       = Input::get('name');
        $country_id      = Input::get('country_id');

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

        $paramObj = new City();
        $paramObj->name         = $city_name;
        $paramObj->country_id   = $country_id;
        $paramObj->image        = $photo_name;

        $result = $this->repo->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\City\CityController@index')
                ->withMessage(FormatGenerator::message('Success', 'City is created ...'));
        }
        else{
            return redirect()->action('Setup\City\CityController@index')
                ->withMessage(FormatGenerator::message('Fail', 'City is not created ...'));
        }

    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $city        = City::find($id);

            $countryRepo = new CountryRepository();
            $countries   = $countryRepo->getObjs();

            return view('backend.city.city')->with('city', $city)->with('countries', $countries);
        }
        return redirect('/backend_mps/login');
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
                ->withMessage(FormatGenerator::message('Success', 'City is updated ...'));
        }
        else{

            return redirect()->action('Setup\City\CityController@index')
                ->withMessage(FormatGenerator::message('Fail', 'City is not updated ...'));
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
                ->withMessage(FormatGenerator::message('Success', 'City deleted ...'));
        }
        else{
            return redirect()->action('Setup\City\CityController@index') //to redirect listing page
                ->withMessage(FormatGenerator::message('Fail', 'City did not delete ...'));
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

}
