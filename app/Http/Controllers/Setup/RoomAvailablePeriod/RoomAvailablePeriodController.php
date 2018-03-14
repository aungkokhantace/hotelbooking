<?php

namespace App\Http\Controllers\Setup\RoomAvailablePeriod;

use App\Backend\Infrastructure\Forms\RoomAvailablePeriodEditRequest;
use App\Backend\Infrastructure\Forms\RoomAvailablePeriodEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\Room\RoomRepository;
use App\Setup\RoomAvailablePeriod\RoomAvailablePeriod;
use App\Setup\RoomAvailablePeriod\RoomAvailablePeriodRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class RoomAvailablePeriodController extends Controller
{
    private $repo;

    public function __construct(RoomAvailablePeriodRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
          //Get Loggin User Info
          $hotelRepo          = new HotelRepository();
          $user               = $hotelRepo->getUserObjs();
          $id                 = $user->id;
          $role               = $user->role_id;
          $email              = $user->email;
          if ($role == 3) {
              //Get Hotel ID
              $hotel = $hotelRepo->getFirstHotelByUserEmail($email);
              $room_available_period             = $this->repo->getObjByH_Id($hotel->id);
          } else {
               $room_available_period = $this->repo->getObjs();
          }
          return view('backend.room_available_period.index')->with('room_available_period',$room_available_period);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo          = new HotelRepository();
            $hotels             = $hotelRepo->getObjs();
            $roomRepo           = new RoomRepository();
            $rooms              = $roomRepo->getObjs();
            return view('backend.room_available_period.room_available_period')->with('hotels',$hotels)
                                                                              ->with('rooms',$rooms);
        }
        return redirect('/');
    }

    public function store(RoomAvailablePeriodEntryRequest $request)
    {
        $request->validate();
        $hotel_id           = Input::get('hotel_id');
        $room_id            = Input::get('room_id');
        $from_date          = Carbon::parse(Input::get('from_date'))->format('Y-m-d');
        $to_date            = Carbon::parse(Input::get('to_date'))->format('Y-m-d');
        $remark             = Input::get('remark');

        $paramObj                       = new RoomAvailablePeriod();
        $paramObj->hotel_id             = $hotel_id;
        $paramObj->room_id              = $room_id;
        $paramObj->from_date            = $from_date;
        $paramObj->to_date              = $to_date;
        $paramObj->remark               = $remark;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomAvailablePeriod\RoomAvailablePeriodController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room Available Period created ...'));
        }
        else{
            return redirect()->action('Setup\RoomAvailablePeriod\RoomAvailablePeriodController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room Available Period did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $r_available_period     = $this->repo->getObjByID($id);
            $hotel_id               = $r_available_period->hotel_id;
            $hotelRepo              = new HotelRepository();
            $hotels                 = $hotelRepo->getObjs();
            $roomRepo               = new RoomRepository();
            $rooms                  = $roomRepo->getObjsByHotelId($hotel_id);
            return view('backend.room_available_period.room_available_period')->with('r_available_period', $r_available_period)
                                                                              ->with('hotels',$hotels)
                                                                              ->with('rooms',$rooms);
        }
        return redirect('/backend_mps/login');
    }

    public function update(RoomAvailablePeriodEditRequest $request){

        $request->validate();
        $id                     = Input::get('id');
        $hotel_id               = Input::get('hotel_id');
        $room_id                = Input::get('room_id');
        $from_date              = Carbon::parse(Input::get('from_date'))->format('Y-m-d');
        $to_date                = Carbon::parse(Input::get('to_date'))->format('Y-m-d');
        $remark                 = Input::get('remark');


        $paramObj               = $this->repo->getObjByID($id);
        $paramObj->hotel_id     = $hotel_id;
        $paramObj->room_id      = $room_id;
        $paramObj->from_date    = $from_date;
        $paramObj->to_date      = $to_date;
        $paramObj->remark       = $remark;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomAvailablePeriod\RoomAvailablePeriodController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room Available Period updated ...'));
        }
        else{
            return redirect()->action('Setup\RoomAvailablePeriod\RoomAvailablePeriodController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room Available Period did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\RoomAvailablePeriod\RoomAvailablePeriodController@index'); //to redirect listing page
    }
}
