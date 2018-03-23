<?php

namespace App\Http\Controllers\Setup\HotelNearby;

use App\Backend\Infrastructure\Forms\HotelNearbyEditRequest;
use App\Backend\Infrastructure\Forms\HotelNearbyEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\HotelNearby\HotelNearbyRepositoryInterface;
use App\Setup\HotelNearby\HotelNearbyRepository;
use App\Setup\HotelNearby\HotelNearby;
use App\Setup\HotelNearbyCategory\HotelNearbyCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;

class HotelNearbyController extends Controller
{
    private $repo;

    public function __construct(HotelNearbyRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
         if (Auth::guard('User')->check()) {
             $hotel_nearby       = $this->repo->getObjs();
             return view('backend.hotelnearby.index')->with('hotel_nearby',$hotel_nearby);
         }
         return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $nearby_categories      = HotelNearbyCategory::whereNull('deleted_at')->get();

            return view('backend.hotelnearby.hotel_nearby')->with('nearby_categories',$nearby_categories);
        }
        return redirect('/');
    }

    public function store(HotelNearbyEntryRequest $request)
    {
        $request->validate();
        $name                   = Input::get('name');
        $hotel_category         = Input::get('hotel_category');
        $description            = Input::get('description');

        $paramObj                        = new HotelNearby();
        $paramObj->name                  = $name;
        $paramObj->h_nearby_category_id  = $hotel_category;
        $paramObj->description           = $description;
        $paramObj->status                = 1;

        $result                 = $this->repo->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelNearby\HotelNearbyController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby is created ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearby\HotelNearbyController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_nearby       = $this->repo->getObjByID($id);
            $nearby_categories  = $this->repo->getArrays();

            return view('backend.hotelnearby.hotel_nearby')
                ->with('nearby_categories',$nearby_categories)
                ->with('hotel_nearby',$hotel_nearby);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelNearbyEditRequest $request)
    {
        $request->validate();
        $id                     = Input::get('id');
        $name                   = Input::get('name');
        $hotel_category         = Input::get('hotel_category');
        $description            = Input::get('description');

        $paramObj               = $this->repo->getObjByID($id);
        $paramObj->name                  = $name;
        $paramObj->h_nearby_category_id  = $hotel_category;
        $paramObj->description           = $description;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelNearby\HotelNearbyController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Nearby is updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelNearby\HotelNearbyController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Nearby is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelNearby\HotelNearbyController@index'); //to redirect listing page
    }
}
