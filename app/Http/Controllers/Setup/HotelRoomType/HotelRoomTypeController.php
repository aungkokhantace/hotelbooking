<?php

namespace App\Http\Controllers\Setup\HotelRoomType;

use App\Backend\Infrastructure\Forms\HotelRoomTypeEditRequest;
use App\Backend\Infrastructure\Forms\HotelRoomTypeEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRoomType\HotelRoomType;
use App\Setup\HotelRoomType\HotelRoomTypeRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class HotelRoomTypeController extends Controller
{
    private $repo;

    public function __construct(HotelRoomTypeRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_room_type = $this->repo->getObjs();
            return view('backend.hotel_room_type.index')->with('hotel_room_type',$hotel_room_type);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo  = new HotelRepository();
            $hotels     = $hotelRepo->getObjs();
            return view('backend.hotel_room_type.hotel_room_type')->with('hotels',$hotels);
        }
        return redirect('/');
    }

    public function store(HotelRoomTypeEntryRequest $request)
    {
        $request->validate();
        $name               = Input::get('name');
        $description        = Input::get('description');
        $hotel_id           = Input::get('hotel_id');

        $paramObj               = new HotelRoomType();
        $paramObj->hotel_id     = $hotel_id;
        $paramObj->name         = $name;
        $paramObj->description  = $description;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelRoomType\HotelRoomTypeController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Room Type created ...'));
        }
        else{
            return redirect()->action('Setup\HotelRoomType\HotelRoomTypeController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Type did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_room_type    = $this->repo->getObjByID($id);
            $hotelRepo          = new HotelRepository();
            $hotels             = $hotelRepo->getObjs();
            return view('backend.hotel_room_type.hotel_room_type')->with('hotel_room_type', $hotel_room_type)->with('hotels',$hotels);
        }
        return redirect('/backend/login');
    }

    public function update(HotelRoomTypeEditRequest $request){

        $request->validate();
        $id                                         = Input::get('id');
        $hotel_id                                   = Input::get('hotel_id');
        $name                                       = Input::get('name');
        $description                                = Input::get('description');

        $paramObj                                   = $this->repo->getObjByID($id);
        $paramObj->hotel_id                         = $hotel_id;
        $paramObj->name                             = $name;
        $paramObj->description                      = $description;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelRoomType\HotelRoomTypeController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Room Type updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelRoomType\HotelRoomTypeController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Type did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelRoomType\HotelRoomTypeController@index'); //to redirect listing page
    }

    public function getHotelRoomType($hotel_id){
        $result = $this->repo->getHotelRoomTypeWithHotelId($hotel_id);

        return \Response::json($result);
    }

}
