<?php

namespace App\Http\Controllers\Setup\HotelRestaurantCategory;

use App\Setup\HotelRestaurantCategory\HotelRestaurantCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\HotelRestaurantCategoryEntryFormRequest;
use App\Backend\Infrastructure\Forms\HotelRestaurantCategoryEditRequest;
use App\Setup\HotelRestaurantCategory\HotelRestaurantCategoryRepositoryInterface;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;

class HotelRestaurantCategoryController extends Controller
{
    private $hotel_restaurant_categoryRepository;

    public function __construct(HotelRestaurantCategoryRepositoryInterface $hotel_restaurant_categoryRepository)
    {
        $this->hotel_restaurant_categoryRepository = $hotel_restaurant_categoryRepository;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_restaurant_categories = HotelRestaurantCategory::all();
            return view('backend.hotel_restaurant_category.index')->with('hotel_restaurant_categories',$hotel_restaurant_categories);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            return view('backend.hotel_restaurant_category.hotel_restaurant_category');
        }
        return redirect('/');
    }

    public function store(HotelRestaurantCategoryEntryFormRequest $request)
    {
        $request->validate();
        $hotel_restaurant_category       = Input::get('hotel_restaurant_category');

        $paramObj                            = new HotelRestaurantCategory();
        $paramObj->hotel_restaurant_category = $hotel_restaurant_category;

        $result = $this->hotel_restaurant_categoryRepository->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index')
                ->withMessage(FormatGenerator::message('Success', 'HotelRestaurantCategory created ...'));
        }
        else{

            return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'HotelRestaurantCategory did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_restaurant_category = HotelRestaurantCategory::find($id);
            return view('backend.country.country')->with('hotel_restaurant_category', $hotel_restaurant_category);
        }
        return redirect('/backend/login');
    }

    public function update(HotelRestaurantCategoryEditRequest $request){

        $request->validate();
        $id                                         = Input::get('id');
        $hotel_restaurant_category_name             = Input::get('hotel_restaurant_category_name');
        $paramObj                                   = HotelRestaurantCategory::find($id);
        $paramObj->hotel_restaurant_category_name   = $hotel_restaurant_category_name;

        $result = $this->hotel_restaurant_categoryRepository->update($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index')
                ->withMessage(FormatGenerator::message('Success', 'HotelRestaurantCategory updated ...'));
        }
        else{

            return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'HotelRestaurantCategory did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->hotel_restaurant_categoryRepository->delete($id);
        }
        return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index'); //to redirect listing page
    }

    public function check_country_name(){
        $hotel_restaurant_category_name  = Input::get('hotel_restaurant_category_name');
        $hotel_restaurant_category       = HotelRestaurantCategory::where('hotel_restaurant_category_name','=',$hotel_restaurant_category_name)->whereNull('deleted_at')->get();
        $result             = false;
        if(count($hotel_restaurant_category) == 0 ){
            $result = true;
        }

        return \Response::json($result);
    }


}
