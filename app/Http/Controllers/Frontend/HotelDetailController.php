<?php
/**
 * Created by PhpStorm.
 * User: william
 * Author: Wai Yan Aung
 * Date: 1/14/2017
 * Time: 10:55 AM
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Setup\Facilities\FacilitiesRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\Landmark\LandmarkRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

//use Redirect;

class HotelDetailController extends Controller
{

    public function __construct()
    {

    }

    public function index($hotel_id)
    {
//        dd('hotel_detail index',$hotel_id);
        $hotelRepo  = new HotelRepository();
        $hotel      = $hotelRepo->getObjByID($hotel_id);
        return view('frontend.hoteldetail')->with('hotel', $hotel);
    }
}
