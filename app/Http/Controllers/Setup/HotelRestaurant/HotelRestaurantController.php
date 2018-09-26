<?php

namespace App\Http\Controllers\Setup\HotelRestaurant;

use App\Backend\Infrastructure\Forms\HotelRestaurantEditRequest;
use App\Backend\Infrastructure\Forms\HotelRestaurantEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRestaurant\HotelRestaurant;
use App\Setup\HotelRestaurant\HotelRestaurantRepositoryInterface;
use App\Setup\HotelRestaurantCategory\HotelRestaurantCategoryRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Core\Utility;

class HotelRestaurantController extends Controller
{
    private $repo;

    public function __construct(HotelRestaurantRepositoryInterface $repo)
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
            $hotel_restaurant   = $this->repo->getHotelRestaurantsByHotelId($hotel->id);
          }
          else {
             $hotel_restaurant  = $this->repo->getObjs();
          }
          return view('backend.hotel_restaurant.index')->with('hotel_restaurant',$hotel_restaurant);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
          //get current user obj
          $current_user         = Utility::getCurrentUser();

          $hotelRepo                  = new HotelRepository();
          // $hotels                     = $hotelRepo->getObjs();

          //if hotel admin, display only restaurants he or she belongs to
          if ($current_user->role_id == 3) {
            $hotels              = $hotelRepo->getHotelByUserEmail($current_user->email);
          }
          else {
            $hotels             = $hotelRepo->getObjs();
          }

          $categoryRepo               = new HotelRestaurantCategoryRepository();
          $hotel_restaurant_category  = $categoryRepo->getObjs();
          return view('backend.hotel_restaurant.hotel_restaurant')->with('hotels',$hotels)
                                                                  ->with('hotel_restaurant_category',$hotel_restaurant_category);
        }
        return redirect('/');
    }

    public function store(HotelRestaurantEntryRequest $request)
    {
        $request->validate();
        $name                               = Input::get('name');
        $has_separate_open_close_hours      = Input::get('has_separate_open_close_hours');
        $normal_opening_hours               = Input::get('normal_opening_hours');
        $normal_closing_hours               = Input::get('normal_closing_hours');
        $breakfast_opening_hours            = Input::get('breakfast_opening_hours');
        $breakfast_closing_hours            = Input::get('breakfast_closing_hours');
        $lunch_opening_hours                = Input::get('lunch_opening_hours');
        $lunch_closing_hours                = Input::get('lunch_closing_hours');
        $dinner_opening_hours               = Input::get('dinner_opening_hours');
        $dinner_closing_hours               = Input::get('dinner_closing_hours');
        $opening_days                       = Input::get('opening_days');
        $capacity                           = Input::get('capacity');
        $area                               = Input::get('area');
        $floor                              = Input::get('floor');
        $private_room                       = Input::get('private_room') == "true"? 1: 0;
        $hotel_id                           = Input::get('hotel_id');
        $h_restaurant_category_id           = Input::get('hotel_restaurant_category');
        $description                        = Input::get('description');
        $remark                             = Input::get('remark');

        $paramObj                           = new HotelRestaurant();
        $paramObj->name                     = $name;
        $paramObj->has_separate_open_close_hours = $has_separate_open_close_hours;

        //if restaurant has separate opening/closing hours, set normal hours to null
        if($has_separate_open_close_hours == 1){
          $paramObj->normal_opening_hours     = null;
          $paramObj->normal_closing_hours     = null;

          $paramObj->breakfast_opening_hours  = $breakfast_opening_hours;
          $paramObj->breakfast_closing_hours  = $breakfast_closing_hours;
          $paramObj->lunch_opening_hours      = $lunch_opening_hours;
          $paramObj->lunch_closing_hours      = $lunch_closing_hours;
          $paramObj->dinner_opening_hours     = $dinner_opening_hours;
          $paramObj->dinner_closing_hours     = $dinner_closing_hours;
        }
        //if restaurant doesn't have separate opening/closing hours, set breakfast/lunch/dinner hours to null
        else{
          $paramObj->normal_opening_hours     = $normal_opening_hours;
          $paramObj->normal_closing_hours     = $normal_closing_hours;

          $paramObj->breakfast_opening_hours  = null;
          $paramObj->breakfast_closing_hours  = null;
          $paramObj->lunch_opening_hours      = null;
          $paramObj->lunch_closing_hours      = null;
          $paramObj->dinner_opening_hours     = null;
          $paramObj->dinner_closing_hours     = null;
        }

        $paramObj->opening_days             = $opening_days;
        $paramObj->capacity                 = $capacity;
        $paramObj->area                     = $area;
        $paramObj->floor                    = $floor;
        $paramObj->private_room             = $private_room;
        $paramObj->hotel_id                 = $hotel_id;
        $paramObj->h_restaurant_category_id = $h_restaurant_category_id;
        $paramObj->description              = $description;
        $paramObj->remark                   = $remark;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelRestaurant\HotelRestaurantController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Restaurant is created ...'));
        }
        else{
            return redirect()->action('Setup\HotelRestaurant\HotelRestaurantController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Restaurant is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            //get current user obj
            $current_user         = Utility::getCurrentUser();

            $hotelRepo                  = new HotelRepository();
            // $hotels                     = $hotelRepo->getObjs();

            //if hotel admin, display only restaurants he or she belongs to
            if ($current_user->role_id == 3) {
              $hotels              = $hotelRepo->getHotelByUserEmail($current_user->email);
            }
            else {
              $hotels             = $hotelRepo->getObjs();
            }

            $categoryRepo               = new HotelRestaurantCategoryRepository();
            $hotel_restaurant_category  = $categoryRepo->getObjs();
            $hotel_restaurant           = $this->repo->getObjByID($id);

            return view('backend.hotel_restaurant.hotel_restaurant')->with('hotel_restaurant', $hotel_restaurant)
                                                                    ->with('hotels',$hotels)
                                                                    ->with('hotel_restaurant_category',$hotel_restaurant_category);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelRestaurantEditRequest $request){

        $request->validate();
        $id                                 = Input::get('id');
        $name                               = Input::get('name');
        $has_separate_open_close_hours      = Input::get('has_separate_open_close_hours');
        $normal_opening_hours               = Input::get('normal_opening_hours');
        $normal_closing_hours               = Input::get('normal_closing_hours');
        $breakfast_opening_hours            = Input::get('breakfast_opening_hours');
        $breakfast_closing_hours            = Input::get('breakfast_closing_hours');
        $lunch_opening_hours                = Input::get('lunch_opening_hours');
        $lunch_closing_hours                = Input::get('lunch_closing_hours');
        $dinner_opening_hours               = Input::get('dinner_opening_hours');
        $dinner_closing_hours               = Input::get('dinner_closing_hours');
        $opening_days                       = Input::get('opening_days');
        $capacity                           = Input::get('capacity');
        $area                               = Input::get('area');
        $floor                              = Input::get('floor');
        $private_room                       = Input::get('private_room') == "true"? 1: 0;;
        $hotel_id                           = Input::get('hotel_id');
        $h_restaurant_category_id           = Input::get('hotel_restaurant_category');
        $description                        = Input::get('description');
        $remark                             = Input::get('remark');

        $paramObj                           = $this->repo->getObjByID($id);
        $paramObj->name                     = $name;
        $paramObj->has_separate_open_close_hours = $has_separate_open_close_hours;

        //if restaurant has separate opening/closing hours, set normal hours to null
        if($has_separate_open_close_hours == 1){
          $paramObj->normal_opening_hours     = null;
          $paramObj->normal_closing_hours     = null;

          $paramObj->breakfast_opening_hours  = $breakfast_opening_hours;
          $paramObj->breakfast_closing_hours  = $breakfast_closing_hours;
          $paramObj->lunch_opening_hours      = $lunch_opening_hours;
          $paramObj->lunch_closing_hours      = $lunch_closing_hours;
          $paramObj->dinner_opening_hours     = $dinner_opening_hours;
          $paramObj->dinner_closing_hours     = $dinner_closing_hours;
        }
        //if restaurant doesn't have separate opening/closing hours, set breakfast/lunch/dinner hours to null
        else{
          $paramObj->normal_opening_hours     = $normal_opening_hours;
          $paramObj->normal_closing_hours     = $normal_closing_hours;

          $paramObj->breakfast_opening_hours  = null;
          $paramObj->breakfast_closing_hours  = null;
          $paramObj->lunch_opening_hours      = null;
          $paramObj->lunch_closing_hours      = null;
          $paramObj->dinner_opening_hours     = null;
          $paramObj->dinner_closing_hours     = null;
        }

        $paramObj->opening_days             = $opening_days;
        $paramObj->capacity                 = $capacity;
        $paramObj->area                     = $area;
        $paramObj->floor                    = $floor;
        $paramObj->private_room             = $private_room;
        $paramObj->hotel_id                 = $hotel_id;
        $paramObj->h_restaurant_category_id = $h_restaurant_category_id;
        $paramObj->description              = $description;
        $paramObj->remark                   = $remark;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelRestaurant\HotelRestaurantController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Restaurant is updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelRestaurant\HotelRestaurantController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Restaurant is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelRestaurant\HotelRestaurantController@index'); //to redirect listing page
    }
}
