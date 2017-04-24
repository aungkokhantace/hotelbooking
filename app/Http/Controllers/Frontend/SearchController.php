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

use App\Setup\Hotel\Hotel;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

//use Redirect;

class SearchController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $hotelRepo  = new HotelRepository();
        $hotels     = $hotelRepo->getObjs();
        return view('frontend.searchresult')->with('hotels', $hotels);
    }

    public function search(Request $request)
    {
        $destination    = (Input::has('destination')) ? Input::get('destination') : "";
        $check_in       = (Input::has('check_in')) ? Input::get('check_in') : "";
        $check_out      = (Input::has('check_out')) ? Input::get('check_out') : "";
        $room           = (Input::has('destination')) ? Input::get('room') : "";
        $adults         = (Input::has('adults')) ? Input::get('adults') : "";
        $children       = (Input::has('children')) ? Input::get('children') : "";

        $hotelRepo  = new HotelRepository();
        $hotels     = $hotelRepo->getHotelsByDestination($destination); //search hotel by destination keyword

        $hRoomCategoryRepo = new HotelRoomCategoryRepository();
        foreach($hotels  as $hotel){
            $minRoomCategoryPrice = $hRoomCategoryRepo->getMinPriceByHotelId($hotel->id);
            $hotel->min_price = $minRoomCategoryPrice; //get mininum price to show in search result

            if(isset($minRoomCategoryPrice) && $minRoomCategoryPrice != null){
                $minRoomCategoryPrice = $hRoomCategoryRepo->getRoomTypeByHotelIdAndPrice($hotel->id,$minRoomCategoryPrice);
                $hotel->room_type = $minRoomCategoryPrice; //get room type with minimum price to show in search result
            }
            else{
                $hotel->room_type = null;
            }
        }

//        return redirect()->action('Frontend\SearchController@index');
        return view('frontend.searchresult')->with('hotels', $hotels);
    }
}
