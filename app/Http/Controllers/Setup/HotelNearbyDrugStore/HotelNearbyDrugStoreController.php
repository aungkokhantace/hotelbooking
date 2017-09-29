<?php

namespace App\Http\Controllers\Setup\HotelNearbyDrugStore;

use App\Backend\Infrastructure\Forms\HotelNearbyDrugStoreEditRequest;
use App\Backend\Infrastructure\Forms\HotelNearbyDrugStoreEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelNearbyDrugStore\HotelNearbyDrugStore;
use App\Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class HotelNearbyDrugStoreController extends Controller
{
    private $repo;

    public function __construct(HotelNearbyDrugStoreRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_nearby_drug_store = $this->repo->getObjs();
            return view('backend.hotel_nearby_drug_store.index')->with('hotel_nearby_drug_store',$hotel_nearby_drug_store);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo  = new HotelRepository();
            $hotels     = $hotelRepo->getObjs();
            return view('backend.hotel_nearby_drug_store.hotel_nearby_drug_store')->with('hotels',$hotels);
        }
        return redirect('/');
    }

    public function store(HotelNearbyDrugStoreEntryRequest $request)
    {
        $request->validate();
        $name               = Input::get('name');
        $distance           = Input::get('distance');
        $remark             = Input::get('remark');
        $hotel_id           = Input::get('hotel_id');

        $paramObj               = new HotelNearbyDrugStore();
        $paramObj->hotel_id     = $hotel_id;
        $paramObj->name         = $name;
        $paramObj->distance     = $distance;
        $paramObj->remark       = $remark;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby Airport created ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby Airport did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_nearby_drug_store   = $this->repo->getObjByID($id);
            $hotelRepo              = new HotelRepository();
            $hotels                 = $hotelRepo->getObjs();
            return view('backend.hotel_nearby_drug_store.hotel_nearby_drug_store')->with('hotel_nearby_drug_store', $hotel_nearby_drug_store)->with('hotels',$hotels);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelNearbyDrugStoreEditRequest $request){

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
            return redirect()->action('Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby Airport updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby Airport did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@index'); //to redirect listing page
    }
}
