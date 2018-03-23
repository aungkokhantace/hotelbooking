<?php

namespace App\Http\Controllers\Setup\RoomCategoryAmenity;

use App\Backend\Infrastructure\Forms\RoomCategoryAmenityEditRequest;
use App\Backend\Infrastructure\Forms\RoomCategoryAmenityEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Amenities\AmenitiesRepository;
use App\Setup\Facilities\FacilitiesRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\HotelRoomType\HotelRoomTypeRepository;
use App\Setup\RoomCategoryAmenity\RoomCategoryAmenity;
use App\Setup\RoomCategoryAmenity\RoomCategoryAmenityRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class RoomCategoryAmenityController extends Controller
{
    private $repo;

    public function __construct(RoomCategoryAmenityRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $r_category_amenities = $this->repo->getObjs();
            return view('backend.room_category_amenities.index')->with('r_category_amenities',$r_category_amenities);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $roomCategoryRepo   = new HotelRoomCategoryRepository();
            $room_categories    = $roomCategoryRepo->getObjs();

            $amenityRepo        = new AmenitiesRepository();
            $amenities          = $amenityRepo->getObjs();

            return view('backend.room_category_amenities.room_category_amenity')->with('room_categories',$room_categories)
                                                                                  ->with('amenities',$amenities);
        }
        return redirect('/');
    }

    public function store(RoomCategoryAmenityEntryRequest $request)
    {
        $request->validate();
        $h_room_category_id             = Input::get('h_room_category_id');
        $amenity_id                     = Input::get('amenity');
//        $value                          = Input::get('value');
        $description                    = Input::get('description');

        $paramObj                       = new RoomCategoryAmenity();
        $paramObj->room_category_id     = $h_room_category_id;
        $paramObj->amenity_id           = $amenity_id;
//        $paramObj->value                = $value;
        $paramObj->description          = $description;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomCategoryAmenity\RoomCategoryAmenityController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room Category Amenity is created ...'));
        }
        else{
            return redirect()->action('Setup\RoomCategoryFacility\RoomCategoryAmenityController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room Category Amenity is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $r_category_amenity     = $this->repo->getObjByID($id);

            $roomCategoryRepo   = new HotelRoomCategoryRepository();
            $room_categories    = $roomCategoryRepo->getObjs();

            $amenityRepo        = new AmenitiesRepository();
            $amenities          = $amenityRepo->getObjs();

            return view('backend.room_category_amenities.room_category_amenity')
                ->with('r_category_amenity', $r_category_amenity)
                ->with('room_categories',$room_categories)
                ->with('amenities',$amenities);
        }
        return redirect('/backend_mps/login');
    }

    public function update(RoomCategoryAmenityEditRequest $request){

        $request->validate();
        $id                             = Input::get('id');
        $h_room_category_id             = Input::get('h_room_category_id');
        $amenity_id                     = Input::get('amenity');
//        $value                          = Input::get('value');
        $description                    = Input::get('description');

        $paramObj                       = $this->repo->getObjByID($id);
        $paramObj->room_category_id     = $h_room_category_id;
        $paramObj->amenity_id           = $amenity_id;
//        $paramObj->value                = $value;
        $paramObj->description          = $description;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomCategoryAmenity\RoomCategoryAmenityController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room Category Amenity is updated ...'));
        }
        else{
            return redirect()->action('Setup\RoomCategoryAmenity\RoomCategoryAmenityController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room Category Amenity is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\RoomCategoryAmenity\RoomCategoryAmenityController@index'); //to redirect listing page
    }
}
