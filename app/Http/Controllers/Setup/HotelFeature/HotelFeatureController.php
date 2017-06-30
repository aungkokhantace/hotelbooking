<?php

namespace App\Http\Controllers\Setup\HotelFeature;

use App\Backend\Infrastructure\Forms\HotelFeatureEditRequest;
use App\Backend\Infrastructure\Forms\HotelFeatureEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Feature\FeatureRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelFeature\HotelFeature;
use App\Setup\HotelFeature\HotelFeatureRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;

class HotelFeatureController extends Controller
{
    private $repo;

    public function __construct(HotelFeatureRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $hotel_features = $this->repo->getObjs();
            return view('backend.hotel_feature.index')->with('hotel_features',$hotel_features);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo  = new HotelRepository();
            $hotels     = $hotelRepo->getObjs();
            $featureRepo= new FeatureRepository();
            $features   = $featureRepo->getObjs();
            return view('backend.hotel_feature.hotel_feature')->with('hotels',$hotels)
                                                                  ->with('features',$features);
        }
        return redirect('/');
    }

    public function store(HotelCategoryEntryRequest $request)
    {
        $request->validate();
        $hotel_id           = Input::get('hotel_id');
        $feature_id         = Input::get('feature_id');
        $qty                = Input::get('qty');
        $capacity           = Input::get('capacity');
        $area               = Input::get('area');
        $open_hour          = Input::get('open_hour');
        $close_hour         = Input::get('close_hour');
        $remark             = Input::get('remark');

        $paramObj               = new HotelFeature();
        $paramObj->hotel_id     = $hotel_id;
        $paramObj->feature_id   = $feature_id;
        $paramObj->qty          = $qty;
        $paramObj->capacity     = $capacity;
        $paramObj->area         = $area;
        $paramObj->open_hour    = $open_hour;
        $paramObj->close_hour   = $close_hour;
        $paramObj->remark       = $remark;

        $result                 = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelFeature\HotelFeatureController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Feature created ...'));
        }
        else{
            return redirect()->action('Setup\HotelFeature\HotelFeatureController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Feature did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_feature      = $this->repo->getObjByID($id);
            $hotelRepo          = new HotelRepository();
            $hotels             = $hotelRepo->getObjs();
            $featureRepo        = new FeatureRepository();
            $features           = $featureRepo->getObjs();
            return view('backend.hotel_feature.hotel_feature')->with('hotel_feature', $hotel_feature)
                                                              ->with('hotels',$hotels)
                                                              ->with('features',$features);
        }
        return redirect('/backend/login');
    }

    public function update(HotelFeatureEditRequest $request){

        $request->validate();
        $id                                 = Input::get('id');
        $hotel_id                           = Input::get('hotel_id');
        $feature_id                         = Input::get('feature_id');
        $qty                                = Input::get('qty');
        $capacity                           = Input::get('capacity');
        $area                               = Input::get('area');
        $open_hour                          = Input::get('open_hour');
        $close_hour                         = Input::get('close_hour');
        $remark                             = Input::get('remark');

        $paramObj                           = $this->repo->getObjByID($id);
        $paramObj->hotel_id                 = $hotel_id;
        $paramObj->feature_id               = $feature_id;
        $paramObj->qty                      = $qty;
        $paramObj->capacity                 = $capacity;
        $paramObj->area                     = $area;
        $paramObj->open_hour                = $open_hour;
        $paramObj->close_hour               = $close_hour;
        $paramObj->remark                   = $remark;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelFeature\HotelFeatureController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Feature updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelFeature\HotelFeatureController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Feature did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelFeature\HotelFeatureController@index'); //to redirect listing page
    }
}
