<?php

namespace App\Http\Controllers\Setup\HotelNearbyHospital;


use App\Backend\Infrastructure\Forms\HotelNearbyHospitalEditRequest;
use App\Backend\Infrastructure\Forms\HotelNearbyHospitalEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelNearbyHospital\HotelNearbyHospital;
use App\Setup\HotelNearbyHospital\HotelNearbyHospitalRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;

class HotelNearbyHospitalController extends Controller
{
    private $repo;

    public function __construct(HotelNearbyHospitalRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_nearby_hospital = $this->repo->getObjs();
            return view('backend.hotel_nearby_hospital.index')->with('hotel_nearby_hospital',$hotel_nearby_hospital);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo  = new HotelRepository();
            $hotels     = $hotelRepo->getObjs();
            return view('backend.hotel_nearby_hospital.hotel_nearby_hospital')->with('hotels',$hotels);
        }
        return redirect('/');
    }

    public function store(HotelNearbyHospitalEntryRequest $request)
    {
        $request->validate();
        $name               = Input::get('name');
        $distance           = Input::get('distance');
        $remark             = Input::get('remark');
        $hotel_id           = Input::get('hotel_id');

        $paramObj               = new HotelNearbyHospital();
        $paramObj->hotel_id     = $hotel_id;
        $paramObj->name         = $name;
        $paramObj->distance     = $distance;
        $paramObj->remark       = $remark;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelNearbyHospital\HotelNearbyHospitalController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby Hospital is created ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearbyHospital\HotelNearbyHospitalController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby Hospital is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_nearby_hospital   = $this->repo->getObjByID($id);
            $hotelRepo              = new HotelRepository();
            $hotels                 = $hotelRepo->getObjs();
            return view('backend.hotel_nearby_hospital.hotel_nearby_hospital')->with('hotel_nearby_hospital', $hotel_nearby_hospital)->with('hotels',$hotels);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelNearbyHospitalEditRequest $request){

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
            return redirect()->action('Setup\HotelNearbyHospital\HotelNearbyHospitalController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby Hospital is updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearbyHospital\HotelNearbyHospitalController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby Hospital is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelNearbyHospital\HotelNearbyHospitalController@index'); //to redirect listing page
    }
}
