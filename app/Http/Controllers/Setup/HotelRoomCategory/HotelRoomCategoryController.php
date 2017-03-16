<?php

namespace App\Http\Controllers\Setup\HotelRoomCategory;

use App\Backend\Infrastructure\Forms\HotelRoomCategoryEditRequest;
use App\Backend\Infrastructure\Forms\HotelRoomCategoryEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategory;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepositoryInterface;
use App\Setup\HotelRoomType\HotelRoomTypeRepository;
use App\Setup\RoomCategoryImage\RoomCategoryImage;
use App\Setup\RoomCategoryImage\RoomCategoryImageRepository;
use App\Setup\RoomCutOffDateHistory\RoomCutOffDateHistory;
use App\Setup\RoomCutOffDateHistory\RoomCutOffDateHistoryRepository;
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
            $hotel_room_category = $this->repo->getObjs();
            return view('backend.hotel_room_category.index')->with('hotel_room_category',$hotel_room_category);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo  = new HotelRepository();
            $hotels     = $hotelRepo->getObjs();
            return view('backend.hotel_room_category.hotel_room_category')->with('hotels',$hotels);
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
        $extra_bed_allowed  = Input::get('extra_bed_allowed') == "true"? 1: 0;
        $extra_bed_price    = Input::get('extra_bed_price');
        $bed_type           = Input::get('bed_type');
        $description        = Input::get('description');
        $price              = Input::get('price');
        $remark             = Input::get('remark');

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
            $paramObj->bed_type             = $bed_type;
            $paramObj->description          = $description;
            $paramObj->price                = $price;
            $paramObj->remark               = $remark;

            $result                         = $this->repo->create($paramObj);
            $lastRoomCategoryId             = $result['lastId'];    //get last h_room_category id

            //RoomCategoryImage
            $roomCategoryImageResult        = "";
            if(Input::hasFile('file'))
            {
                $images        = Input::file('file');

                foreach($images as $image){
                    $path = base_path().'/public/images/upload/';
                    if ( ! file_exists($path))
                    {
                        mkdir($path, 0777, true);
                    }
                    $photo_name_original            = Utility::getImage($image);
                    $photo_ext                      = Utility::getImageExt($image);
                    $photo_name                     = uniqid() . "." . $photo_ext;
                    $image_path                     = "/images/upload/".$photo_name;
                    $photo                          = Utility::resizeImage($image,$photo_name,$path);

                    $imageObj                       = new RoomCategoryImage();
                    $imageObj->h_room_category_id   = $lastRoomCategoryId;
                    $imageObj->img_path             = $image_path;
                    $imageObj->description          = $description;
                    $roomCategoryImageRepo          = new RoomCategoryImageRepository();
                    $roomCategoryImageResult        = $roomCategoryImageRepo->create($imageObj);

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


            if($result['aceplusStatusCode'] ==  ReturnMessage::OK &&
               $roomCategoryImageResult['aceplusStatusCode'] == ReturnMessage::OK &&
               $cutoffHistoryResult['aceplusStatusCode'] == ReturnMessage::OK)
            {
                DB::commit();

                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Hotel Room Category created ...'));
            }
            else{
                DB::rollback();

                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category did not create ...'));
            }
        }
        catch(\Exception $e){
            DB::rollback();

            return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $hotel_room_category    = $this->repo->getObjByID($id);
            $hotel_id               = $hotel_room_category->hotel_id;
            $hotelRepo              = new HotelRepository();
            $hotels                 = $hotelRepo->getObjs();
            $hotelRoomTypeRepo      = new HotelRoomTypeRepository();
            $hotel_room_type        = $hotelRoomTypeRepo->getHotelRoomTypeWithHotelId($hotel_id);
            $roomCategoryImageRepo  = new RoomCategoryImageRepository();
            $images                 = $roomCategoryImageRepo->getRoomCategoryImageByHotelRoomCategoryId($id);
            return view('backend.hotel_room_category.hotel_room_category')->with('hotel_room_category', $hotel_room_category)
                                                                          ->with('hotels',$hotels)
                                                                          ->with('hotel_room_type',$hotel_room_type)
                                                                          ->with('images',$images);
        }
        return redirect('/backend/login');
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
        $bed_type           = Input::get('bed_type');
        $description        = Input::get('description');
        $price              = Input::get('price');
        $remark             = Input::get('remark');

        try{
            DB::beginTransaction();
            $paramObj                       = $this->repo->getObjByID($id);
            $paramObj->hotel_id             = $hotel_id;
            $paramObj->h_room_type_id       = $h_room_type_id;
            $paramObj->name                 = $name;
            $paramObj->square_metre         = $square_metre;
            $paramObj->capacity             = $capacity;
            $paramObj->booking_cutoff_day   = $booking_cutoff_day;
            $paramObj->extra_bed_allowed    = $extra_bed_allowed;
            $paramObj->extra_bed_price      = $extra_bed_price;
            $paramObj->bed_type             = $bed_type;
            $paramObj->description          = $description;
            $paramObj->price                = $price;
            $paramObj->remark               = $remark;

            $result = $this->repo->update($paramObj);

            //RoomCategoryImage
            //Delete RoomCategoryImage
            $file_id                        = Input::get('file_id');
            $roomCategoryImageRepo          = new RoomCategoryImageRepository();
            $roomCategoryImages             = $roomCategoryImageRepo->getRoomCategoryImageByHotelRoomCategoryId($id);
            $r_category_image_id            = array();
            if(isset($roomCategoryImages) && count($roomCategoryImages) > 0){
                foreach($roomCategoryImages as $cImage){
                    if(!in_array($cImage->id,$file_id)){
                        array_push($r_category_image_id,$cImage->id);
                    }
                }
            }

            $roomCategoryImageRepo->deleteRoomCategoryImageByHotelRoomCateogryId($id,$r_category_image_id);
            $roomCategoryImageResult['aceplusStatusCode']  = ReturnMessage::OK;
            if(Input::hasFile('file'))
            {
                $images                         = Input::file('file');
                foreach($images as $image) {
                    if($image != null){
                        $path = base_path() . '/public/images/upload/';
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        $photo_name_original = Utility::getImage($image);
                        $photo_ext = Utility::getImageExt($image);
                        $photo_name = uniqid() . "." . $photo_ext;
                        $image_path = "/images/upload/" . $photo_name;
                        $photo = Utility::resizeImage($image, $photo_name, $path);

                        $imageObj                       = new RoomCategoryImage();
                        $imageObj->h_room_category_id   = $id;
                        $imageObj->img_path             = $image_path;
                        $imageObj->description          = $description;

                        $roomCategoryImageResult        = $roomCategoryImageRepo->create($imageObj);
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

            if($result['aceplusStatusCode'] ==  ReturnMessage::OK &&
                $roomCategoryImageResult['aceplusStatusCode'] == ReturnMessage::OK &&
                $cutoffHistoryResult['aceplusStatusCode'] == ReturnMessage::OK)
            {

                DB::commit();

                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Success', 'Hotel Room Category updated ...'));
            }
            else{
                DB::rollback();

                return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                    ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category did not update ...'));
            }

        }
        catch(\Exception $e){
            DB::rollback();

            return redirect()->action('Setup\HotelRoomCategory\HotelRoomCategoryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Room Category did not update ...'));
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

    public function getHotelRoomCategory($h_room_type_id){
        $result = $this->repo->getHotelRoomCategoryWithRoomTypeId($h_room_type_id);

        return \Response::json($result);
    }
}
