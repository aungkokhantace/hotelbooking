<?php
/**
 * Created by PhpStorm.
 * User: william
 * Author: Wai Yan Aung
 * Date: 1/14/2017
 * Time: 10:55 AM
 */

namespace App\Http\Controllers\Frontend;

use App\Core\Config\ConfigRepository;
use App\Core\Utility;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Setup\Facilities\FacilitiesRepository;
use App\Setup\FacilityGroup\FacilityGroupRepository;
use App\Setup\Hnearby\Hnearby;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelFacility\HotelFacilityRepository;
use App\Setup\HotelFeature\HotelFeatureRepository;
use App\Setup\HotelLandmark\HotelLandmarkRepository;
use App\Setup\HotelNearby\HotelNearby;
use App\Setup\HotelNearby\HotelNearbyRepository;
use App\Setup\HotelNearbyAirport\HotelNearbyAirportRepository;
use App\Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreRepository;
use App\Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreRepository;
use App\Setup\HotelNearbyHospital\HotelNearbyHospital;
use App\Setup\HotelNearbyHospital\HotelNearbyHospitalRepository;
use App\Setup\HotelNearbyStation\HotelNearbyStationRepository;
use App\Setup\HotelRestaurant\HotelRestaurantRepository;
use App\Setup\HotelRestaurantCategory\HotelRestaurantCategoryRepository;
use App\Setup\HotelRoomCategory\HotelRoomCategory;
use App\Setup\HotelRoomCategory\HotelRoomCategoryRepository;
use App\Setup\Landmark\LandmarkRepository;
use App\Setup\Room\RoomRepository;
use App\Setup\RoomCategoryAmenity\RoomCategoryAmenityRepository;
use App\Setup\RoomCategoryFacility\RoomCategoryFacilityRepository;
use App\Setup\RoomCategoryImage\RoomCategoryImageRepository;
use App\Setup\RoomDiscount\RoomDiscountRepository;
use App\Setup\RoomAvailablePeriod\RoomAvailablePeriodRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Setup\HotelGallery\HotelGalleryRepository;
use App\Setup\BedType\BedType;
use App\Setup\BedType\BedTypeRepository;
use App\Setup\BedType\BedTypeRepositoryInterface;
use App\Setup\RoomView\RoomViewRepository;
use App\Setup\RoomView\RoomViewRepositoryInterface;
use App\Payment\PaymentConstance;
use App\Log\LogCustom;

//use Redirect;

class HotelDetailController extends Controller
{

    public function __construct()
    {

    }

    public function index($hotel_id)
    {
        try{
            //get hotel by id
            $hotelRepo              = new HotelRepository();
            $hotel                  = $hotelRepo->getObjByID($hotel_id);
            // check destination session exist, if not set hotel name to destination session
            if(!Session::has('destination')){
                Session::put('destination',$hotel->name);
            }
            //start hotel discount
            $discountRepo           = new RoomDiscountRepository();
            $discount_percent       = $discountRepo->getMaximumDiscountPercentByHotelID($hotel_id);

            //if there is any percent discount, assign it to $hotel->discount
            if(isset($discount_percent) && count($discount_percent)>0){
                $hotel->discount = $discount_percent->discount_percent." %";
            }
            //else, check if there is any amount discount
            else{
                $discount_amount = $discountRepo->getMaximumDiscountAmountByHotelID($hotel_id);
                //if there is any amount discount, assign it to $hotel->discount
                if(isset($discount_amount) && count($discount_amount)>0){
                    $hotel->discount = $discount_amount->discount_amount." USD";
                }
                //else, set $hotel->discount to null
                else{
                    $hotel->discount = null;
                }
            }
            //end hotel discount

            $room_availableRepo = new RoomAvailablePeriodRepository();
            $room_availables = $room_availableRepo->getObjByH_Id($hotel_id);
            $room_availables_count = count($room_availables);

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

                //get up to 5 amenities to show in hotel detail page, remaining amenities will be shown in 'more' link...
                $display_room_amenities = $roomCategoryAmenityRepo->getDisplayAmenitiesByRoomCategoryId($roomCategory->id);

                // $roomCategory->room_amenities = $room_amenities;
                $roomCategory->room_amenities_count = count($room_amenities);
                $roomCategory->display_room_amenities = $display_room_amenities; //only up to five amenities
                $roomCategory->room_amenities = $room_amenities;

            }

            //start room count for each room category
            //get check-in date from session
            $check_in = session('check_in');
            //get check-out date from session
            $check_out = session('check_out');
            $total_available_room = 0;

            $roomViewRepo = new RoomViewRepository;
            $roomViews = $roomViewRepo->getObjs();

            foreach($roomCategories as $r_category){
                $roomRepo                           = New RoomRepository();
                //get rooms that are within available_period and not within black_out period and not booked and not in cutoff date
                $rooms                              = $roomRepo->getRoomCountByRoomCategoryId($r_category->id,$check_in,$check_out);

                $r_category->available_room_count   = count($rooms);
                $total_available_room               += count($rooms);

                // get room views by room IDs
                //declare array to store room_views
                $room_view_obj_array = array();
                $room_view_id_array = array();
                foreach($rooms as $room){
                  array_push($room_view_id_array,$room->room_view_id);
                }

                //remove duplicated room_view_ids from array
                $room_view_id_array = array_unique($room_view_id_array);
                // $r_category->room_views = $room_view_id_array;

                // $r_category_bed_type_array = array();
                $r_category_room_view_string = "";
                foreach($room_view_id_array as $room_view_id){
                  $roomViewObj = $roomViewRepo->getObjByID($room_view_id);
                  array_push($room_view_obj_array,$roomViewObj);
                  $r_category_room_view_string .= ','.$roomViewObj->name;
                }
                //trim leftmost comma
                $r_category_room_view_string = ltrim($r_category_room_view_string,",");

                $r_category->r_category_room_view_string = $r_category_room_view_string;
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

            /* Start Hotel Features */
            $hFeatureRepo   = new HotelFeatureRepository();
            $hFeatures      = $hFeatureRepo->getObjsByHotelID($hotel_id);
            /* End Hotel Features */

            /* Start Hotel Restaurant Category */
            $hRestaurantCategoryRepo    = new HotelRestaurantCategoryRepository();
            $hRestaurantCategories      = $hRestaurantCategoryRepo->getObjs();
            /* End Hotel Restaurant Category */

            /* Start Hotel Restaurant */
            $hRestaurantRepo        = new HotelRestaurantRepository();
            $hRestaurants           = $hRestaurantRepo->getHotelRestaurantsByHotelId($hotel_id);
            $restaurantArr          = array();
            $restaurantCategoryArr  = array();
            foreach($hRestaurantCategories as $hRestaurantCategory){
                foreach($hRestaurants as $hRestaurant){
                    if($hRestaurantCategory->id == $hRestaurant->h_restaurant_category_id){
                        array_push($restaurantArr,$hRestaurant);
                    }
                }
                $hRestaurantCategory->restaurants = $restaurantArr;
                $restaurantArr      = array();
                if(!empty($hRestaurantCategory->restaurants)){
                    array_push($restaurantCategoryArr,$hRestaurantCategory);
                }
            }
            /* End Hotel Restaurant */

            //get hotel gallery images
            $hotelGalleryRepo   = new HotelGalleryRepository();
            $hotelGalleryImages = $hotelGalleryRepo->getObjsByHotelID($hotel_id);

            //change to desired time formats (eg. 02:00 PM) to display in Good to Know
            $hotel->check_in_time = date("h:i A", strtotime($hotel->check_in_time));
            $hotel->check_out_time = date("h:i A", strtotime($hotel->check_out_time));
            $hotel->breakfast_start_time = date("h:i A", strtotime($hotel->breakfast_start_time));
            $hotel->breakfast_end_time = date("h:i A", strtotime($hotel->breakfast_end_time));

            foreach($roomCategories as $roomCategory){
                //if extrabed is allowed, display extra bed price also
                if($roomCategory->extra_bed_allowed == 1){
                    $roomCategory->extra_bed_allowed = "A/V (USD ".$roomCategory->extra_bed_price.")";
                }
                else{
                    $roomCategory->extra_bed_allowed = "N/V";
                }

                if($roomCategory->breakfast_included == 1){
                    $roomCategory->breakfast_included = "A/V";
                }
                else{
                    $roomCategory->breakfast_included = "N/V";
                }
            }

            // To show government tax and service tax on available room table
            $configRepo             = new ConfigRepository();
            $config_gov             = $configRepo->getGST();
            $gst                    = $config_gov[0]->value;

            $service_tax            = Utility::getServiceTax($hotel_id);

            //start getting room category bed types
            //declare bed type repository
            $bedTypeRepo = new BedTypeRepository();

            foreach($roomCategories as $room_category_for_bed_type){
              $r_category_bed_types = $roomCategoryRepo->getBedTypesByRoomCategoryId($room_category_for_bed_type->id);

              $r_category_bed_type_array = array();
              $r_category_bed_type_string = "";
              foreach($r_category_bed_types as $bed_type){
                $bedTypeObj = $bedTypeRepo->getObjByID($bed_type->bed_type_id);
                array_push($r_category_bed_type_array,$bedTypeObj);
                $r_category_bed_type_string .= ','.$bedTypeObj->name;
              }
              //bind bed type array to room category object

              //trim leftmost comma
              $r_category_bed_type_string = ltrim($r_category_bed_type_string,",");

              $room_category_for_bed_type->bed_types = $r_category_bed_type_array;
              $room_category_for_bed_type->bed_types_string = $r_category_bed_type_string;
            }
            //end getting room category bed types

            //to display information about room count, adult count, children count and age
            $room_count     = Session::get('room');
            $adult_count    = Session::get('adults');
            $children_count = Session::get('children');
            $children_ages  = Session::get('children_ages');

            $searched_string = "";

            if($room_count > 0 || $adult_count > 0 || $children_count > 0){
                //start converting children ages to string
                $children_ages_string = "";

                if(isset($children_ages) && count($children_ages) > 0){
                  foreach($children_ages as $child_age){
                    if($children_ages_string == ""){
                      if($child_age == "1" || $child_age == "<1"){
                        $children_ages_string = $child_age. " year";
                      }
                      else{
                        $children_ages_string = $child_age. " years";
                      }
                    }
                    else{
                      if($child_age == "1" || $child_age == "<1"){
                        $children_ages_string .= " and ".$child_age. " year";
                      }
                      else{
                        $children_ages_string .= " and ".$child_age. " years";
                      }
                    }
                  }
                  $children_ages_string .= " old";
                  //end converting children ages to string
                }


                $searched_string = "* You searched ";
                if(isset($room_count) && count($room_count) > 0){
                  // room count
                  if($room_count > 1){
                    $searched_string .= $room_count." rooms ";
                  }
                  else if($room_count == 1){
                    $searched_string .= $room_count." room ";
                  }
                }

                if(isset($adult_count) && count($adult_count) > 0){
                  // adult count
                  if($adult_count > 1){
                    $searched_string .= 'for '.$adult_count." adults";
                  }
                  else if($adult_count == 1){
                    $searched_string .= 'for '.$adult_count." adult";
                  }
                }

                if(isset($children_count) && count($children_count) > 0){
                  // children count
                  if($children_count > 1){
                    if(isset($adult_count) && count($adult_count) > 0 && $adult_count !== "0"){
                      $searched_string .= " and ".$children_count." children of age ".$children_ages_string;
                    }
                    else{
                      $searched_string .= $children_count." children of age ".$children_ages_string;
                    }
                  }
                  else if($children_count == 1){
                    if(isset($adult_count) && count($adult_count) > 0 && $adult_count !== "0"){
                      $searched_string .= " and ".$children_count." child of age ".$children_ages_string;
                    }
                    else{
                      $searched_string .= "for ".$children_count." child of age ".$children_ages_string;
                    }
                  }
                  // else{
                  //   $searched_string .= " and ".$children_count." child of age ".$children_ages_string;
                  // }
                }
            }

            // $promotionRepo  = new RoomDiscountRepository();

            //today date
            $today_date = Date('Y-m-d');

            /*start operation to check room promotion*/
            foreach($roomCategories as $room_cat){
                //original price before discount
                $original_price = $room_cat->price;

                // has_promotion flag is initially 0
                $room_cat->has_promotion = 0;

                //initialize amount after discount (initially same with original price)
                $amount_after_discount = $original_price;

                $room_promotion = $discountRepo->getRoomCategoryDiscount($room_cat->id,$today_date);

                //if there is promotion for this room category
                if(isset($room_promotion) && count($room_promotion)){
                  //set has_promotion flag to 1
                  $room_cat->has_promotion = 1;

                  //check if discount type is "amount"
                  if($room_promotion->type == "amount"){
                    //get discount amount
                    $dis_amount = $room_promotion->discount_amount;
                    $amount_after_discount -= $dis_amount;
                    $currency = strtoupper(PaymentConstance::STIRPE_CURRENCY);
                    $discount_text = $currency.' '.$dis_amount.' off';
                  }
                  else{
                    //get discount percentage
                    $dis_percent = $room_promotion->discount_percent;
                    // $dis_amount_from_percent = $discount_percent * (100/$original_price);
                    // $dis_amount_from_percent = $dis_percent * (100/$original_price);

                    $dis_amount_from_percent = $dis_percent * ($original_price/100);
                    $amount_after_discount -= $dis_amount_from_percent;
                    $discount_text = $dis_percent.'% off';
                  }

                  $room_cat->amount_after_discount = number_format($amount_after_discount,2);
                  $room_cat->discount_text         = $discount_text;
                }
            }
            /*end operation to check room promotion*/

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
                ->with('available_category_id_array',$available_category_id_array)
                ->with('hFeatures',$hFeatures)
                ->with('room_availables_count',$room_availables_count)
                ->with('restaurantCategoryArr',$restaurantCategoryArr)
                ->with('total_available_room',$total_available_room)
                ->with('hotelGalleryImages',$hotelGalleryImages)
                ->with('gst',$gst)
                ->with('service_tax',$service_tax)
                //to display information about room count, adult count, children count and age
                ->with('room_count',$room_count)
                ->with('adult_count',$adult_count)
                ->with('children_count',$children_count)
                ->with('children_ages',$children_ages)
                ->with('searched_string',$searched_string);
        }
        catch(\Exception $e){
            //write log here
            //disable error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'A user viewed details of  hotel_id = '.$hotel_id.' and got error : '.$e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            Session::flush();
            return redirect('/');
        }
    }
}
