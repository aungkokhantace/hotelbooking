<?php

namespace App\Http\Controllers\Setup\HotelRestaurantCategory;

use App\Setup\HotelRestaurantCategory\HotelRestaurantCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\HotelRestaurantCategoryEntryRequest;
use App\Backend\Infrastructure\Forms\HotelRestaurantCategoryEditRequest;
use App\Setup\HotelRestaurantCategory\HotelRestaurantCategoryRepositoryInterface;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;
use App\Core\Check;

class HotelRestaurantCategoryController extends Controller
{
    private $repo;

    public function __construct(HotelRestaurantCategoryRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_restaurant_categories = $this->repo->getObjs();
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

    public function store(HotelRestaurantCategoryEntryRequest $request)
    {
        $request->validate();
        $name               = Input::get('name');
        $description        = Input::get('description');

        $paramObj           = new HotelRestaurantCategory();
        $paramObj->name     = $name;
        $paramObj->description     = $description;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Restaurant Category is created ...'));
        }
        else{
            return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Restaurant Category is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_restaurant_category = $this->repo->getObjByID($id);
            return view('backend.hotel_restaurant_category.hotel_restaurant_category')->with('hotel_restaurant_category', $hotel_restaurant_category);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelRestaurantCategoryEditRequest $request){

        $request->validate();
        $id                                         = Input::get('id');
        $name                                       = Input::get('name');
        $description                                = Input::get('description');

        $paramObj                                   = $this->repo->getObjByID($id);
        $paramObj->name                             = $name;
        $paramObj->description                      = $description;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Restaurant Category is updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Restaurant Category is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        $delete_flag = true;
        foreach($new_string as $id){
          $check = Check::checkToDelete("h_restaurant","h_restaurant_category_id",$id);

          if(isset($check) && count($check)>0){
              alert()->warning('There is restaurant under this restaurant category and you cannot delete it!')->persistent('OK');
              $delete_flag = false;
          }
          else{
              $this->repo->delete($id);
          }
        }
        if($delete_flag){
            return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Restaurant Category is deleted ...'));
        }
        else{
            return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Restaurant Category is not deleted ...'));
        }
        // return redirect()->action('Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index'); //to redirect listing page
    }
}
