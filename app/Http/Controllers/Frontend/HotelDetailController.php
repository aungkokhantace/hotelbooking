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
use App\Setup\FacilityGroup\FacilityGroupRepository;
use App\Setup\Hnearby\Hnearby;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelFacility\HotelFacilityRepository;
use App\Setup\HotelLandmark\HotelLandmarkRepository;
use App\Setup\HotelNearby\HotelNearby;
use App\Setup\HotelNearby\HotelNearbyRepository;
use App\Setup\HotelNearbyAirport\HotelNearbyAirportRepository;
use App\Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreRepository;
use App\Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreRepository;
use App\Setup\HotelNearbyHospital\HotelNearbyHospital;
use App\Setup\HotelNearbyHospital\HotelNearbyHospitalRepository;
use App\Setup\HotelNearbyStation\HotelNearbyStationRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategory;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\Landmark\LandmarkRepository;
use App\Setup\Room\RoomRepository;
use App\Setup\RoomCategoryAmenity\RoomCategoryAmenityRepository;
use App\Setup\RoomCategoryFacility\RoomCategoryFacilityRepository;
use App\Setup\RoomCategoryImage\RoomCategoryImageRepository;
use App\Setup\RoomDiscount\RoomDiscountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        //get hotel by id
        $hotelRepo  = new HotelRepository();
        $hotel      = $hotelRepo->getObjByID($hotel_id);

        //start hotel discount
        $discountRepo  = new RoomDiscountRepository();
        $discount_percent     = $discountRepo->getMaximumDiscountPercentByHotelID($hotel_id);

        //if there is any percent discount, assign it to $hotel->discount
        if(isset($discount_percent) && count($discount_percent)>0){
            $hotel->discount = $discount_percent->discount_percent." %";
        }
        //else, check if there is any amount discount
        else{
            $discount_amount = $discountRepo->getMaximumDiscountAmountByHotelID($hotel_id);
            //if there is any amount discount, assign it to $hotel->discount
            if(isset($discount_amount) && count($discount_amount)>0){
                $hotel->discount = $discount_amount->discount_amount." MMK";
            }
            //else, set $hotel->discount to null
            else{
                $hotel->discount = null;
            }
        }
        //end hotel discount

        //start hotel images
        $roomCategoryRepo = new HotelRoomCategoryRepository();
        $roomCategories = $roomCategoryRepo->getRoomCategoriesByHotelId($hotel_id);

        $roomCategoryIdArray = array();
        foreach($roomCategories as $roomCategoryId){
            array_push($roomCategoryIdArray,$roomCategoryId->id);
        }

        $roomCategoryImageRepo = new RoomCategoryImageRepository();
        $roomCategoryImages    = $roomCategoryImageRepo->getRoomCategoryImageByHotelRoomCategoryIdArray($roomCategoryIdArray);
        //end hotel images

        //start hotel nearby
        $nearby_array = array();
        $hotel_nearby = DB::table('h_nearby')->where('hotel_id', $hotel_id)->where('status', 1)->get();
        $nearbyRepo = new HotelNearbyRepository();
        $nearby_index = 0;
        foreach($hotel_nearby as $hnearby){
            $nearby_obj = $nearbyRepo->getObjByID($hnearby->nearby_id);
            $nearby_name = $nearby_obj->name;
            $nearby_array[$nearby_index]["name"] = $nearby_name;
            $nearby_array[$nearby_index]["category"] = $nearby_obj->nearby_category->name;
            $nearby_array[$nearby_index]["distance"] = $hnearby->km." km";
            $nearby_index++;
        }
        //end hotel nearby

        //start facilities
        $facilityGroupRepo = new FacilityGroupRepository();
        $facilityGroups    = $facilityGroupRepo->getObjs();

        $facilityGroupArray = array();

        $hotelFacilityRepo = new HotelFacilityRepository();
        foreach($facilityGroups as $facilityGroup){
            $facilities = $hotelFacilityRepo->getHotelFacilitiesByHotelIDandGroupID($hotel_id,$facilityGroup->id);
            $facilityGroup->facilities = $facilities;
            array_push($facilityGroupArray,$facilityGroup);
        }
        //end facilities

        //start landmarks
        $hotelLandmarkRepo = new HotelLandmarkRepository();
        $landmarks = $hotelLandmarkRepo->getObjsByHotelID($hotel_id);
        //end landmarks

        //start popular landmarks
        $landmarkRepo = new LandmarkRepository();
        $popularLandmarks = $landmarkRepo->getPopularLandmarks();
        //end popular landmarks

        //start amenities
        $roomCategoryAmenityRepo  = new RoomCategoryAmenityRepository();
        $amenities    = $roomCategoryAmenityRepo->getAmenitiesByHotelRoomCategoryIdArray($roomCategoryIdArray);
        //end amenities


        foreach($roomCategories as $roomCategory){
            $room_amenities = $roomCategoryAmenityRepo->getAmenitiesByRoomCategoryId($roomCategory->id);
            $roomCategory->room_amenities = $room_amenities;
        }

        //start room count for each room category
        //get check-in date from session
        $check_in = session('check_in');

        //get check-out date from session
        $check_out = session('check_out');

        foreach($roomCategories as $r_category){
            $roomRepo = New RoomRepository();
            //get rooms that are within available_period and not within black_out period and not booked and not in cutoff date
            $rooms    = $roomRepo->getRoomCountByRoomCategoryId($r_category->id,$check_in,$check_out);

            $r_category->available_room_count = count($rooms);
        }
        //end room count for each room category

        //start images for each room category
        foreach($roomCategories as $r_category_img){
            $images    = $roomCategoryImageRepo->getRoomCategoryImageByHotelRoomCategoryId($r_category_img->id);
            $r_category_img->images = $images;
        }
        //end images for each room category

        //start room category facilities
        $roomCategoryFacilityRepo = New RoomCategoryFacilityRepository();
        foreach($roomCategories as $r_category_for_facility){
            $room_category_facilities = $roomCategoryFacilityRepo->getObjByRoomCategoryID($r_category_for_facility->id);
            $r_category_for_facility->facilities = $room_category_facilities;
        }
        //end room category facilities

        //for book_now flag
        $book_now_flag = 1;

        $available_category_id_array = array();
        foreach($roomCategories as $r_cat){
            if($r_cat->available_room_count > 0){
                array_push($available_category_id_array,$r_cat->id);
            }
        }

        return view('frontend.hoteldetail')
            ->with('hotel', $hotel)
            ->with('roomCategoryImages',$roomCategoryImages)
            ->with('nearby_array',$nearby_array)
            ->with('roomCategories',$roomCategories)
            ->with('facilityGroupArray',$facilityGroupArray)
            ->with('landmarks',$landmarks)
            ->with('popularLandmarks',$popularLandmarks)
            ->with('amenities',$amenities)
            ->with('book_now_flag',$book_now_flag)
            ->with('available_category_id_array',$available_category_id_array);
    }
}
