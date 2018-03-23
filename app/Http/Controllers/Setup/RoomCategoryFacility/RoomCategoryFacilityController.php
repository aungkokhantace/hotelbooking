<?php

namespace App\Http\Controllers\Setup\RoomCategoryFacility;

use App\Backend\Infrastructure\Forms\RoomCategoryFacilityEditRequest;
use App\Backend\Infrastructure\Forms\RoomCategoryFacilityEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Facilities\Facilities;
use App\Setup\Facilities\FacilitiesRepository;
use App\Setup\FacilityGroup\FacilityGroup;
use App\Setup\FacilityGroup\FacilityGroupRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\HotelRoomType\HotelRoomTypeRepository;
use App\Setup\RoomCategoryFacility\RoomCategoryFacility;
use App\Setup\RoomCategoryFacility\RoomCategoryFacilityRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class RoomCategoryFacilityController extends Controller
{
    private $repo;

    public function __construct(RoomCategoryFacilityRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $r_category_facilities = $this->repo->getObjs();
            return view('backend.room_category_facilities.index')->with('r_category_facilities',$r_category_facilities);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo          = new HotelRepository();
            $hotels             = $hotelRepo->getObjs();
            $facilityRepo       = new FacilitiesRepository();
            $facilities         = $facilityRepo->getObjsForRoom();
            $facility_groupRepo = new FacilityGroupRepository();
            $facility_group     = $facility_groupRepo->getObjs();

            return view('backend.room_category_facilities.room_category_facility')->with('hotels',$hotels)
                                                                                  ->with('facilities',$facilities)
                                                                                  ->with('facility_group',$facility_group);
        }
        return redirect('/');
    }

    public function store(RoomCategoryFacilityEntryRequest $request)
    {
        $request->validate();
        $facility_id                    = Input::get('facility');
        $hotel_id                       = Input::get('hotel_id');
        $h_room_type_id                 = Input::get('h_room_type_id');
        $h_room_category_id             = Input::get('h_room_category_id');
//        $value                          = Input::get('value');
        $description                    = Input::get('description');
//        $facility_group_id              = Input::get('facility_group');

        $paramObj                       = new RoomCategoryFacility();
        $paramObj->facility_id          = $facility_id;
//        $paramObj->value                = $value;
        $paramObj->hotel_id             = $hotel_id;
        $paramObj->h_room_type_id       = $h_room_type_id;
        $paramObj->h_room_category_id   = $h_room_category_id;
        $paramObj->description          = $description;
//        $paramObj->facility_group_id    = $facility_group_id;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomCategoryFacility\RoomCategoryFacilityController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room Category Facility is created ...'));
        }
        else{
            return redirect()->action('Setup\RoomCategoryFacility\RoomCategoryFacilityController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room Category Facility is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $r_category_facility    = $this->repo->getObjByID($id);
            $hotel_id               = $r_category_facility->hotel_id;
            $h_room_type_id         = $r_category_facility->h_room_type_id;
            $hotelRepo              = new HotelRepository();
            $hotels                 = $hotelRepo->getObjs();
            $hotelRoomTypeRepo      = new HotelRoomTypeRepository();
            $hotel_room_type        = $hotelRoomTypeRepo->getHotelRoomTypeWithHotelId($hotel_id);
            $hotelRoomCategoryRepo  = new HotelRoomCategoryRepository();
            $hotel_room_category    = $hotelRoomCategoryRepo->getHotelRoomCategoryWithRoomTypeId($h_room_type_id);
            $facilityRepo           = new FacilitiesRepository();
            $facilities             = $facilityRepo->getObjsForRoom();
            $facility_groupRepo     = new FacilityGroupRepository();
            $facility_group         = $facility_groupRepo->getObjs();

            return view('backend.room_category_facilities.room_category_facility')
                ->with('r_category_facility', $r_category_facility)
                ->with('hotels',$hotels)
                ->with('facilities',$facilities)
                ->with('hotel_room_type',$hotel_room_type)
                ->with('hotel_room_category',$hotel_room_category)
                ->with('facility_group',$facility_group);
        }
        return redirect('/backend_mps/login');
    }

    public function update(RoomCategoryFacilityEditRequest $request){

        $request->validate();
        $id                             = Input::get('id');
        $facility_id                    = Input::get('facility');
        $hotel_id                       = Input::get('hotel_id');
        $h_room_type_id                 = Input::get('h_room_type_id');
        $h_room_category_id             = Input::get('h_room_category_id');
//        $value                          = Input::get('value');
        $description                    = Input::get('description');
//        $facility_group_id              = Input::get('facility_group');

        $paramObj                       = $this->repo->getObjByID($id);
        $paramObj->facility_id          = $facility_id;
//        $paramObj->value                = $value;
        $paramObj->hotel_id             = $hotel_id;
        $paramObj->h_room_type_id       = $h_room_type_id;
        $paramObj->h_room_category_id   = $h_room_category_id;
        $paramObj->description          = $description;
//        $paramObj->facility_group_id    = $facility_group_id;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomCategoryFacility\RoomCategoryFacilityController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room Category Facility is updated ...'));
        }
        else{
            return redirect()->action('Setup\RoomCategoryFacility\RoomCategoryFacilityController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room Category Facility is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\RoomCategoryFacility\RoomCategoryFacilityController@index'); //to redirect listing page
    }
}
