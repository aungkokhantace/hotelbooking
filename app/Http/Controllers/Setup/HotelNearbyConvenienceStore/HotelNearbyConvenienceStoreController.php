<?php

namespace App\Http\Controllers\Setup\HotelNearbyConvenienceStore;

use App\Backend\Infrastructure\Forms\HotelNearbyConvenienceStoreEditRequest;
use App\Backend\Infrastructure\Forms\HotelNearbyConvenienceStoreEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStore;
use App\Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class HotelNearbyConvenienceStoreController extends Controller
{
    private $repo;

    public function __construct(HotelNearbyConvenienceStoreRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_nearby_convenience_store = $this->repo->getObjs();
            return view('backend.hotel_nearby_convenience_store.index')->with('hotel_nearby_convenience_store',$hotel_nearby_convenience_store);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo  = new HotelRepository();
            $hotels     = $hotelRepo->getObjs();
            return view('backend.hotel_nearby_convenience_store.hotel_nearby_convenience_store')->with('hotels',$hotels);
        }
        return redirect('/');
    }

    public function store(HotelNearbyConvenienceStoreEntryRequest $request)
    {
        $request->validate();
        $name               = Input::get('name');
        $distance           = Input::get('distance');
        $remark             = Input::get('remark');
        $hotel_id           = Input::get('hotel_id');

        $paramObj               = new HotelNearbyConvenienceStore();
        $paramObj->hotel_id     = $hotel_id;
        $paramObj->name         = $name;
        $paramObj->distance     = $distance;
        $paramObj->remark       = $remark;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby Airport is created ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby Airport is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_nearby_convenience_store   = $this->repo->getObjByID($id);
            $hotelRepo              = new HotelRepository();
            $hotels                 = $hotelRepo->getObjs();
            return view('backend.hotel_nearby_convenience_store.hotel_nearby_convenience_store')->with('hotel_nearby_convenience_store', $hotel_nearby_convenience_store)->with('hotels',$hotels);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelNearbyConvenienceStoreEditRequest $request){

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
            return redirect()->action('Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby Airport is updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby Airport is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@index'); //to redirect listing page
    }
}
