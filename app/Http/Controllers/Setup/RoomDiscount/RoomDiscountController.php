<?php

namespace App\Http\Controllers\Setup\RoomDiscount;

use App\Backend\Infrastructure\Forms\RoomDiscountEditRequest;
use App\Backend\Infrastructure\Forms\RoomDiscountEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\HotelRoomType\HotelRoomTypeRepository;
use App\Setup\RoomDiscount\RoomDiscount;
use App\Setup\RoomDiscount\RoomDiscountRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Core\Utility;

class RoomDiscountController extends Controller
{
    private $repo;

    public function __construct(RoomDiscountRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
          //get current user obj
          $current_user         = Utility::getCurrentUser();

          //if hotel admin, display only restaurants he or she belongs to
          if ($current_user->role_id == 3) {
            $hotelRepo          = new HotelRepository();
            $hotel              = $hotelRepo->getFirstHotelByUserEmail($current_user->email);
            $room_discount   = $this->repo->getObjsByHotelId($hotel->id);
          }
          else {
             $room_discount = $this->repo->getObjs();
          }

          return view('backend.room_discount.index')->with('room_discount',$room_discount);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
          //get current user obj
          $current_user         = Utility::getCurrentUser();

          $hotelRepo          = new HotelRepository();

          //if hotel admin, display only restaurants he or she belongs to
          if ($current_user->role_id == 3) {
            $hotels              = $hotelRepo->getHotelByUserEmail($current_user->email);
          }
          else {
            $hotels             = $hotelRepo->getObjs();
          }
          return view('backend.room_discount.room_discount')->with('hotels',$hotels);
        }
        return redirect('/');
    }

    public function store(RoomDiscountEntryRequest $request)
    {
        $request->validate();
        $hotel_id           = Input::get('hotel_id');
        // $h_room_type_id     = Input::get('h_room_type_id');
        $h_room_category_id = Input::get('h_room_category_id');
        $name               = Input::get('name');
        $type               = Input::get('type');
        $amount             = Input::get('discount_amount');
        $from_date          = Carbon::parse(Input::get('from_date'))->format('Y-m-d');
        $to_date            = Carbon::parse(Input::get('to_date'))->format('Y-m-d');
        $remark             = Input::get('remark');

        //get room_type_id from room category
        $roomCategoryRepo   = new HotelRoomCategoryRepository();
        $roomCategory       = $roomCategoryRepo->getObjByID($h_room_category_id);
        $h_room_type_id     = $roomCategory->h_room_type_id;

        $paramObj                       = new RoomDiscount();
        $paramObj->name                 = $name;
        $paramObj->hotel_id             = $hotel_id;
        $paramObj->h_room_type_id       = $h_room_type_id;
        $paramObj->h_room_category_id   = $h_room_category_id;
        $paramObj->type                 = $type;
        $paramObj->from_date            = $from_date;
        $paramObj->to_date              = $to_date;
        $paramObj->remark               = $remark;

        if($type == '%'){
            $paramObj->discount_percent = $amount;
            $paramObj->discount_amount  = 0.00;
        }
        else{
            $paramObj->discount_percent = 0;
            $paramObj->discount_amount  = $amount;
        }

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomDiscount\RoomDiscountController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room Discount is created ...'));
        }
        else{
            return redirect()->action('Setup\RoomDiscount\RoomDiscountController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room Discount is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            //get current user obj
            $current_user         = Utility::getCurrentUser();

            $room_discount          = $this->repo->getObjByID($id);
            $hotel_id               = $room_discount->hotel_id;
            $h_room_type_id         = $room_discount->h_room_type_id;
            $hotelRepo              = new HotelRepository();
            // $hotels                 = $hotelRepo->getObjs();

            //if hotel admin, display only restaurants he or she belongs to
            if ($current_user->role_id == 3) {
              $hotels              = $hotelRepo->getHotelByUserEmail($current_user->email);
            }
            else {
              $hotels             = $hotelRepo->getObjs();
            }

            $hotelRoomTypeRepo      = new HotelRoomTypeRepository();
            $hotel_room_type        = $hotelRoomTypeRepo->getHotelRoomTypeWithHotelId($hotel_id);
            $hotelRoomCategoryRepo  = new HotelRoomCategoryRepository();
            // $hotel_room_category    = $hotelRoomCategoryRepo->getHotelRoomCategoryWithRoomTypeId($h_room_type_id);
            $hotel_room_category    = $hotelRoomCategoryRepo->getHotelRoomCategoryWithHotelId($hotel_id);

            return view('backend.room_discount.room_discount')->with('room_discount', $room_discount)
                ->with('hotels',$hotels)
                ->with('hotel_room_type',$hotel_room_type)
                ->with('hotel_room_category',$hotel_room_category);
        }
        return redirect('/backend_mps/login');
    }

    public function update(RoomDiscountEditRequest $request){

        $request->validate();
        $id                 = Input::get('id');
        $hotel_id           = Input::get('hotel_id');
        // $h_room_type_id     = Input::get('h_room_type_id');
        $h_room_category_id = Input::get('h_room_category_id');
        $name               = Input::get('name');
        $type               = Input::get('type');
        $amount             = Input::get('discount_amount');
        $from_date          = Carbon::parse(Input::get('from_date'))->format('Y-m-d');
        $to_date            = Carbon::parse(Input::get('to_date'))->format('Y-m-d');
        $remark             = Input::get('remark');

        //get room_type_id from room category
        $roomCategoryRepo   = new HotelRoomCategoryRepository();
        $roomCategory       = $roomCategoryRepo->getObjByID($h_room_category_id);
        $h_room_type_id     = $roomCategory->h_room_type_id;

        $paramObj                       = $this->repo->getObjByID($id);
        $paramObj->name                 = $name;
        $paramObj->hotel_id             = $hotel_id;
        $paramObj->h_room_type_id       = $h_room_type_id;
        $paramObj->h_room_category_id   = $h_room_category_id;
        $paramObj->type                 = $type;
        $paramObj->from_date            = $from_date;
        $paramObj->to_date              = $to_date;
        $paramObj->remark               = $remark;

        if($type == '%'){
            $paramObj->discount_percent = $amount;
            $paramObj->discount_amount  = 0.00;
        }
        else{
            $paramObj->discount_percent = 0;
            $paramObj->discount_amount  = $amount;
        }

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomDiscount\RoomDiscountController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room Discount is updated ...'));
        }
        else{
            return redirect()->action('Setup\RoomDiscount\RoomDiscountController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room Discount is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\RoomDiscount\RoomDiscountController@index'); //to redirect listing page
    }
}
