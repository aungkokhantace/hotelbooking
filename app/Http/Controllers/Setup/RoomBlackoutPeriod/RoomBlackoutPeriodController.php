<?php

namespace App\Http\Controllers\Setup\RoomBlackoutPeriod;

use App\Backend\Infrastructure\Forms\RoomBlackoutPeriodEditRequest;
use App\Backend\Infrastructure\Forms\RoomBlackoutPeriodEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\Room\RoomRepository;
use App\Setup\RoomBlackoutPeriod\RoomBlackoutPeriod;
use App\Setup\RoomBlackoutPeriod\RoomBlackoutPeriodRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class RoomBlackoutPeriodController extends Controller
{
    private $repo;

    public function __construct(RoomBlackoutPeriodRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $room_blackout_period = $this->repo->getObjs();
            return view('backend.room_blackout_period.index')->with('room_blackout_period',$room_blackout_period);
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
            return view('backend.room_blackout_period.room_blackout_period')->with('hotels',$hotels)
                                                                            ->with('rooms',$rooms);
        }
        return redirect('/');
    }

    public function store(RoomBlackoutPeriodEntryRequest $request)
    {
        $request->validate();
        $hotel_id           = Input::get('hotel_id');
        $room_id            = Input::get('room_id');
        $from_date          = Carbon::parse(Input::get('from_date'))->format('Y-m-d');
        $to_date            = Carbon::parse(Input::get('to_date'))->format('Y-m-d');
        $remark             = Input::get('remark');

        $paramObj                       = new RoomBlackoutPeriod();
        $paramObj->hotel_id             = $hotel_id;
        $paramObj->room_id              = $room_id;
        $paramObj->from_date            = $from_date;
        $paramObj->to_date              = $to_date;
        $paramObj->remark               = $remark;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room Blackout Period created ...'));
        }
        else{
            return redirect()->action('Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room Blackout Period did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $r_blackout_period      = $this->repo->getObjByID($id);
            $hotel_id               = $r_blackout_period->hotel_id;
            $hotelRepo              = new HotelRepository();
            $hotels                 = $hotelRepo->getObjs();
            $roomRepo               = new RoomRepository();
            $rooms                  = $roomRepo->getObjsByHotelId($hotel_id);
            return view('backend.room_blackout_period.room_blackout_period')->with('r_blackout_period', $r_blackout_period)
                                            ->with('hotels',$hotels)
                                            ->with('rooms',$rooms);
        }
        return redirect('/backend/login');
    }

    public function update(RoomBlackoutPeriodEditRequest $request){

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
            return redirect()->action('Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room Blackout Period updated ...'));
        }
        else{
            return redirect()->action('Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room Blackout Period did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@index'); //to redirect listing page
    }
}
