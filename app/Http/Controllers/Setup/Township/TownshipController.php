<?php

namespace App\Http\Controllers\Setup\Township;

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

class TownshipController extends Controller
{
    private $townshipRepository;

    public function __construct(TownshipRepositoryInterface $townshipRepository)
    {
        $this->townshipRepository = $townshipRepository;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $townships = Township::all();
            return view('backend.township.index')->with('townships',$townships);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $cities = City::lists('city_name','id');

            return view('backend.township.township')->with('cities',$cities);
        }
        return redirect('/');
    }

    public function store(TownshipEntryRequest $request)
    {

        $request->validate();
        $township_name       = Input::get('township_name');
        $city_id             = Input::get('city_id');

        $paramObj = new Township();
        $paramObj->township_name = $township_name;
        $paramObj->city_id       = $city_id;

        $result = $this->townshipRepository->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Township\TownshipController@index')
                ->withMessage(FormatGenerator::message('Success', 'Township created ...'));
        }
        else{

            return redirect()->action('Setup\Township\TownshipController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Township did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $township  = Township::find($id);
            $cities    = City::all();
            return view('backend.township.township')->with('township', $township)->with('cities', $cities);
        }
        return redirect('/backend/login');
    }

    public function update(TownshipEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $township_name              = Input::get('township_name');
        $city_id                    = Input::get('city_id');
        $paramObj                   = Township::find($id);
        $paramObj->township_name    = $township_name;
        $paramObj->city_id          = $city_id;

        $result = $this->townshipRepository->update($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Township\TownshipController@index')
                ->withMessage(FormatGenerator::message('Success', 'Township updated ...'));
        }
        else{

            return redirect()->action('Setup\Township\TownshipController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Township did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->townshipRepository->delete($id);
        }
        return redirect()->action('Setup\Township\TownshipController@index'); //to redirect listing page
    }



}

