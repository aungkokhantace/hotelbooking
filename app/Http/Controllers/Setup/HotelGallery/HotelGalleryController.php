<?php

namespace App\Http\Controllers\Setup\HotelGallery;

use App\Backend\Infrastructure\Forms\HotelGalleryEditRequest;
use App\Backend\Infrastructure\Forms\HotelGalleryEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelGallery\HotelGallery;
use App\Setup\HotelGallery\HotelGalleryRepository;
use App\Setup\HotelGallery\HotelGalleryRepositoryInterface;

use Illuminate\Http\Request;
use App\Core\User\UserRepositoryInterface;
use App\Core\User\UserRepository;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class HotelGalleryController extends Controller
{
    private $repo;

    public function __construct(HotelGalleryRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }


    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            //Get Loggin User Info
            $hotel_id = null;
            $user_id            = Utility::getCurrentUserID();
            $userRepo           = new UserRepository();
            $user               = $userRepo->getObjByID($user_id);

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

                $all_hotel_gallery = $this->repo->getObjsByHotelID($h_id);
            }
            else {
            $all_hotel_gallery = $this->repo->getObjs();
            $hotels = $hotelRepo->getObjs();
            }
            $all_hotels = $hotelRepo->getObjs();

            return view('backend.hotel_gallery.index')
                ->with('all_hotel_gallery',$all_hotel_gallery)
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
            // $user               = $this->repo->getUserObjs();
            $user_id            = Utility::getCurrentUserID();
            $userRepo           = new UserRepository();
            $user               = $userRepo->getObjByID($user_id);
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
                //search hotel gallery by hotel id
                if($hotel_id == "All"){
                    //get all hotel gallery if hotel_id is "All"
                    $all_hotel_gallery = $this->repo->getObjs();
                }
                else{
                    $all_hotel_gallery = $this->repo->getObjsByHotelID($hotel_id);
                }

                $hotels = $hotelRepo->getObjs();
            }

            $all_hotels = $hotelRepo->getObjs();

            return view('backend.hotel_gallery.index')
                ->with('all_hotel_gallery',$all_hotel_gallery)
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
            // $user               = $this->repo->getUserObjs();
            $user_id            = Utility::getCurrentUserID();
            $userRepo           = new UserRepository();
            $user               = $userRepo->getObjByID($user_id);
            $id                 = $user->id;
            $role               = $user->role_id;
            $email              = $user->email;

            $hotelRepo          = new HotelRepository();
            if ($role == 3) {
                $hotels         = $hotelRepo->getHotelByUserEmail($email);
            } else {
                $hotels         = $hotelRepo->getObjs();
            }

            return view('backend.hotel_gallery.hotel_gallery')
                ->with('hotels',$hotels)
                ->with('role',$role)
                ->with('hotel_id',$hotel_id);
                // ->with('facilities',$facilities)
                // ->with('amenities',$amenities)
                // ->with('bed_types',$bed_types);
        }
        return redirect('/');
    }

    public function store(HotelGalleryEntryRequest $request)
    {
            // dd(Input::all());
        $request->validate();

        $hotel_id           = Input::get('hotel_id');

        try{
            DB::beginTransaction();

            //Hotel Gallery Images
            if(Input::hasFile('file'))
            {
                $images                     = Input::file('file');
                // $count                      = 1;
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

                        $paramObj                       = new HotelGallery();
                        $paramObj->hotel_id             = $hotel_id;
                        // $paramObj->image                = $image_path;
                        $paramObj->image                = $photo_name;
                        $paramObj->status               = 1; //status is 1 by default

                        $hotelGalleryRepo               = new HotelGalleryRepository();
                        $hotelGalleryResult        = $hotelGalleryRepo->create($paramObj);

                        if($hotelGalleryResult['aceplusStatusCode'] !=  ReturnMessage::OK){
                            DB::rollback();

                            return redirect()->action('Setup\HotelGallery\HotelGalleryController@index')
                                ->withMessage(FormatGenerator::message('Fail', 'Hotel Gallery Image did not create ...'));
                        }
                        // $count++;
                    }
                }
            }

            DB::commit();
            return redirect()->action('Setup\HotelGallery\HotelGalleryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Gallery Image created ...'));

        }
        catch(\Exception $e){
            DB::rollback();

            return redirect()->action('Setup\HotelGallery\HotelGalleryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Gallery Image did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            //Get Loggin User Info
            // $user                   = $this->repo->getUserObjs();
            $user_id            = Utility::getCurrentUserID();
            $userRepo           = new UserRepository();
            $user               = $userRepo->getObjByID($user_id);
            $email                  = $user->email;
            $role                   = $user->role_id;

            $hotelRepo              = new HotelRepository();
            $hotel                  = $hotelRepo->getObjByID($id);

            if ($role == 3){
                $hotels             = $hotelRepo->getHotelByUserEmail($email);
                foreach($hotels as $hotel){
                    $h_id = $hotel->id;
                }

                //check for permission
                if($id == $h_id){
                    $checkPermission = true;
                }
                else{
                    $checkPermission = false;
                }

                // $checkPermission    = $this->repo->checkHasPermission($id,$h_id);
                if ($checkPermission == false) {
                    return redirect('unauthorize');
                }
                $hotelGalleryRepo       = new HotelGalleryRepository();
                $images                 = $hotelGalleryRepo->getObjsByHotelID($id);

            } else {
                $hotels                 = $hotelRepo->getObjs();
                // $hotelRoomTypeRepo      = new HotelRoomTypeRepository();
                // $hotel_room_type        = $hotelRoomTypeRepo->getHotelRoomTypeWithHotelId($hotel_id);
                $hotelGalleryRepo       = new HotelGalleryRepository();
                $images                 = $hotelGalleryRepo->getObjsByHotelID($id);
            }

            return view('backend.hotel_gallery.hotel_gallery')
                        ->with('hotels',$hotels)
                        ->with('role',$role)
                        ->with('hotel_id',$id)
                        ->with('hotel',$hotel)
                        ->with('images',$images);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelGalleryEditRequest $request){
        $request->validate();

        $id                 = Input::get('id');

        try{
            DB::beginTransaction();

            //Delete RoomCategoryImage
            $file_id                        = Input::get('file_id');
            $hotelGalleryRepo               = new HotelGalleryRepository();
            $hotelGalleryImages             = $hotelGalleryRepo->getObjsByHotelID($id);
            $hotel_gallery_image_id_array   = array();

            if(isset($hotelGalleryImages) && count($hotelGalleryImages) > 0){
                if(is_null($file_id)){
                    foreach($hotelGalleryImages as $galleryImage){
                        array_push($hotel_gallery_image_id_array,$galleryImage->id);
                    }
                }
                else{
                    foreach($hotelGalleryImages as $galleryImage){
                        if(!in_array($galleryImage->id,$file_id)){
                            array_push($hotel_gallery_image_id_array,$galleryImage->id);
                        }
                    }
                }
            }

            $hotelGalleryRepo->deleteHotelGalleryImageByHotelId($id,$hotel_gallery_image_id_array);
            $hotelGalleryResult['aceplusStatusCode']  = ReturnMessage::OK;

            //Hotel Gallery Images
            if(Input::hasFile('file'))
            {
                $images                     = Input::file('file');
                // $count                      = 1;

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

                        $paramObj                       = new HotelGallery();
                        $paramObj->hotel_id             = $id;
                        // $paramObj->image                = $image_path;
                        $paramObj->image                = $photo_name;
                        $paramObj->status               = 1; //status is 1 by default

                        // $hotelGalleryRepo               = new HotelGalleryRepository();
                        $hotelGalleryResult        = $hotelGalleryRepo->create($paramObj);

                        if($hotelGalleryResult['aceplusStatusCode'] !=  ReturnMessage::OK){
                            DB::rollback();

                            return redirect()->action('Setup\HotelGallery\HotelGalleryController@index')
                                ->withMessage(FormatGenerator::message('Fail', 'Hotel Gallery Image did not update ...'));
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->action('Setup\HotelGallery\HotelGalleryController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Gallery Image updated ...'));

        }
        catch(\Exception $e){
            DB::rollback();

            return redirect()->action('Setup\HotelGallery\HotelGalleryController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Gallery Image did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelGallery\HotelGalleryController@index'); //to redirect listing page
    }

    public function getHotelRoomCategory($h_room_type_id){
        $result = $this->repo->getHotelRoomCategoryWithRoomTypeId($h_room_type_id);

        return \Response::json($result);
    }
}
