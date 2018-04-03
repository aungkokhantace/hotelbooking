<?php

namespace App\Http\Controllers\Setup\Township;

use App\Setup\City\CityRepository;
use App\Setup\Country\CountryRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\TownshipEntryRequest;
use App\Backend\Infrastructure\Forms\TownshipEditRequest;
use App\Setup\Township\TownshipRepositoryInterface;
use App\Setup\Township\Township;
use App\Setup\City\City;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;
use App\Core\Check;

class TownshipController extends Controller
{
    private $repo;

    public function __construct(TownshipRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $townships      = $this->repo->getObjs();

            $countryRepo    = new CountryRepository();
            $cityRepo = new CityRepository();
            foreach($townships as $township){
              $city     = $cityRepo->getObjByID($township->city_id);
              $country  = $countryRepo->getObjByID($city->country_id);
              $township->country_name = $country->name;
            }

            return view('backend.township.index')->with('townships',$townships);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $cityRepo = new CityRepository();
            $cities   = $cityRepo->getObjs();

            return view('backend.township.township')->with('cities',$cities);
        }
        return redirect('/');
    }

    public function store(TownshipEntryRequest $request)
    {
        $request->validate();
        $township_name       = Input::get('name');
        $city_id             = Input::get('city_id');

        $paramObj = new Township();
        $paramObj->name = $township_name;
        $paramObj->city_id       = $city_id;

        $result = $this->repo->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Township\TownshipController@index')
                ->withMessage(FormatGenerator::message('Success', 'Township is created ...'));
        }
        else{

            return redirect()->action('Setup\Township\TownshipController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Township is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $township  = Township::find($id);

            $cityRepo = new CityRepository();
            $cities   = $cityRepo->getObjs();

            return view('backend.township.township')->with('township', $township)->with('cities', $cities);
        }
        return redirect('/backend_mps/login');
    }

    public function update(TownshipEditRequest $request){
        $request->validate();
        $id                         = Input::get('id');
        $township_name              = Input::get('name');
        $city_id                    = Input::get('city_id');
        $paramObj                   = Township::find($id);
        $paramObj->name             = $township_name;
        $paramObj->city_id          = $city_id;

        $result = $this->repo->update($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Township\TownshipController@index')
                ->withMessage(FormatGenerator::message('Success', 'Township is updated ...'));
        }
        else{

            return redirect()->action('Setup\Township\TownshipController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Township is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        $delete_flag = true;
        foreach($new_string as $id){
          //check in hotel setup whether this township is used or not
          $hotel_setup_check = Check::checkToDelete("hotels","township_id",$id);

          if(isset($hotel_setup_check) && count($hotel_setup_check)>0){
            alert()->warning('This township is used in hotel setup and you cannot delete it!')->persistent('OK');
            $delete_flag = false;
          }
          else{
              $this->repo->delete($id);
          }
        }
        if($delete_flag){
            return redirect()->action('Setup\Township\TownshipController@index')
                ->withMessage(FormatGenerator::message('Success', 'Township is deleted ...'));
        }
        else{
            return redirect()->action('Setup\Township\TownshipController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Township is not deleted ...'));
        }
        // return redirect()->action('Setup\Township\TownshipController@index'); //to redirect listing page
    }



}
