<?php

namespace App\Http\Controllers\Setup\HotelConfig;

use App\Backend\Infrastructure\Forms\HotelConfigEditRequest;
use App\Backend\Infrastructure\Forms\HotelConfigEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelConfig\HotelConfig;

use App\Setup\HotelConfig\HotelConfigRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class HotelConfigController extends Controller
{
    private $repo;

    public function __construct(HotelConfigRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_configs = $this->repo->getObjs();
            return view('backend.hotel_config.index')->with('hotel_configs',$hotel_configs);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotel_configs = $this->repo->getObjs();

            //array that contains hotel_ids that are already in h_config
            $hotel_config_array = array();

            foreach($hotel_configs as $config){
                array_push($hotel_config_array,$config->hotel_id);
            }

            $hotelRepo          = new HotelRepository();
            //get hotels that are not in h_config yet
            $hotels             = $hotelRepo->getObjsNotInConfig($hotel_config_array);

            return view('backend.hotel_config.hotel_config')->with('hotels',$hotels);
        }
        return redirect('/');
    }

    public function store(HotelConfigEntryRequest $request)
    {
        $request->validate();
        $hotel_id                   = Input::get('hotel_id');
        $first_cancellation_day     = Input::get('first_cancellation_day');
        $second_cancellation_day    = Input::get('second_cancellation_day');
        $breakfast_fees             = Input::get('breakfast_fees');
        $extrabed_fees              = Input::get('extrabed_fees');
        $tax                        = Input::get('tax');

        $paramObj                   = new HotelConfig();
        $paramObj->hotel_id         = $hotel_id;
        $paramObj->first_cancellation_day_count  = $first_cancellation_day;
        $paramObj->second_cancellation_day_count = $second_cancellation_day;
        $paramObj->breakfast_fees   = $breakfast_fees;
        $paramObj->extrabed_fees    = $extrabed_fees;
        $paramObj->tax              = $tax;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelConfig\HotelConfigController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Config created ...'));
        }
        else{
            return redirect()->action('Setup\HotelConfig\HotelConfigController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Config did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_config       = $this->repo->getObjByID($id);
            return view('backend.hotel_config.hotel_config')->with('hotel_config', $hotel_config);
        }
        return redirect('/backend/login');
    }

    public function update(HotelConfigEditRequest $request){
        $request->validate();
        $id                         = Input::get('id');
        $hotel_id                   = Input::get('hotel_id');
        $first_cancellation_day     = Input::get('first_cancellation_day');
        $second_cancellation_day    = Input::get('second_cancellation_day');
        $breakfast_fees             = Input::get('breakfast_fees');
        $extrabed_fees              = Input::get('extrabed_fees');
        $tax                        = Input::get('tax');

        $paramObj                   = $this->repo->getObjByID($id);
        $paramObj->hotel_id         = $hotel_id;
        $paramObj->first_cancellation_day_count  = $first_cancellation_day;
        $paramObj->second_cancellation_day_count = $second_cancellation_day;
        $paramObj->breakfast_fees   = $breakfast_fees;
        $paramObj->extrabed_fees    = $extrabed_fees;
        $paramObj->tax              = $tax;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelConfig\HotelConfigController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Config updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelConfig\HotelConfigController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Config did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelConfig\HotelConfigController@index'); //to redirect listing page
    }
}
