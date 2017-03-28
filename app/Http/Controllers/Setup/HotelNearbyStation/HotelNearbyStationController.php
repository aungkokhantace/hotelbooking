<?php

namespace App\Http\Controllers\Setup\HotelNearbyStation;

use App\Backend\Infrastructure\Forms\HotelNearbyStationEditRequest;
use App\Backend\Infrastructure\Forms\HotelNearbyStationEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelNearbyStation\HotelNearbyStation;
use App\Setup\HotelNearbyStation\HotelNearbyStationRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class HotelNearbyStationController extends Controller
{
    private $repo;

    public function __construct(HotelNearbyStationRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_nearby_station = $this->repo->getObjs();
            return view('backend.hotel_nearby_station.index')->with('hotel_nearby_station',$hotel_nearby_station);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo  = new HotelRepository();
            $hotels     = $hotelRepo->getObjs();
            return view('backend.hotel_nearby_station.hotel_nearby_station')->with('hotels',$hotels);
        }
        return redirect('/');
    }

    public function store(HotelNearbyStationEntryRequest $request)
    {
        $request->validate();
        $name               = Input::get('name');
        $distance           = Input::get('distance');
        $remark             = Input::get('remark');
        $hotel_id           = Input::get('hotel_id');

        $paramObj               = new HotelNearbyStation();
        $paramObj->hotel_id     = $hotel_id;
        $paramObj->name         = $name;
        $paramObj->distance     = $distance;
        $paramObj->remark       = $remark;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelNearbyStation\HotelNearbyStationController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby Station created ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearbyStation\HotelNearbyStationController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby Station did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_nearby_station   = $this->repo->getObjByID($id);
            $hotelRepo              = new HotelRepository();
            $hotels                 = $hotelRepo->getObjs();
            return view('backend.hotel_nearby_station.hotel_nearby_station')->with('hotel_nearby_station', $hotel_nearby_station)->with('hotels',$hotels);
        }
        return redirect('/backend/login');
    }

    public function update(HotelNearbyStationEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $name                       = Input::get('name');
        $distance                   = Input::get('distance');
        $remark                     = Input::get('remark');
        $hotel_id                   = Input::get('hotel_id');

        $paramObj                   = $this->repo->getObjByID($id);
        $paramObj->hotel_id         = $hotel_id;
        $paramObj->name             = $name;
        $paramObj->distance         = $distance;
        $paramObj->remark           = $remark;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelNearbyStation\HotelNearbyStationController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby Station updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearbyStation\HotelNearbyStationController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby Station did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        //to redirect listing page
        return redirect()->action('Setup\HotelNearbyStation\HotelNearbyStationController@index');
    }
}
