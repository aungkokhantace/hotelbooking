<?php

namespace App\Http\Controllers\Setup\HotelPolicy;

use App\Backend\Infrastructure\Forms\HotelPolicyEditRequest;
use App\Backend\Infrastructure\Forms\HotelPolicyEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelPolicy\HotelPolicy;
use App\Setup\HotelPolicy\HotelPolicyRepository;
use App\Setup\HotelPolicy\HotelPolicyRepositoryInterface;

use Illuminate\Http\Request;
use App\Core\User\UserRepositoryInterface;
use App\Core\User\UserRepository;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class HotelPolicyController extends Controller
{
    private $repo;

    public function __construct(HotelPolicyRepositoryInterface $repo)
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

                $all_hotel_policy = $this->repo->getObjsByHotelID($h_id);
            }
            else {
            $all_hotel_policy = $this->repo->getObjs();
            $hotels = $hotelRepo->getObjs();
            }
            $all_hotels = $hotelRepo->getObjs();

            return view('backend.hotel_policy.index')
                ->with('all_hotel_policy',$all_hotel_policy)
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
                //search hotel policy by hotel id
                if($hotel_id == "All"){
                    //get all hotel policy if hotel_id is "All"
                    $all_hotel_policy = $this->repo->getObjs();
                }
                else{
                    $all_hotel_policy = $this->repo->getObjsByHotelID($hotel_id);
                }

                $hotels = $hotelRepo->getObjs();
            }

            $all_hotels = $hotelRepo->getObjs();

            return view('backend.hotel_policy.index')
                ->with('all_hotel_policy',$all_hotel_policy)
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

            return view('backend.hotel_policy.hotel_policy')
                ->with('hotels',$hotels)
                ->with('role',$role)
                ->with('hotel_id',$hotel_id);
        }
        return redirect('/');
    }

    public function store(HotelPolicyEntryRequest $request)
    {
        $request->validate();
        $hotel_id           = Input::get('hotel_id');
        $policy             = Input::get('policy');

        $paramObj           = new HotelPolicy();
        $paramObj->hotel_id = $hotel_id;
        $paramObj->policy   = $policy;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelPolicy\HotelPolicyController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Policy created ...'));
        }
        else{
            return redirect()->action('Setup\HotelPolicy\HotelPolicyController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Policy did not create ...'));
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
                $hotelPolicyRepo       = new HotelPolicyRepository();
                $hotel_policy          = $hotelPolicyRepo->getObjByID($id);
                // $hotel_policy                 = $hotelPolicyRepo->getObjsByHotelID($id);

            } else {
                $hotels                 = $hotelRepo->getObjs();

                $hotelPolicyRepo       = new HotelPolicyRepository();
                $hotel_policy          = $hotelPolicyRepo->getObjByID($id);
            }

            return view('backend.hotel_policy.hotel_policy')
                        ->with('hotels',$hotels)
                        ->with('role',$role)
                        ->with('hotel_id',$id)
                        ->with('hotel',$hotel)
                        ->with('hotel_policy',$hotel_policy);
        }
        return redirect('/backend_mps/login');
    }

    public function update(HotelPolicyEditRequest $request){
        $request->validate();

        $id                 = Input::get('id');
        // $hotel_id           = Input::get('hotel_id');
        $policy             = Input::get('policy');

        $paramObj           = HotelPolicy::find($id);

        // $paramObj->hotel_id = $hotel_id;
        $paramObj->policy   = $policy;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelPolicy\HotelPolicyController@index')
                ->withMessage(FormatGenerator::message('Success', 'Hotel Policy updated ...'));
        }
        else{
            return redirect()->action('Setup\HotelPolicy\HotelPolicyController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Hotel Policy did not update ...'));
        }
    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);

        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\HotelPolicy\HotelPolicyController@index'); //to redirect listing page
    }

    public function getHotelRoomCategory($h_room_type_id){
        $result = $this->repo->getHotelRoomCategoryWithRoomTypeId($h_room_type_id);

        return \Response::json($result);
    }
}
