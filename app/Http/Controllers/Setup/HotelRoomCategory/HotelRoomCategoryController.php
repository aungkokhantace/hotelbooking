<?php

namespace App\Http\Controllers\Setup\HotelRoomCategory;

use App\Backend\Infrastructure\Forms\HotelRoomCategoryEditRequest;
use App\Backend\Infrastructure\Forms\HotelRoomCategoryEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Setup\Amenities\AmenitiesRepository;
use App\Setup\Facilities\FacilitiesRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategory;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepositoryInterface;
use App\Setup\HotelRoomType\HotelRoomTypeRepository;
use App\Setup\RoomCategoryAmenity\RoomCategoryAmenityRepository;
use App\Setup\RoomCategoryFacility\RoomCategoryFacility;
use App\Setup\RoomCategoryFacility\RoomCategoryFacilityRepository;
use App\Setup\RoomCategoryImage\RoomCategoryImage;
use App\Setup\RoomCategoryImage\RoomCategoryImageRepository;
use App\Setup\RoomCutOffDateHistory\RoomCutOffDateHistory;
use App\Setup\RoomCutOffDateHistory\RoomCutOffDateHistoryRepository;
use App\Setup\RoomCategoryAmenity\RoomCategoryAmenity;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class HotelRoomCategoryController extends Controller
{
    private $repo;

    public function __construct(HotelRoomCategoryRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }


    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            //Get Loggin User Info
            $hotel_id = null;
            $user               = $this->repo->getUserObjs();
            $id                 = $user->id;
            $role               = $user->role_id;
            $email              = $user->email;
            $hotelRepo          = new HotelRepository();
            if ($role == 3) {
                //Get Hotel ID
                $hotels             = $hotelRepo->getHotelByUserEmail($email);
                foreach($hotels as $hotel){
                    $h_id = $hotel->id;
                }
                $hotel_room_category = $this->repo->getRoomCategoriesByHotelId($h_id);
            } else {
                $hotel_room_category = $this->repo->getRoomCategories($hotel_id);
                $hotels = $hotelRepo->getObjs();
            }

            $all_hotels = $hotelRepo->getObjs();

            return view('backend.hotel_room_category.index')
                ->with('hotel_room_category',$hotel_room_category)
                ->with('role',$role)
                ->with('all_hotels',$all_hotels)
                 ->with('hotels',$hotels)
                ->with('hotel_id',$hotel_id);
        }
        return redirect('/');
    }

    public function search($hotel_id = null){
        if (Auth::guard('User')->check()) {
            //Get Loggin User Info
            $user               = $this->repo->getUserObjs();
            $id                 = $user->id;
            $role               = $user->role_id;
            $email              = $user->email;
            $hotelRepo          = new HotelRepository();
            if ($role == 3) {
                //Get Hotel ID
                $hotels             = $hotelRepo->getHotelByUserEmail($email);
                foreach($hotels as $hotel){
                    $h_id = $hotel->id;
                }
                $hotel_room_category = $this->repo->getRoomCategoriesByHotelId($h_id);
            } else {

                $hotel_room_category = $this->repo->getRoomCategories($hotel_id);
                $hotels = $hotelRepo->getObjs();

            }

            $all_hotels = $hotelRepo->getObjs();

            return view('backend.hotel_room_category.index')
                ->with('hotel_room_category',$hotel_room_category)
                ->with('role',$role)
                ->with('all_hotels',$all_hotels)
                ->with('hotels',$hotels)
                ->with('hotel_id',$hotel_id);
        }
        return redirect('/');
    }

    public function create($hotel_id = null)
    {
        if(Auth::guard('User')->check()){
            $user               = $this->repo->getUserObjs();
            $id                 = $user->id;
            $role               = $user->role_id;
            $email              = $user->email;

            $hotelRepo          = new HotelRepository();
            if ($role == 3) {
                $hotels         = $hotelRepo->getHotelByUserEmail($email);
            } else {
                $hotels         = $hotelRepo->getObjs();
            }
            $amenityRepo = new AmenitiesRepository();
            $amenities = $amenityRepo->getObjs();

            $facilityRepo = new FacilitiesRepository();
            $facilities = $facilityRepo->getObjsForRoom();

            $bed_types = DB::select('SELECT * FROM bed_types WHERE deleted_at IS NULL');
            
            return view('backend.hotel_room_category.hotel_room_category')
                ->with('hotels',$hotels)
                ->with('role',$role)
                ->with('hotel_id',$hotel_id)
                ->with('facilities',$facilities)
                ->with('amenities',$amenities)
                ->with('bed_types',$bed_types);
        }
        return redirect('/');
    }

    public function store(HotelRoomCategoryEntryRequest $request)
    {
        $request->validate();

        $hotel_id           = Input::get('hotel_id');
        $h_room_type_id     = Input::get('h_room_type_id');
        $name               = Input::get('name');
        $square_metre       = Input::get('square_metre');
        $capacity           = Input::get('capacity');
        $booking_cutoff_day = Input::get('booking_cutoff_day');
        $extra_bed_allowed  = Input::get('extra_bed_allowed') == "true"? 1 : 0;
        $extra_bed_price    = Input::get('extra_bed_price');
        $bed_types          = Input::get('bed_types');
        $description        = Input::get('description');
        $price              = Input::get('price');
        $remark             = Input::get('remark');
        $breakfast_included = Input::get('breakfast_included') == "true"? 1 : 0;

        //get Room Amenity Data
        $amenities = Input::get('amenity_id');
        $amenityAry = array();
        $amenity_count = count($amenities);
        for($am=0;$am<$amenity_count;$am++){
            if($amenities != ""){
                $amenityAry[$am]['amenities'] = $amenities[$am];
            }else{
                $amenityAry[$am]['amenities'] = "";
            }

        }

        //End get Room Amenity Data

        //get Room Facilities Data
        $facilities = Input::get('facility_id');
        $facilityAry = array();
        $facility_count = count($facilities);
        for($fac=0;$fac<$facility_count;$fac++) {
            if ($facilities != "") {
                $facilityAry[$fac]['facilities'] = $facilities[$fac];
            } else {
                $facilityAry[$fac]['facilities'] = "";
            }
        }
        //End get Room Facilities Data

        try{
            DB::beginTransaction();

            $paramObj                       = new HotelRoomCategory();
            $paramObj->hotel_id             = $hotel_id;
            $paramObj->h_room_type_id       = $h_room_type_id;
            $paramObj->name                 = $name;
            $paramObj->square_metre         = $square_metre;
            $paramObj->capacity             = $capacity;
            $paramObj->booking_cutoff_day   = $booking_cutoff_day;
            $paramObj->extra_bed_allowed    = $extra_bed_allowed;
            $paramObj->extra_bed_price      = $extra_bed_price;
            // $paramObj->bed_type             = $bed_type;
            $paramObj->description          = $description;
            $paramObj->price                = $price;
            $paramObj->remark               = $remark;
            $paramObj->breakfast_included   = $breakfast_included;

            $result                         = $this->repo->create($paramObj,$bed_types);
            $lastRoomCategoryId             = $result['lastId'];    //get last h_room_category id

            if($result['aceplusStatusCode'] !=  ReturnMessage::OK){
                DB::rollback();

                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not created ...'));
            }

            //RoomCategoryImage
            if(Input::hasFile('file'))
            {
                $roomCategoryImageRepo          = new RoomCategoryImageRepository();
                $firstRoomCategoryImage         = $roomCategoryImageRepo->getFirstRoomCategoryImageByHotelRoomCategoryId($lastRoomCategoryId);

                $images                         = Input::file('file');
                $count                          = 1;
                foreach($images as $image){

                    if (! is_null($image)) {
                        $path = base_path().'/public/images/upload/';
                        if ( ! file_exists($path))
                        {
                            mkdir($path, 0777, true);
                        }

                        $photo_name_original            = Utility::getImage($image);
                        $photo_ext                      = Utility::getImageExt($image);
                        $photo_name                     = uniqid() . "." . $photo_ext;
                        $image_path                     = "/images/upload/".$photo_name;
                        $imgWidth                       = 500;
                        $imgHeight                      = 300;
                        $photo                          = Utility::resizeImageWithDefaultWidthHeight($image,$photo_name,$path,$imgWidth,$imgHeight);

                        $imageObj                       = new RoomCategoryImage();
                        $imageObj->h_room_category_id   = $lastRoomCategoryId;
                        // $imageObj->img_path             = $image_path;
                        $imageObj->img_path             = $photo_name;
                        $imageObj->description          = $description;
                        if(isset($firstRoomCategoryImage)){
                            $imageObj->default_image        = 0;
                        }else{
                            $imageObj->default_image        = (isset($count) && $count == 1)?1:0;
                        }
                        $roomCategoryImageRepo          = new RoomCategoryImageRepository();
                        $roomCategoryImageResult        = $roomCategoryImageRepo->create($imageObj);

                        if($roomCategoryImageResult['aceplusStatusCode'] !=  ReturnMessage::OK){
                            DB::rollback();

                            return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                                ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not created ...'));
                        }
                        $count++;
                    }

                }
            }

            //RoomCutOffDateHistory
            $cutoffHistoryObj                           = new RoomCutOffDateHistory();
            $cutoffHistoryObj->hotel_id                 = $hotel_id;
            $cutoffHistoryObj->h_room_category_id       = $lastRoomCategoryId;
            $cutoffHistoryObj->remark                   = $remark;
            $cutoffHistoryObj->cutoff_date_count        = $booking_cutoff_day;
            $cutoffHistoryRepo                          = new RoomCutOffDateHistoryRepository();
            $cutoffHistoryResult                        = $cutoffHistoryRepo->create($cutoffHistoryObj);

            if($cutoffHistoryResult['aceplusStatusCode'] != ReturnMessage::OK) {

                DB::rollback();
                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not created ...'));
            }
            $r_cat_amenityResult = array();
            if($amenities != ""){
                foreach($amenityAry as $ameAry){
                    $r_cat_amenityObj = new RoomCategoryAmenity();
                    $r_cat_amenityObj->room_category_id = $lastRoomCategoryId;
                    $r_cat_amenityObj->amenity_id = $ameAry['amenities'];
                    $r_cat_amenityRepo = new RoomCategoryAmenityRepository();
                    $r_cat_amenityResult = $r_cat_amenityRepo->create($r_cat_amenityObj);
                }
            }else{
                $r_cat_amenityResult['aceplusStatusCode'] = ReturnMessage::OK;
            }

            if($r_cat_amenityResult['aceplusStatusCode'] != ReturnMessage::OK) {
                DB::rollback();
                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not created ...'));
            }

            $r_cat_facilityResult = array();
            if($facilities != ""){
                foreach($facilityAry as $facAry){
                    $r_cat_facilityObj = new RoomCategoryFacility();
                    $r_cat_facilityObj->h_room_category_id = $lastRoomCategoryId;
                    $r_cat_facilityObj->facility_id = $facAry['facilities'];
                    $r_cat_facilityRepo = new RoomCategoryFacilityRepository();
                    $r_cat_facilityResult = $r_cat_facilityRepo->create($r_cat_facilityObj);
                }
            }else{
                $r_cat_facilityResult['aceplusStatusCode'] = ReturnMessage::OK;
            }

            if($r_cat_facilityResult['aceplusStatusCode'] != ReturnMessage::OK) {
                DB::rollback();
                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not created ...'));
            }
            DB::commit();
            return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Room Category created ...'));

        }
        catch(\Exception $e){
            DB::rollback();

            return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            //Get Loggin User Info
            $user                   = $this->repo->getUserObjs();
            $email                  = $user->email;
            $role                   = $user->role_id;
            $uid                    = $user->id;
            $hotel_room_category    = $this->repo->getObjByID($id);
            $hotel_room_category_id = $hotel_room_category->id;
            $hotel_id               = $hotel_room_category->hotel_id;
            $hotelRepo              = new HotelRepository();

            if ($role == 3){
                $hotels             = $hotelRepo->getHotelByUserEmail($email);
                foreach($hotels as $hotel){
                    $h_id = $hotel->id;
                }
                $checkPermission    = $this->repo->checkHasPermission($id,$h_id);
                if ($checkPermission == false) {
                    return redirect('unauthorize');
                }
                $hotelRoomTypeRepo      = new HotelRoomTypeRepository();
                $hotel_room_type        = $hotelRoomTypeRepo->getHotelRoomTypeWithHotelId($hotel_id);
                $roomCategoryImageRepo  = new RoomCategoryImageRepository();
                $images                 = $roomCategoryImageRepo->getRoomCategoryImageByHotelRoomCategoryId($id);

            } else {
                $hotels                 = $hotelRepo->getObjs();
                $hotelRoomTypeRepo      = new HotelRoomTypeRepository();
                $hotel_room_type        = $hotelRoomTypeRepo->getHotelRoomTypeWithHotelId($hotel_id);
                $roomCategoryImageRepo  = new RoomCategoryImageRepository();
                $images                 = $roomCategoryImageRepo->getRoomCategoryImageByHotelRoomCategoryId($id);
            }
            $amenityRepo = new AmenitiesRepository();
            $amenities = $amenityRepo->getObjs();

            $facilityRepo = new FacilitiesRepository();
            $facilities = $facilityRepo->getObjsForRoom();

            foreach ($amenities as $amenity) {
                $r_amenity = DB::select("SELECT amenity_id FROM r_category_amenities WHERE room_category_id = '$hotel_room_category_id'");
                $amenity->amenity_id = $r_amenity;
            }
            foreach ($facilities as $facility) {
                $r_facility = DB::select("SELECT facility_id FROM r_category_facilities WHERE h_room_category_id = '$hotel_room_category_id'");
                $facility->facility_id = $r_facility;
            }

            $bed_types = DB::select('SELECT * FROM bed_types WHERE deleted_at IS NULL');

            return view('backend.hotel_room_category.hotel_room_category')->with('hotel_room_category', $hotel_room_category)
                                                                          ->with('hotels',$hotels)
                                                                          ->with('hotel_room_type',$hotel_room_type)
                                                                          ->with('role',$role)
                                                                          ->with('images',$images)
                                                                          ->with('amenities',$amenities)
                                                                          ->with('facilities',$facilities)
                                                                          ->with('r_amenity',$r_amenity)
                                                                          ->with('r_facility',$r_facility)
                                                                          ->with('bed_types',$bed_types);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelRoomCategoryEditRequest $request){
        $request->validate();
        $id                 = Input::get('id');
        $hotel_id           = Input::get('hotel_id');
        $h_room_type_id     = Input::get('h_room_type_id');
        $name               = Input::get('name');
        $square_metre       = Input::get('square_metre');
        $capacity           = Input::get('capacity');
        $booking_cutoff_day = Input::get('booking_cutoff_day');
        $extra_bed_allowed  = Input::get('extra_bed_allowed') == "true"? 1: 0;
        $extra_bed_price    = Input::get('extra_bed_price');
        $bed_types          = Input::get('bed_types');
        $description        = Input::get('description');
        $price              = Input::get('price');
        $remark             = Input::get('remark');

        //get Room Amenity Data
        $r_cat_amenities = $this->repo->getRoomCategoryAmenityByID($id);
        foreach ($r_cat_amenities as $r_cat_amenity) {
            $room_cat_id = $r_cat_amenity->room_category_id;
            RoomCategoryAmenity::where('room_category_id', $room_cat_id)->delete();
        }
        $amenities = Input::get('amenity_id');
        $amenityAry = array();
        $amenity_count = count($amenities);
        for ($am = 0; $am < $amenity_count; $am++) {
            if ($amenities != "") {
                $amenityAry[$am]['amenities'] = $amenities[$am];
            } else {
                $amenityAry[$am]['amenities'] = "";
            }

        }
        //End get Room Amenity Data

        //get Room Facilities Data
        $r_cat_facilities = $this->repo->getRoomCategoryFacilityByID($id);
        foreach ($r_cat_facilities as $r_cat_facility) {
            $room_cat_id = $r_cat_facility->h_room_category_id;
            RoomCategoryFacility::where('h_room_category_id', $room_cat_id)->delete();
        }

        $facilities = Input::get('facility_id');
        $facilityAry = array();
        $facility_count = count($facilities);
        for($fac=0;$fac<$facility_count;$fac++) {
            if ($facilities != "") {
                $facilityAry[$fac]['facilities'] = $facilities[$fac];
            } else {
                $facilityAry[$fac]['facilities'] = "";
            }
        }
        //End get Room Facilities Data

        try{
            DB::beginTransaction();
            // $paramObj                       = $this->repo->getObjByID($id);
            $paramObj = HotelRoomCategory::find($id);
            $paramObj->hotel_id             = $hotel_id;
            $paramObj->h_room_type_id       = $h_room_type_id;
            $paramObj->name                 = $name;
            $paramObj->square_metre         = $square_metre;
            $paramObj->capacity             = $capacity;
            $paramObj->booking_cutoff_day   = $booking_cutoff_day;
            $paramObj->extra_bed_allowed    = $extra_bed_allowed;
            $paramObj->extra_bed_price      = $extra_bed_price;
            // $paramObj->bed_type             = $bed_type;
            $paramObj->description          = $description;
            $paramObj->price                = $price;
            $paramObj->remark               = $remark;

            $result = $this->repo->update($paramObj,$bed_types);

            if($result['aceplusStatusCode'] !=  ReturnMessage::OK){

                DB::rollback();
                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not updated ...'));
            }

            //RoomCategoryImage
            //Delete RoomCategoryImage
            $file_id                        = Input::get('file_id');
            $roomCategoryImageRepo          = new RoomCategoryImageRepository();
            $roomCategoryImages             = $roomCategoryImageRepo->getRoomCategoryImageByHotelRoomCategoryId($id);
            $r_category_image_id            = array();

            if(isset($roomCategoryImages) && count($roomCategoryImages) > 0){
                if(is_null($file_id)){
                    foreach($roomCategoryImages as $cImage){
                        array_push($r_category_image_id,$cImage->id);
                    }
                }
                else{
                    foreach($roomCategoryImages as $cImage){
                        if(!in_array($cImage->id,$file_id)){
                            array_push($r_category_image_id,$cImage->id);
                        }
                    }
                }
            }

            $roomCategoryImageRepo->deleteRoomCategoryImageByHotelRoomCateogryId($id,$r_category_image_id);
            $roomCategoryImageResult['aceplusStatusCode']  = ReturnMessage::OK;
            if(Input::hasFile('file'))
            {
                $firstRoomCategoryImage = $roomCategoryImageRepo->getFirstRoomCategoryImageByHotelRoomCategoryId($id);

                $images                         = Input::file('file');
                $count                          = 1;
                foreach($images as $image) {
                    if($image != null){
                        $path = base_path() . '/public/images/upload/';
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        $photo_name_original            = Utility::getImage($image);
                        $photo_ext                      = Utility::getImageExt($image);
                        $photo_name                     = uniqid() . "." . $photo_ext;
                        $image_path                     = "/images/upload/" . $photo_name;
                        $imgWidth                       = 500;
                        $imgHeight                      = 300;
                        $photo                          = Utility::resizeImageWithDefaultWidthHeight($image,$photo_name,$path,$imgWidth,$imgHeight);
                        $imageObj                       = new RoomCategoryImage();
                        $imageObj->h_room_category_id   = $id;
                        // $imageObj->img_path             = $image_path;
                        $imageObj->img_path             = $photo_name;
                        $imageObj->description          = $description;
                        if(isset($firstRoomCategoryImage)){
                            $imageObj->default_image        = 0;
                        }else{
                            $imageObj->default_image        = (isset($count) && $count == 1)?1:0;
                        }

                        $roomCategoryImageResult        = $roomCategoryImageRepo->create($imageObj);

                        if($roomCategoryImageResult['aceplusStatusCode'] != ReturnMessage::OK){

                            DB::rollback();
                            return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                                ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not updated ...'));
                        }
                        $count++;
                    }

                }
            }

            $cutoffHistoryObj                           = new RoomCutOffDateHistory();
            $cutoffHistoryObj->hotel_id                 = $hotel_id;
            $cutoffHistoryObj->h_room_category_id       = $id;
            $cutoffHistoryObj->remark                   = $remark;
            $cutoffHistoryObj->cutoff_date_count        = $booking_cutoff_day;

            $cutoffHistoryRepo                          = new RoomCutOffDateHistoryRepository();
            $cutoffHistoryResult                        = $cutoffHistoryRepo->create($cutoffHistoryObj);

            if($cutoffHistoryResult['aceplusStatusCode'] != ReturnMessage::OK) {

                DB::rollback();
                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not updated ...'));
            }
            $r_cat_amenityResult = array();
            if($amenities != ""){
                foreach($amenityAry as $ameAry){
                    $r_cat_amenityObj = new RoomCategoryAmenity();
                    $r_cat_amenityObj->room_category_id = $paramObj->id;
                    $r_cat_amenityObj->amenity_id = $ameAry['amenities'];
                    $r_cat_amenityRepo = new RoomCategoryAmenityRepository();
                    $r_cat_amenityResult = $r_cat_amenityRepo->create($r_cat_amenityObj);
                }
            }else{
                $r_cat_amenityResult['aceplusStatusCode'] = ReturnMessage::OK;
            }

            if($r_cat_amenityResult['aceplusStatusCode'] != ReturnMessage::OK) {
                DB::rollback();
                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not updated ...'));
            }
            $r_cat_facilityResult = array();
            if($facilities != ""){
                foreach($facilityAry as $facAry){
                    $r_cat_facilityObj = new RoomCategoryFacility();
                    $r_cat_facilityObj->h_room_category_id = $paramObj->id;
                    $r_cat_facilityObj->facility_id = $facAry['facilities'];
                    $r_cat_facilityRepo = new RoomCategoryFacilityRepository();
                    $r_cat_facilityResult = $r_cat_facilityRepo->create($r_cat_facilityObj);
                }
            }else{
                $r_cat_facilityResult['aceplusStatusCode'] = ReturnMessage::OK;
            }

            if($r_cat_facilityResult['aceplusStatusCode'] != ReturnMessage::OK) {
                DB::rollback();
                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not updated ...'));
            }

            DB::commit();
            return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Room Category updated ...'));

        }
        catch(\Exception $e){
            DB::rollback();

            return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index'); //to redirect listing page
    }

    // public function getHotelRoomCategory($h_room_type_id){
    //     $result = $this->repo->getHotelRoomCategoryWithRoomTypeId($h_room_type_id);
    //
    //     return \Response::json($result);
    // }

    public function getHotelRoomCategory($hotel_id){
        $result = $this->repo->getHotelRoomCategoryWithHotelId($hotel_id);
        return \Response::json($result);
    }
}
