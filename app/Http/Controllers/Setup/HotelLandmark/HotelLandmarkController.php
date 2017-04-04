<?php

namespace App\Http\Controllers\Setup\HotelLandmark;

use App\Backend\Infrastructure\Forms\HotelLandmarkEditRequest;
use App\Backend\Infrastructure\Forms\HotelLandmarkEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelLandmark\HotelLandmark;
use App\Setup\HotelLandmark\HotelLandmarkRepositoryInterface;
use App\Setup\Landmark\LandmarkRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class HotelLandmarkController extends Controller
{
    private $repo;

    public function __construct(HotelLandmarkRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_landmark = $this->repo->getObjs();
            return view('backend.hotel_landmark.index')->with('hotel_landmark',$hotel_landmark);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo          = new HotelRepository();
            $hotels             = $hotelRepo->getObjs();
            $landmarkRepo       = new LandmarkRepository();
            $landmarks          = $landmarkRepo->getObjs();

            return view('backend.hotel_landmark.hotel_landmark')->with('hotels',$hotels)
                                                                ->with('landmarks',$landmarks);
        }
        return redirect('/');
    }

    public function store(HotelLandmarkEntryRequest $request)
    {
        $request->validate();
        $hotel_id                   = Input::get('hotel_id');
        $landmark_id                = Input::get('landmark');

        $paramObj                   = new HotelLandmark();
        $paramObj->hotel_id         = $hotel_id;
        $paramObj->landmark_id      = $landmark_id;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelLandmark\HotelLandmarkController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Landmark created ...'));
        }
        else{
            return redirect()->action('Setup\HotelLandmark\HotelLandmarkController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Landmark did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_landmark      = $this->repo->getObjByID($id);
            $hotelRepo          = new HotelRepository();
            $hotels             = $hotelRepo->getObjs();
            $landmarkRepo       = new LandmarkRepository();
            $landmarks          = $landmarkRepo->getObjs();
            return view('backend.hotel_landmark.hotel_landmark')->with('hotel_landmark', $hotel_landmark)
                                                                ->with('hotels',$hotels)
                                                                ->with('landmarks',$landmarks);
        }
        return redirect('/backend/login');
    }

    public function update(HotelLandmarkEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $hotel_id                   = Input::get('hotel_id');
        $landmark_id                = Input::get('landmark');

        $paramObj                   = $this->repo->getObjByID($id);
        $paramObj->hotel_id         = $hotel_id;
        $paramObj->landmark_id      = $landmark_id;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelLandmark\HotelLandmarkController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Landmark updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelLandmark\HotelLandmarkController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Landmark did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelLandmark\HotelLandmarkController@index'); //to redirect listing page
    }
}
