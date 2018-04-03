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
            //Get Loggin User Info

            $user               = $this->repo->getUserObjs();
            $id                 = $user->id;
            $role               = $user->role_id;
            $email              = $user->email;

            if ($role == 3) {
                //Get Hotel ID
                $hotelRepo          = new HotelRepository();
                $hotels             = $hotelRepo->getHotelByUserEmail($email);
                foreach($hotels as $hotel){
                    $h_id = $hotel->id;
                }
                $rooms = $this->repo->getObjsByHotelId($h_id);
            } else {
                $rooms = $this->repo->getObjs();
            }
            return view('backend.room.index')->with('rooms',$rooms);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $user               = $this->repo->getUserObjs();
            $id                 = $user->id;
            $role               = $user->role_id;
            $email              = $user->email;

            $hotelRepo          = new HotelRepository();
            if ($role == 3) {
                $hotels         = $hotelRepo->getHotelByUserEmail($email);
            } else {
                $hotels         = $hotelRepo->getObjs();
            }
            $roomViewRepo       = new RoomViewRepository();
            $room_view          = $roomViewRepo->getObjs();
            return view('backend.room.room')->with('hotels',$hotels)
                                            ->with('role',$role)
                                            ->with('room_view',$room_view);
        }
        return redirect('/');
    }

    public function store(RoomEntryRequest $request)
    {
        $request->validate();
        $room_name          = Input::get('room_name');
        $hotel_id           = Input::get('hotel_id');
        // $h_room_type_id     = Input::get('h_room_type_id');
        $h_room_category_id = Input::get('h_room_category_id');
        $room_view_id       = Input::get('room_view_id');
//        $apply_cutoff_date  = Input::get('apply_cutoff_date');
        $apply_cutoff_date  = (Input::has('apply_cutoff_date')) ? Input::get('apply_cutoff_date') : 0;
        $status             = Input::get('status');
//        $no_of_rooms        = Input::get('number_of_rooms');
        $description        = Input::get('description');
        $remark             = Input::get('remark');

        $roomCategoryRepo   = new HotelRoomCategoryRepository();
        $roomCategory       = $roomCategoryRepo->getObjByID($h_room_category_id);

        $h_room_type_id     = $roomCategory->h_room_type_id;

        foreach($room_name as $name){
            $paramObj                       = new Room();
            $paramObj->name                 = $name;
            $paramObj->hotel_id             = $hotel_id;
            $paramObj->h_room_type_id       = $h_room_type_id;
            $paramObj->h_room_category_id   = $h_room_category_id;
            $paramObj->room_view_id         = $room_view_id;
            $paramObj->apply_cutoff_date    = $apply_cutoff_date;
            $paramObj->status               = $status;
            $paramObj->description          = $description;
            $paramObj->remark               = $remark;

            $result = $this->repo->create($paramObj);

            if($result['aceplusStatusCode'] != ReturnMessage::OK){
                return redirect()->action('Setup\Room\RoomController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Room is not created ...'));
            }

        }

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room is created ...'));
        }
        /*
        else{
            return redirect()->action('Setup\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room is not created ...'));
        }*/
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            //Check User has permiision to edit or not
            $user                   = $this->repo->getUserObjs();
            $email                  = $user->email;
            $role                   = $user->role_id;
            $uid                    = $user->id;

            $hotelRepo              = new HotelRepository();

            if ($role == 3) {
                $room                   = $this->repo->getObjByID($id);
                $hotel_id               = $room->hotel_id;
                $h_room_type_id         = $room->h_room_type_id;
                $hotels                 = $hotelRepo->getHotelByUserEmail($email);
                $hotelRoomTypeRepo      = new HotelRoomTypeRepository();
                $hotel_room_type        = $hotelRoomTypeRepo->getHotelRoomTypeWithHotelId($hotel_id);
                $hotelRoomCategoryRepo  = new HotelRoomCategoryRepository();
                // $hotel_room_category    = $hotelRoomCategoryRepo->getHotelRoomCategoryWithRoomTypeId($h_room_type_id);
                $hotel_room_category    = $hotelRoomCategoryRepo->getHotelRoomCategoryWithHotelId($hotel_id);
                $roomViewRepo           = new RoomViewRepository();
                $room_view              = $roomViewRepo->getObjs();
            } else {
                $room                   = $this->repo->getObjByID($id);
                $hotel_id               = $room->hotel_id;
                $h_room_type_id         = $room->h_room_type_id;
                $hotels                 = $hotelRepo->getObjs();
                $hotelRoomTypeRepo      = new HotelRoomTypeRepository();
                $hotel_room_type        = $hotelRoomTypeRepo->getHotelRoomTypeWithHotelId($hotel_id);

                $hotelRoomCategoryRepo  = new HotelRoomCategoryRepository();
                // $hotel_room_category    = $hotelRoomCategoryRepo->getHotelRoomCategoryWithRoomTypeId($h_room_type_id);
                $hotel_room_category    = $hotelRoomCategoryRepo->getHotelRoomCategoryWithHotelId($hotel_id);
                $roomViewRepo           = new RoomViewRepository();
                $room_view              = $roomViewRepo->getObjs();
            }

            return view('backend.room.room')->with('room', $room)
                                            ->with('hotels',$hotels)
                                            ->with('room_view',$room_view)
                                            ->with('hotel_room_type',$hotel_room_type)
                                            ->with('role',$role)
                                            ->with('hotel_room_category',$hotel_room_category);
        }
        return redirect('/backend_mps/login');
    }

    public function update(RoomEditRequest $request){

        $request->validate();
        $id                 = Input::get('id');
        $name               = Input::get('room_name');
        $hotel_id           = Input::get('hotel_id');
        // $h_room_type_id     = Input::get('h_room_type_id');
        $h_room_category_id = Input::get('h_room_category_id');
        $room_view_id       = Input::get('room_view_id');
        $apply_cutoff_date  = Input::get('apply_cutoff_date');
        $status             = Input::get('status');
        $description        = Input::get('description');
        $remark             = Input::get('remark');

        $roomCategoryRepo   = new HotelRoomCategoryRepository();
        $roomCategory       = $roomCategoryRepo->getObjByID($h_room_category_id);

        $h_room_type_id     = $roomCategory->h_room_type_id;

        $paramObj                       = $this->repo->getObjByID($id);
        $paramObj->name                 = $name;
        $paramObj->hotel_id             = $hotel_id;
        $paramObj->h_room_type_id       = $h_room_type_id;
        $paramObj->h_room_category_id   = $h_room_category_id;
        $paramObj->room_view_id         = $room_view_id;
        $paramObj->apply_cutoff_date    = $apply_cutoff_date;
        $paramObj->status               = $status;
        $paramObj->description          = $description;
        $paramObj->remark               = $remark;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room is updated ...'));
        }
        else{
            return redirect()->action('Setup\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        $delete_flag = true;
        foreach($new_string as $id){
            //check whether this room is booked (with status pending or confirm) or not
            $check = $this->repo->checkToDelete($id);

            if(isset($check) && count($check)>0){
                alert()->warning('This room is booked and you cannot delete it!')->persistent('OK');
                $delete_flag = false;
            }
            else{
                $this->repo->delete($id);
            }
        }
        if($delete_flag){
            return redirect()->action('Setup\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room is deleted ...'));
        }
        else{
            return redirect()->action('Setup\Room\RoomController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room is not deleted ...'));
        }
    }

    public function getRoom($hotel_id){
        $result = $this->repo->getObjsByHotelId($hotel_id);

        return \Response::json($result);
    }

}
