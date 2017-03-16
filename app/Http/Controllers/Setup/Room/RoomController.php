<?php

namespace App\Http\Controllers\Setup\Room;

use App\Backend\Infrastructure\Forms\RoomEditRequest;
use App\Backend\Infrastructure\Forms\RoomEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\HotelRoomType\HotelRoomType;
use App\Setup\HotelRoomType\HotelRoomTypeRepository;
use App\Setup\Room\Room;
use App\Setup\Room\RoomRepositoryInterface;
use App\Setup\RoomView\RoomViewRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class RoomController extends Controller
{
    private $repo;

    public function __construct(RoomRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $rooms = $this->repo->getObjs();
            return view('backend.room.index')->with('rooms',$rooms);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo          = new HotelRepository();
            $hotels             = $hotelRepo->getObjs();
            $roomViewRepo       = new RoomViewRepository();
            $room_view          = $roomViewRepo->getObjs();
            return view('backend.room.room')->with('hotels',$hotels)
                                            ->with('room_view',$room_view);
        }
        return redirect('/');
    }

    public function store(RoomEntryRequest $request)
    {
        $request->validate();
        $name               = Input::get('name');
        $hotel_id           = Input::get('hotel_id');
        $h_room_type_id     = Input::get('h_room_type_id');
        $h_room_category_id = Input::get('h_room_category_id');
        $room_view_id       = Input::get('room_view_id');
        $status             = Input::get('status');
        $description        = Input::get('description');
        $remark             = Input::get('remark');

        $paramObj                       = new Room();
        $paramObj->name                 = $name;
        $paramObj->hotel_id             = $hotel_id;
        $paramObj->h_room_type_id       = $h_room_type_id;
        $paramObj->h_room_category_id   = $h_room_category_id;
        $paramObj->room_view_id         = $room_view_id;
        $paramObj->status               = $status;
        $paramObj->description          = $description;
        $paramObj->remark               = $remark;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room created ...'));
        }
        else{
            return redirect()->action('Setup\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $room                   = $this->repo->getObjByID($id);
            $hotelRepo              = new HotelRepository();
            $hotels                 = $hotelRepo->getObjs();
            $hotelRoomTypeRepo      = new HotelRoomTypeRepository();
            $hotel_room_type        = $hotelRoomTypeRepo->getObjs();
            $hotelRoomCategoryRepo  = new HotelRoomCategoryRepository();
            $hotel_room_category    = $hotelRoomCategoryRepo->getObjs();
            $roomViewRepo           = new RoomViewRepository();
            $room_view              = $roomViewRepo->getObjs();
            return view('backend.room.room')->with('room', $room)
                                            ->with('hotels',$hotels)
                                            ->with('room_view',$room_view)
                                            ->with('hotel_room_type',$hotel_room_type)
                                            ->with('hotel_room_category',$hotel_room_category);
        }
        return redirect('/backend/login');
    }

    public function update(RoomEditRequest $request){

        $request->validate();
        $id                 = Input::get('id');
        $name               = Input::get('name');
        $hotel_id           = Input::get('hotel_id');
        $h_room_type_id     = Input::get('h_room_type_id');
        $h_room_category_id = Input::get('h_room_category_id');
        $room_view_id       = Input::get('room_view_id');
        $status             = Input::get('status');
        $description        = Input::get('description');
        $remark             = Input::get('remark');

        $paramObj                       = $this->repo->getObjByID($id);
        $paramObj->name                 = $name;
        $paramObj->hotel_id             = $hotel_id;
        $paramObj->h_room_type_id       = $h_room_type_id;
        $paramObj->h_room_category_id   = $h_room_category_id;
        $paramObj->room_view_id         = $room_view_id;
        $paramObj->status               = $status;
        $paramObj->description          = $description;
        $paramObj->remark               = $remark;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room updated ...'));
        }
        else{
            return redirect()->action('Setup\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\Room\RoomController@index'); //to redirect listing page
    }

}
