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
            $hotel_restaurant = $this->repo->getObjs();
            return view('backend.hotel_restaurant.index')->with('hotel_restaurant',$hotel_restaurant);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo                  = new HotelRepository();
            $hotels                     = $hotelRepo->getObjs();
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
        $name                       = Input::get('name');
        $opening_hours              = Input::get('opening_hours');
        $opening_days               = Input::get('opening_days');
        $capacity                   = Input::get('capacity');
        $area                       = Input::get('area');
        $floor                      = Input::get('floor');
        $private_room               = Input::get('private_room') == "true"? 1: 0;
        $hotel_id                   = Input::get('hotel_id');
        $h_restaurant_category_id   = Input::get('hotel_restaurant_category');
        $description                = Input::get('description');
        $remark                     = Input::get('remark');

        $paramObj                           = new HotelRestaurant();
        $paramObj->name                     = $name;
        $paramObj->opening_hours            = $opening_hours;
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
                ->withMessage(FormatGenerator::message('Success', 'Hotel Restaurant created ...'));
        }
        else{
            return redirect()->action('Setup\HotelRestaurant\HotelRestaurantController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Restaurant did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotelRepo                  = new HotelRepository();
            $hotels                     = $hotelRepo->getObjs();
            $categoryRepo               = new HotelRestaurantCategoryRepository();
            $hotel_restaurant_category  = $categoryRepo->getObjs();
            $hotel_restaurant           = $this->repo->getObjByID($id);
            return view('backend.hotel_restaurant.hotel_restaurant')->with('hotel_restaurant', $hotel_restaurant)
                                                                    ->with('hotels',$hotels)
                                                                    ->with('hotel_restaurant_category',$hotel_restaurant_category);
        }
        return redirect('/backend/login');
    }

    public function update(HotelRestaurantEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $name                       = Input::get('name');
        $opening_hours              = Input::get('opening_hours');
        $opening_days               = Input::get('opening_days');
        $capacity                   = Input::get('capacity');
        $area                       = Input::get('area');
        $floor                      = Input::get('floor');
        $private_room               = Input::get('private_room') == "true"? 1: 0;;
        $hotel_id                   = Input::get('hotel_id');
        $h_restaurant_category_id   = Input::get('hotel_restaurant_category');
        $description                = Input::get('description');
        $remark                     = Input::get('remark');

        $paramObj                           = $this->repo->getObjByID($id);
        $paramObj->name                     = $name;
        $paramObj->opening_hours            = $opening_hours;
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
                ->withMessage(FormatGenerator::message('Success', 'Hotel Restaurant updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelRestaurant\HotelRestaurantController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Restaurant did not update ...'));
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
