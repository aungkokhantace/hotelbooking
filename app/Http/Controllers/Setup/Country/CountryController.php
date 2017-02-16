<?php

namespace App\Http\Controllers\Setup\Country;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\CountryEntryFormRequest;
use App\Backend\Infrastructure\Forms\CountryEditRequest;
use App\Setup\Country\CountryRepositoryInterface;
use App\Setup\Country\Country;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;

class CountryController extends Controller
{
    private $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $countries = Country::all();
            return view('backend.country.index')->with('countries',$countries);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            return view('backend.country.country');
        }
        return redirect('/');
    }

    public function store(CountryEntryFormRequest $request)
    {
        $request->validate();
        $countries_name       = Input::get('countries_name');

        $paramObj = new Country();
        $paramObj->countries_name = $countries_name;

        $result = $this->countryRepository->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Country\CountryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Country created ...'));
        }
        else{

            return redirect()->action('Setup\Country\CountryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Country did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $country = Country::find($id);
            return view('backend.country.country')->with('country', $country)->with('country', $country);
        }
        return redirect('/backend/login');
    }

    public function update(CountryEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $countries_name             = Input::get('countries_name');
        $paramObj                   = Country::find($id);
        $paramObj->countries_name   = $countries_name;

        $result = $this->countryRepository->update($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Country\CountryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Country updated ...'));
        }
        else{

            return redirect()->action('Setup\Country\CountryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Country did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->countryRepository->delete($id);
        }
        return redirect()->action('Setup\Country\CountryController@index'); //to redirect listing page
    }

    public function check_country_name(){
        $countries_name     = Input::get('countries_name');
        $country            = Country::where('countries_name','=',$countries_name)->whereNull('deleted_at')->get();
        $result             = false;
        if(count($country) == 0 ){
            $result = true;
        }

        return \Response::json($result);
    }


}
