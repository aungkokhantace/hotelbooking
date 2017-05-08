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
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelFacility\HotelFacilityRepository;
use App\Setup\HotelLandmark\HotelLandmarkRepository;
use App\Setup\HotelNearbyAirport\HotelNearbyAirportRepository;
use App\Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreRepository;
use App\Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreRepository;
use App\Setup\HotelNearbyHospital\HotelNearbyHospital;
use App\Setup\HotelNearbyHospital\HotelNearbyHospitalRepository;
use App\Setup\HotelNearbyStation\HotelNearbyStationRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategory;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\Landmark\LandmarkRepository;
use App\Setup\RoomCategoryImage\RoomCategoryImageRepository;
use App\Setup\RoomDiscount\RoomDiscountRepository;
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
        //else, check there is any amount discount
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

        //start hotel_nearby
        $hotel_nearby = array();   //to store all nearby

        $nearbyAirportRepo = new HotelNearbyAirportRepository();
        $nearbyAirports    = $nearbyAirportRepo->getObjsByHotelID($hotel_id);
        $hotel_nearby['airport'] = $nearbyAirports;

        $nearbyStationRepo = new HotelNearbyStationRepository();
        $nearbyStations    = $nearbyStationRepo->getObjsByHotelID($hotel_id);
        $hotel_nearby['station'] = $nearbyStations;

        $nearbyHospitalRepo = new HotelNearbyHospitalRepository();
        $nearbyHospitals    = $nearbyHospitalRepo->getObjsByHotelID($hotel_id);
        $hotel_nearby['hospital'] = $nearbyHospitals;

        $nearbyConvenienceStoreRepo = new HotelNearbyConvenienceStoreRepository();
        $nearbyConvenienceStores    = $nearbyConvenienceStoreRepo->getObjsByHotelID($hotel_id);
        $hotel_nearby['convenience_store'] = $nearbyConvenienceStores;

        $nearbyDrugStoreRepo = new HotelNearbyDrugStoreRepository();
        $nearbyDrugStores    = $nearbyDrugStoreRepo->getObjsByHotelID($hotel_id);
        $hotel_nearby['drug_store'] = $nearbyDrugStores;
        //end hotel_nearby

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

        return view('frontend.hoteldetail')
            ->with('hotel', $hotel)
            ->with('roomCategoryImages',$roomCategoryImages)
            ->with('hotel_nearby',$hotel_nearby)
            ->with('roomCategories',$roomCategories)
            ->with('facilityGroupArray',$facilityGroupArray)
            ->with('landmarks',$landmarks);
    }
}
