<?php

namespace App\Http\Controllers\Setup\HotelNearbyCategory;

use App\Backend\Infrastructure\Forms\HotelCategoryEditRequest;
use App\Backend\Infrastructure\Forms\HotelCategoryEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\HotelNearbyCategory\HotelNearbyCategoryRepositoryInterface;
use App\Setup\HotelNearbyCategory\HotelNearbyCategoryRepository;
use App\Setup\HotelNearbyCategory\HotelNearbyCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;

class HotelNearbyCategoryController extends Controller
{
    private $repo;

    public function __construct(HotelNearbyCategoryRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_categories       = $this->repo->getObjs();
            return view('backend.hotel_nearby_category.index')->with('hotel_categories',$hotel_categories);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            return view('backend.hotel_category.hotel_category');
        }
        return redirect('/');
    }

    public function store(HotelCategoryEntryRequest $request)
    {
        $request->validate();
        $category               = Input::get('category');
        $description            = Input::get('description');

        $paramObj               = new HotelNearbyCategory();
        $paramObj->name         = $category;
        $paramObj->description  = $description;

        $result                 = $this->repo->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelNearbyCategory\HotelNearbyCategoryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby Category created ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearbyCategory\HotelNearbyCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby Category did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_category    = $this->repo->getObjByID($id);
            return view('backend.hotel_category.hotel_category')
                ->with('hotel_category',$hotel_category);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelCategoryEditRequest $request){

        $request->validate();
        $id                                 = Input::get('id');
        $category               = Input::get('category');
        $description            = Input::get('description');

        $paramObj               = $this->repo->getObjByID($id);
        $paramObj->name         = $category;
        $paramObj->description  = $description;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelNearbyCategory\HotelNearbyCategoryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby Category updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearbyCategory\HotelNearbyCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby Category did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelNearbyCategory\HotelNearbyCategoryController@index'); //to redirect listing page
    }
}
