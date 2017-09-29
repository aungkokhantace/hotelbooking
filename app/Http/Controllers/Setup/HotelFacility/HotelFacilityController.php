<?php

namespace App\Http\Controllers\Setup\HotelFacility;

use App\Backend\Infrastructure\Forms\HotelFacilityEditRequest;
use App\Backend\Infrastructure\Forms\HotelFacilityEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Facilities\FacilitiesRepository;
use App\Setup\FacilityGroup\FacilityGroupRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelFacility\HotelFacility;
use App\Setup\HotelFacility\HotelFacilityRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;

class HotelFacilityController extends Controller
{
    private $repo;

    public function __construct(HotelFacilityRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_facility = $this->repo->getObjs();
            return view('backend.hotel_facility.index')->with('hotel_facility',$hotel_facility);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo          = new HotelRepository();
            $hotels             = $hotelRepo->getObjs();
            $facilityGroupRepo  = new FacilityGroupRepository();
            $facility_group     = $facilityGroupRepo->getObjs();
            $facilityRepo       = new FacilitiesRepository();
            $facilities         = $facilityRepo->getObjsForHotel();
            return view('backend.hotel_facility.hotel_facility')->with('hotels',$hotels)
                                                                ->with('facility_group',$facility_group)
                                                                ->with('facilities',$facilities);
        }
        return redirect('/');
    }

    public function store(HotelFacilityEntryRequest $request)
    {
        $request->validate();
        $hotel_id           = Input::get('hotel_id');
//        $facility_group_id  = Input::get('facility_group');
        $facility_id        = Input::get('facility');

        $paramObj                       = new HotelFacility();
        $paramObj->hotel_id             = $hotel_id;
//        $paramObj->facility_group_id    = $facility_group_id;
        $paramObj->facility_id          = $facility_id;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelFacility\HotelFacilityController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Facility created ...'));
        }
        else{
            return redirect()->action('Setup\HotelFacility\HotelFacilityController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Facility did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_facility      = $this->repo->getObjByID($id);
            $hotelRepo          = new HotelRepository();
            $hotels             = $hotelRepo->getObjs();
            $facilityGroupRepo  = new FacilityGroupRepository();
            $facility_group     = $facilityGroupRepo->getObjs();
            $facilityRepo       = new FacilitiesRepository();
            $facilities         = $facilityRepo->getObjs();
            return view('backend.hotel_facility.hotel_facility')->with('hotel_facility', $hotel_facility)
                                                                ->with('hotels',$hotels)
                                                                ->with('facility_group',$facility_group)
                                                                ->with('facilities',$facilities);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelFacilityEditRequest $request){

        $request->validate();
        $id                 = Input::get('id');
        $hotel_id           = Input::get('hotel_id');
//        $facility_group_id  = Input::get('facility_group');
        $facility_id        = Input::get('facility');

        $paramObj                       = $this->repo->getObjByID($id);
        $paramObj->hotel_id             = $hotel_id;
//        $paramObj->facility_group_id    = $facility_group_id;
        $paramObj->facility_id          = $facility_id;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelFacility\HotelFacilityController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Facility updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelFacility\HotelFacilityController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Facility did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelFacility\HotelFacilityController@index'); //to redirect listing page
    }
}
