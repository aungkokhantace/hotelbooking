<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 2:18 PM
 */
use Illuminate\Database\Seeder;
class Default_PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('core_permissions')->delete();
        $existingPermissions = DB::select('SELECT id FROM core_permissions');

        $permissions = array(

            // Roles
            ['id'=>1,'module'=>'Role','name'=>'Listing','description'=>'Role Listing','url'=>'backend/role'],
            ['id'=>2,'module'=>'Role','name'=>'New','description'=>'Role New','url'=>'backend/role/create'],
            ['id'=>3,'module'=>'Role','name'=>'Store','description'=>'Role Store','url'=>'backend/role/store'],
            ['id'=>4,'module'=>'Role','name'=>'Edit','description'=>'Role Edit','url'=>'backend/role/edit'],
            ['id'=>5,'module'=>'Role','name'=>'Update','description'=>'Role Update','url'=>'backend/role/update'],
            ['id'=>6,'module'=>'Role','name'=>'Destroy','description'=>'Role Destroy','url'=>'backend/role/destroy'],
            ['id'=>7,'module'=>'Role','name'=>'Permission View','description'=>'Role Permission View','url'=>'backend/rolePermission'],
            ['id'=>8,'module'=>'Role','name'=>'Permission Assign','description'=>'Role Permission Assign','url'=>'backend/rolePermissionAssign'],
            ['id'=>9,'module'=>'User','name'=>'Listing','description'=>'User Listing','url'=>'backend/user'],
            ['id'=>10,'module'=>'User','name'=>'New','description'=>'User New','url'=>'backend/user/create'],
            ['id'=>11,'module'=>'User','name'=>'Store','description'=>'User Store','url'=>'backend/user/store'],
            ['id'=>12,'module'=>'User','name'=>'Edit','description'=>'User Edit','url'=>'backend/user/edit'],
            ['id'=>13,'module'=>'User','name'=>'Update','description'=>'User Update','url'=>'backend/user/update'],
            ['id'=>14,'module'=>'User','name'=>'Destroy','description'=>'User Destroy','url'=>'backend/user/destroy'],
            ['id'=>15,'module'=>'User','name'=>'Auth','description'=>'Getting Auth User','url'=>'backend/userAuth'],
            ['id'=>16,'module'=>'User','name'=>'Profile','description'=>'User Profile','url'=>'backend/user/profile'],
            ['id'=>17,'module'=>'Permission','name'=>'Listing','description'=>'Permission Listing','url'=>'backend/permission'],
            ['id'=>18,'module'=>'Permission','name'=>'New','description'=>'Permission New','url'=>'backend/permission/create'],
            ['id'=>19,'module'=>'Permission','name'=>'Store','description'=>'Permission Store','url'=>'backend/permission/store'],
            ['id'=>20,'module'=>'Permission','name'=>'Edit','description'=>'Permission Edit','url'=>'backend/permission/edit'],
            ['id'=>21,'module'=>'Permission','name'=>'Update','description'=>'Permission Update','url'=>'backend/permission/update'],
            ['id'=>22,'module'=>'Permission','name'=>'Destroy','description'=>'Permission Destroy','url'=>'backend/permission/destroy'],
            ['id'=>23,'module'=>'Config','name'=>'View','description'=>'Editing','url'=>'backend/config'],
            ['id'=>30,'module'=>'Backend','name'=>'Listing','description'=>'Backend Listing','url'=>'backend'],
            ['id'=>31,'module'=>'Backend','name'=>'New','description'=>'Backend New','url'=>'backend/create'],
            ['id'=>32,'module'=>'Backend','name'=>'Store','description'=>'Backend Store','url'=>'backend/store'],
            ['id'=>33,'module'=>'Backend','name'=>'Edit','description'=>'Backend Edit','url'=>'backend/edit'],
            ['id'=>34,'module'=>'Backend','name'=>'Update','description'=>'Backend Update','url'=>'backend/update'],
            ['id'=>35,'module'=>'Backend','name'=>'Detail','description'=>'Backend Detail','url'=>'backend/detail'],
            ['id'=>36,'module'=>'Backend','name'=>'Detail Update','description'=>'Backend Update','url'=>'backend/detail/update'],
            ['id'=>37,'module'=>'Frontend','name'=>'Listing','description'=>'Listing','url'=>'frontend'],
            ['id'=>38,'module'=>'Frontend','name'=>'Log','description'=>'Backend','url'=>'log/backend'],
            ['id'=>39,'module'=>'Frontend','name'=>'Log','description'=>'Frontend','url'=>'log/frontend'],
            ['id'=>40,'module'=>'Frontend','name'=>'Log','description'=>'Activation','url'=>'log/activation'],
            ['id'=>41,'module'=>'Frontend','name'=>'Update Status','description'=>'Update Status','url'=>'frontend/updatestatus'],
            ['id'=>42,'module'=>'Frontend','name'=>'Update','description'=>'Update Frontend','url'=>'frontend/update'],
            ['id'=>43,'module'=>'Frontend','name'=>'Edit','description'=>'Edit Frontend','url'=>'frontend/edit'],
            ['id'=>44,'module'=>'Backend','name'=>'View','description'=>'Editing','url'=>'backend/site_config'],
            ['id'=>50,'module'=>'Country','name'=>'Listing','description'=>'Country Listing','url'=>'backend/country'],
            ['id'=>51,'module'=>'Country','name'=>'New','description'=>'Country New','url'=>'backend/country/create'],
            ['id'=>52,'module'=>'Country','name'=>'store','description'=>'Country Store','url'=>'backend/country/store'],
            ['id'=>53,'module'=>'Country','name'=>'Edit','description'=>'Country Edit','url'=>'backend/country/edit'],
            ['id'=>54,'module'=>'Country','name'=>'Update','description'=>'Country Update','url'=>'backend/country/update'],
            ['id'=>55,'module'=>'Country','name'=>'Destroy','description'=>'Country Destroy','url'=>'backend/country/destroy'],
            ['id'=>60,'module'=>'Township','name'=>'Listing','description'=>'Township Listing','url'=>'backend/township'],
            ['id'=>61,'module'=>'Township','name'=>'New','description'=>'Township New','url'=>'backend/township/create'],
            ['id'=>62,'module'=>'Township','name'=>'store','description'=>'Township Store','url'=>'backend/township/store'],
            ['id'=>63,'module'=>'Township','name'=>'Edit','description'=>'Township Edit','url'=>'backend/township/edit'],
            ['id'=>64,'module'=>'Township','name'=>'Update','description'=>'Township Update','url'=>'backend/township/update'],
            ['id'=>65,'module'=>'Township','name'=>'Destroy','description'=>'Township Destroy','url'=>'backend/township/destroy'],
            ['id'=>70,'module'=>'City','name'=>'Listing','description'=>'City Listing','url'=>'backend/city'],
            ['id'=>71,'module'=>'City','name'=>'New','description'=>'City New','url'=>'backend/city/create'],
            ['id'=>72,'module'=>'City','name'=>'store','description'=>'City Store','url'=>'backend/city/store'],
            ['id'=>73,'module'=>'City','name'=>'Edit','description'=>'City Edit','url'=>'backend/city/edit'],
            ['id'=>74,'module'=>'City','name'=>'Update','description'=>'City Update','url'=>'backend/city/update'],
            ['id'=>75,'module'=>'City','name'=>'Destroy','description'=>'City Destroy','url'=>'backend/city/destroy'],
            ['id'=>76,'module'=>'Popular City','name'=>'New','description'=>'Popular City New','url'=>'backend/popular_city/create'],
            ['id'=>77,'module'=>'Popular City','name'=>'Store','description'=>'Popular City Store','url'=>'backend/popular_city/store'],
            ['id'=>80,'module'=>'Features','name'=>'Listing','description'=>'Features Listing','url'=>'backend/feature'],
            ['id'=>81,'module'=>'Features','name'=>'New','description'=>'Features New','url'=>'backend/feature/create'],
            ['id'=>82,'module'=>'Features','name'=>'store','description'=>'Features Store','url'=>'backend/feature/store'],
            ['id'=>83,'module'=>'Features','name'=>'Edit','description'=>'Features Edit','url'=>'backend/feature/edit'],
            ['id'=>84,'module'=>'Features','name'=>'Update','description'=>'Features Update','url'=>'backend/feature/update'],
            ['id'=>85,'module'=>'Features','name'=>'Destroy','description'=>'Features Destroy','url'=>'backend/feature/destroy'],
            ['id'=>90,'module'=>'Amenities','name'=>'Listing','description'=>'Amenities Listing','url'=>'backend/amenities'],
            ['id'=>91,'module'=>'Amenities','name'=>'New','description'=>'Amenities New','url'=>'backend/amenities/create'],
            ['id'=>92,'module'=>'Amenities','name'=>'store','description'=>'Amenities Store','url'=>'backend/amenities/store'],
            ['id'=>93,'module'=>'Amenities','name'=>'Edit','description'=>'Amenities Edit','url'=>'backend/amenities/edit'],
            ['id'=>94,'module'=>'Amenities','name'=>'Update','description'=>'Amenities Update','url'=>'backend/amenities/update'],
            ['id'=>95,'module'=>'Amenities','name'=>'Destroy','description'=>'Amenities Destroy','url'=>'backend/amenities/destroy'],
            ['id'=>100,'module'=>'Facilities','name'=>'Listing','description'=>'Facilities Listing','url'=>'backend/facilities'],
            ['id'=>101,'module'=>'Facilities','name'=>'New','description'=>'Facilities New','url'=>'backend/facilities/create'],
            ['id'=>102,'module'=>'Facilities','name'=>'store','description'=>'Facilities Store','url'=>'backend/facilities/store'],
            ['id'=>103,'module'=>'Facilities','name'=>'Edit','description'=>'Facilities Edit','url'=>'backend/facilities/edit'],
            ['id'=>104,'module'=>'Facilities','name'=>'Update','description'=>'Facilities Update','url'=>'backend/facilities/update'],
            ['id'=>105,'module'=>'Facilities','name'=>'Destroy','description'=>'Facilities Destroy','url'=>'backend/facilities/destroy'],
            ['id'=>110,'module'=>'HotelRestaurantCategory','name'=>'Listing','description'=>'HotelRestaurantCategory Listing','url'=>'backend/hotel_restaurant_category'],
            ['id'=>111,'module'=>'HotelRestaurantCategory','name'=>'New','description'=>'HotelRestaurantCategory New','url'=>'backend/hotel_restaurant_category/create'],
            ['id'=>112,'module'=>'HotelRestaurantCategory','name'=>'store','description'=>'HotelRestaurantCategory Store','url'=>'backend/hotel_restaurant_category/store'],
            ['id'=>113,'module'=>'HotelRestaurantCategory','name'=>'Edit','description'=>'HotelRestaurantCategory Edit','url'=>'backend/hotel_restaurant_category/edit'],
            ['id'=>114,'module'=>'HotelRestaurantCategory','name'=>'Update','description'=>'HotelRestaurantCategory Update','url'=>'backend/hotel_restaurant_category/update'],
            ['id'=>115,'module'=>'HotelRestaurantCategory','name'=>'Destroy','description'=>'HotelRestaurantCategory Destroy','url'=>'backend/hotel_restaurant_category/destroy'],
            ['id'=>120,'module'=>'RoomCategoryAmenities','name'=>'Listing','description'=>'RoomCategoryAmenities Listing','url'=>'backend/room_category_amenities'],
            ['id'=>121,'module'=>'RoomCategoryAmenities','name'=>'New','description'=>'RoomCategoryAmenities New','url'=>'backend/room_category_amenities/create'],
            ['id'=>122,'module'=>'RoomCategoryAmenities','name'=>'store','description'=>'RoomCategoryAmenities Store','url'=>'backend/room_category_amenities/store'],
            ['id'=>123,'module'=>'RoomCategoryAmenities','name'=>'Edit','description'=>'RoomCategoryAmenities Edit','url'=>'backend/room_category_amenities/edit'],
            ['id'=>124,'module'=>'RoomCategoryAmenities','name'=>'Update','description'=>'RoomCategoryAmenities Update','url'=>'backend/room_category_amenities/update'],
            ['id'=>125,'module'=>'RoomCategoryAmenities','name'=>'Destroy','description'=>'RoomCategoryAmenities Destroy','url'=>'backend/room_category_amenities/destroy'],
            ['id'=>130,'module'=>'Country','name'=>'Jquery Validation','description'=>'Country Jquery Validation','url'=>'backend/country/check_country_name'],
            ['id'=>131,'module'=>'City','name'=>'Jquery Validation','description'=>'City Jquery Validation','url'=>'backend/city/check_city_name'],
            ['id'=>140,'module'=>'Room View','name'=>'Listing','description'=>'Room View Listing','url'=>'backend/room_view'],
            ['id'=>141,'module'=>'Room View','name'=>'New','description'=>'Room View New','url'=>'backend/room_view/create'],
            ['id'=>142,'module'=>'Room View','name'=>'store','description'=>'Room View Store','url'=>'backend/room_view/store'],
            ['id'=>143,'module'=>'Room View','name'=>'Edit','description'=>'Room View Edit','url'=>'backend/room_view/edit'],
            ['id'=>144,'module'=>'Room View','name'=>'Update','description'=>'Room View Update','url'=>'backend/room_view/update'],
            ['id'=>145,'module'=>'Room View','name'=>'Destroy','description'=>'Room View Destroy','url'=>'backend/room_view/destroy'],
            ['id'=>150,'module'=>'Hotel','name'=>'Listing','description'=>'Hotel Listing','url'=>'backend/hotel'],
            ['id'=>151,'module'=>'Hotel','name'=>'New','description'=>'Hotel New','url'=>'backend/hotel/create'],
            ['id'=>152,'module'=>'Hotel','name'=>'store','description'=>'Hotel Store','url'=>'backend/hotel/store'],
            ['id'=>153,'module'=>'Hotel','name'=>'Edit','description'=>'Hotel Edit','url'=>'backend/hotel/edit'],
            ['id'=>154,'module'=>'Hotel','name'=>'Update','description'=>'Hotel Update','url'=>'backend/hotel/update'],
            ['id'=>155,'module'=>'Hotel','name'=>'Destroy','description'=>'Hotel Destroy','url'=>'backend/hotel/destroy'],
            ['id'=>156,'module'=>'Recommend Hotel','name'=>'New','description'=>'Recommend Hotel New','url'=>'backend/recommend_hotel/create'],
            ['id'=>157,'module'=>'Recommend Hotel','name'=>'Store','description'=>'Recommend Hotel Store','url'=>'backend/recommend_hotel/store'],
            ['id'=>160,'module'=>'HotelRoomType','name'=>'Listing','description'=>'Hotel Room Type Listing','url'=>'backend/hotel_room_type'],
            ['id'=>161,'module'=>'HotelRoomType','name'=>'New','description'=>'Hotel Room Type New','url'=>'backend/hotel_room_type/create'],
            ['id'=>162,'module'=>'HotelRoomType','name'=>'store','description'=>'Hotel Room Type Store','url'=>'backend/hotel_room_type/store'],
            ['id'=>163,'module'=>'HotelRoomType','name'=>'Edit','description'=>'Hotel Room Type Edit','url'=>'backend/hotel_room_type/edit'],
            ['id'=>164,'module'=>'HotelRoomType','name'=>'Update','description'=>'Hotel Room Type Update','url'=>'backend/hotel_room_type/update'],
            ['id'=>165,'module'=>'HotelRoomType','name'=>'Destroy','description'=>'Hotel Room Type Destroy','url'=>'backend/hotel_room_type/destroy'],
            ['id'=>170,'module'=>'HotelRoomCategory','name'=>'Listing','description'=>'Hotel Room Category Listing','url'=>'backend/hotel_room_category'],
            ['id'=>171,'module'=>'HotelRoomCategory','name'=>'New','description'=>'Hotel Room Category New','url'=>'backend/hotel_room_category/create'],
            ['id'=>172,'module'=>'HotelRoomCategory','name'=>'store','description'=>'Hotel Room Category Store','url'=>'backend/hotel_room_category/store'],
            ['id'=>173,'module'=>'HotelRoomCategory','name'=>'Edit','description'=>'Hotel Room Category Edit','url'=>'backend/hotel_room_category/edit'],
            ['id'=>174,'module'=>'HotelRoomCategory','name'=>'Update','description'=>'Hotel Room Category Update','url'=>'backend/hotel_room_category/update'],
            ['id'=>175,'module'=>'HotelRoomCategory','name'=>'Destroy','description'=>'Hotel Room Category Destroy','url'=>'backend/hotel_room_category/destroy'],
            ['id'=>180,'module'=>'Room','name'=>'Listing','description'=>'Room Listing','url'=>'backend/room'],
            ['id'=>181,'module'=>'Room','name'=>'New','description'=>'Room New','url'=>'backend/room/create'],
            ['id'=>182,'module'=>'Room','name'=>'store','description'=>'Room Store','url'=>'backend/room/store'],
            ['id'=>183,'module'=>'Room','name'=>'Edit','description'=>'Room Edit','url'=>'backend/room/edit'],
            ['id'=>184,'module'=>'Room','name'=>'Update','description'=>'Room Update','url'=>'backend/room/update'],
            ['id'=>185,'module'=>'Room','name'=>'Destroy','description'=>'Room Destroy','url'=>'backend/room/destroy'],
            ['id'=>190,'module'=>'RoomCategoryFacility','name'=>'Listing','description'=>'Room Category Facility Listing','url'=>'backend/room_category_facility'],
            ['id'=>191,'module'=>'RoomCategoryFacility','name'=>'New','description'=>'Room Category Facility New','url'=>'backend/room_category_facility/create'],
            ['id'=>192,'module'=>'RoomCategoryFacility','name'=>'store','description'=>'Room Category Facility Store','url'=>'backend/room_category_facility/store'],
            ['id'=>193,'module'=>'RoomCategoryFacility','name'=>'Edit','description'=>'Room Category Facility Edit','url'=>'backend/room_category_facility/edit'],
            ['id'=>194,'module'=>'RoomCategoryFacility','name'=>'Update','description'=>'Room Category Facility Update','url'=>'backend/room_category_facility/update'],
            ['id'=>195,'module'=>'RoomCategoryFacility','name'=>'Destroy','description'=>'Room Category Facility Destroy','url'=>'backend/room_category_facility/destroy'],
            ['id'=>200,'module'=>'HotelFeature','name'=>'Listing','description'=>'Hotel Feature Listing','url'=>'backend/hotel_feature'],
            ['id'=>201,'module'=>'HotelFeature','name'=>'New','description'=>'Hotel Feature New','url'=>'backend/hotel_feature/create'],
            ['id'=>202,'module'=>'HotelFeature','name'=>'store','description'=>'Hotel Feature Store','url'=>'backend/hotel_feature/store'],
            ['id'=>203,'module'=>'HotelFeature','name'=>'Edit','description'=>'Hotel Feature Edit','url'=>'backend/hotel_feature/edit'],
            ['id'=>204,'module'=>'HotelFeature','name'=>'Update','description'=>'Hotel Feature Update','url'=>'backend/hotel_feature/update'],
            ['id'=>205,'module'=>'HotelFeature','name'=>'Destroy','description'=>'Hotel Feature Destroy','url'=>'backend/hotel_feature/destroy'],
            ['id'=>210,'module'=>'RoomDiscount','name'=>'Listing','description'=>'Room Discount Listing','url'=>'backend/room_discount'],
            ['id'=>211,'module'=>'RoomDiscount','name'=>'New','description'=>'Room Discount New','url'=>'backend/room_discount/create'],
            ['id'=>212,'module'=>'RoomDiscount','name'=>'store','description'=>'Room Discount Store','url'=>'backend/room_discount/store'],
            ['id'=>213,'module'=>'RoomDiscount','name'=>'Edit','description'=>'Room Discount Edit','url'=>'backend/room_discount/edit'],
            ['id'=>214,'module'=>'RoomDiscount','name'=>'Update','description'=>'Room Discount Update','url'=>'backend/room_discount/update'],
            ['id'=>215,'module'=>'RoomDiscount','name'=>'Destroy','description'=>'Room Discount Destroy','url'=>'backend/room_discount/destroy'],
            ['id'=>220,'module'=>'RoomBlackoutPeriod','name'=>'Listing','description'=>'Room Blackout Period Listing','url'=>'backend/room_blackout_period'],
            ['id'=>221,'module'=>'RoomBlackoutPeriod','name'=>'New','description'=>'Room Blackout Period New','url'=>'backend/room_blackout_period/create'],
            ['id'=>222,'module'=>'RoomBlackoutPeriod','name'=>'store','description'=>'Room Blackout Period Store','url'=>'backend/room_blackout_period/store'],
            ['id'=>223,'module'=>'RoomBlackoutPeriod','name'=>'Edit','description'=>'Room Blackout Period Edit','url'=>'backend/room_blackout_period/edit'],
            ['id'=>224,'module'=>'RoomBlackoutPeriod','name'=>'Update','description'=>'Room Blackout Period Update','url'=>'backend/room_blackout_period/update'],
            ['id'=>225,'module'=>'RoomBlackoutPeriod','name'=>'Destroy','description'=>'Room Blackout Period Destroy','url'=>'backend/room_blackout_period/destroy'],
            ['id'=>230,'module'=>'RoomAvailablePeriod','name'=>'Listing','description'=>'Room Available Period Listing','url'=>'backend/room_available_period'],
            ['id'=>231,'module'=>'RoomAvailablePeriod','name'=>'New','description'=>'Room Available Period New','url'=>'backend/room_available_period/create'],
            ['id'=>232,'module'=>'RoomAvailablePeriod','name'=>'store','description'=>'Room Available Period Store','url'=>'backend/room_available_period/store'],
            ['id'=>233,'module'=>'RoomAvailablePeriod','name'=>'Edit','description'=>'Room Available Period Edit','url'=>'backend/room_available_period/edit'],
            ['id'=>234,'module'=>'RoomAvailablePeriod','name'=>'Update','description'=>'Room Available Period Update','url'=>'backend/room_available_period/update'],
            ['id'=>235,'module'=>'RoomAvailablePeriod','name'=>'Destroy','description'=>'Room Available Period Destroy','url'=>'backend/room_available_period/destroy'],
            ['id'=>240,'module'=>'HotelNearbyAirport','name'=>'Listing','description'=>'Hotel Nearby Airport Listing','url'=>'backend/hotel_nearby_airport'],
            ['id'=>241,'module'=>'HotelNearbyAirport','name'=>'New','description'=>'Hotel Nearby Airport New','url'=>'backend/hotel_nearby_airport/create'],
            ['id'=>242,'module'=>'HotelNearbyAirport','name'=>'store','description'=>'Hotel Nearby Airport Store','url'=>'backend/hotel_nearby_airport/store'],
            ['id'=>243,'module'=>'HotelNearbyAirport','name'=>'Edit','description'=>'Hotel Nearby Airport Edit','url'=>'backend/hotel_nearby_airport/edit'],
            ['id'=>244,'module'=>'HotelNearbyAirport','name'=>'Update','description'=>'Hotel Nearby Airport Update','url'=>'backend/hotel_nearby_airport/update'],
            ['id'=>245,'module'=>'HotelNearbyAirport','name'=>'Destroy','description'=>'Hotel Nearby Airport Destroy','url'=>'backend/hotel_nearby_airport/destroy'],
            ['id'=>250,'module'=>'HotelNearbyStation','name'=>'Listing','description'=>'Hotel Nearby Station Listing','url'=>'backend/hotel_nearby_station'],
            ['id'=>251,'module'=>'HotelNearbyStation','name'=>'New','description'=>'Hotel Nearby Station New','url'=>'backend/hotel_nearby_station/create'],
            ['id'=>252,'module'=>'HotelNearbyStation','name'=>'store','description'=>'Hotel Nearby Station Store','url'=>'backend/hotel_nearby_station/store'],
            ['id'=>253,'module'=>'HotelNearbyStation','name'=>'Edit','description'=>'Hotel Nearby Station Edit','url'=>'backend/hotel_nearby_station/edit'],
            ['id'=>254,'module'=>'HotelNearbyStation','name'=>'Update','description'=>'Hotel Nearby Station Update','url'=>'backend/hotel_nearby_station/update'],
            ['id'=>255,'module'=>'HotelNearbyStation','name'=>'Destroy','description'=>'Hotel Nearby Station Destroy','url'=>'backend/hotel_nearby_station/destroy'],
            ['id'=>260,'module'=>'HotelNearbyHospital','name'=>'Listing','description'=>'Hotel Nearby Hospital Listing','url'=>'backend/hotel_nearby_hospital'],
            ['id'=>261,'module'=>'HotelNearbyHospital','name'=>'New','description'=>'Hotel Nearby Hospital New','url'=>'backend/hotel_nearby_hospital/create'],
            ['id'=>262,'module'=>'HotelNearbyHospital','name'=>'store','description'=>'Hotel Nearby Hospital Store','url'=>'backend/hotel_nearby_hospital/store'],
            ['id'=>263,'module'=>'HotelNearbyHospital','name'=>'Edit','description'=>'Hotel Nearby Hospital Edit','url'=>'backend/hotel_nearby_hospital/edit'],
            ['id'=>264,'module'=>'HotelNearbyHospital','name'=>'Update','description'=>'Hotel Nearby Hospital Update','url'=>'backend/hotel_nearby_hospital/update'],
            ['id'=>265,'module'=>'HotelNearbyHospital','name'=>'Destroy','description'=>'Hotel Nearby Hospital Destroy','url'=>'backend/hotel_nearby_hospital/destroy'],
            ['id'=>270,'module'=>'HotelNearbyConvenienceStore','name'=>'Listing','description'=>'Hotel Nearby Convenience Store Listing','url'=>'backend/hotel_nearby_convenience_store'],
            ['id'=>271,'module'=>'HotelNearbyConvenienceStore','name'=>'New','description'=>'Hotel Nearby Convenience Store New','url'=>'backend/hotel_nearby_convenience_store/create'],
            ['id'=>272,'module'=>'HotelNearbyConvenienceStore','name'=>'store','description'=>'Hotel Nearby Convenience Store Store','url'=>'backend/hotel_nearby_convenience_store/store'],
            ['id'=>273,'module'=>'HotelNearbyConvenienceStore','name'=>'Edit','description'=>'Hotel Nearby Convenience Store Edit','url'=>'backend/hotel_nearby_convenience_store/edit'],
            ['id'=>274,'module'=>'HotelNearbyConvenienceStore','name'=>'Update','description'=>'Hotel Nearby Convenience Store Update','url'=>'backend/hotel_nearby_convenience_store/update'],
            ['id'=>275,'module'=>'HotelNearbyConvenienceStore','name'=>'Destroy','description'=>'Hotel Nearby Convenience Store Destroy','url'=>'backend/hotel_nearby_convenience_store/destroy'],
            ['id'=>280,'module'=>'HotelNearbyDrugStore','name'=>'Listing','description'=>'Hotel Nearby Drug Store Listing','url'=>'backend/hotel_nearby_drug_store'],
            ['id'=>281,'module'=>'HotelNearbyDrugStore','name'=>'New','description'=>'Hotel Nearby Drug Store New','url'=>'backend/hotel_nearby_drug_store/create'],
            ['id'=>282,'module'=>'HotelNearbyDrugStore','name'=>'store','description'=>'Hotel Nearby Drug Store Store','url'=>'backend/hotel_nearby_drug_store/store'],
            ['id'=>283,'module'=>'HotelNearbyDrugStore','name'=>'Edit','description'=>'Hotel Nearby Drug Store Edit','url'=>'backend/hotel_nearby_drug_store/edit'],
            ['id'=>284,'module'=>'HotelNearbyDrugStore','name'=>'Update','description'=>'Hotel Nearby Drug Store Update','url'=>'backend/hotel_nearby_drug_store/update'],
            ['id'=>285,'module'=>'HotelNearbyDrugStore','name'=>'Destroy','description'=>'Hotel Nearby Drug Store Destroy','url'=>'backend/hotel_nearby_drug_store/destroy'],
            ['id'=>290,'module'=>'FacilityGroup','name'=>'Listing','description'=>'Facility Group Listing','url'=>'backend/facility_group'],
            ['id'=>291,'module'=>'FacilityGroup','name'=>'New','description'=>'Facility Group New','url'=>'backend/facility_group/create'],
            ['id'=>292,'module'=>'FacilityGroup','name'=>'store','description'=>'Facility Group Store','url'=>'backend/facility_group/store'],
            ['id'=>293,'module'=>'FacilityGroup','name'=>'Edit','description'=>'Facility Group Edit','url'=>'backend/facility_group/edit'],
            ['id'=>294,'module'=>'FacilityGroup','name'=>'Update','description'=>'Facility Group Update','url'=>'backend/facility_group/update'],
            ['id'=>295,'module'=>'FacilityGroup','name'=>'Destroy','description'=>'Facility Group Destroy','url'=>'backend/facility_group/destroy'],
            ['id'=>300,'module'=>'HotelRestaurant','name'=>'Listing','description'=>'Hotel Restaurant Listing','url'=>'backend/hotel_restaurant'],
            ['id'=>301,'module'=>'HotelRestaurant','name'=>'New','description'=>'Hotel Restaurant New','url'=>'backend/hotel_restaurant/create'],
            ['id'=>302,'module'=>'HotelRestaurant','name'=>'store','description'=>'Hotel Restaurant Store','url'=>'backend/hotel_restaurant/store'],
            ['id'=>303,'module'=>'HotelRestaurant','name'=>'Edit','description'=>'Hotel Restaurant Edit','url'=>'backend/hotel_restaurant/edit'],
            ['id'=>304,'module'=>'HotelRestaurant','name'=>'Update','description'=>'Hotel Restaurant Update','url'=>'backend/hotel_restaurant/update'],
            ['id'=>305,'module'=>'HotelRestaurant','name'=>'Destroy','description'=>'Hotel Restaurant Destroy','url'=>'backend/hotel_restaurant/destroy'],
            ['id'=>310,'module'=>'HotelFacility','name'=>'Listing','description'=>'Hotel Facility Listing','url'=>'backend/hotel_facility'],
            ['id'=>311,'module'=>'HotelFacility','name'=>'New','description'=>'Hotel Facility New','url'=>'backend/hotel_facility/create'],
            ['id'=>312,'module'=>'HotelFacility','name'=>'store','description'=>'Hotel Facility Store','url'=>'backend/hotel_facility/store'],
            ['id'=>313,'module'=>'HotelFacility','name'=>'Edit','description'=>'Hotel Facility Edit','url'=>'backend/hotel_facility/edit'],
            ['id'=>314,'module'=>'HotelFacility','name'=>'Update','description'=>'Hotel Facility Update','url'=>'backend/hotel_facility/update'],
            ['id'=>315,'module'=>'HotelFacility','name'=>'Destroy','description'=>'Hotel Facility Destroy','url'=>'backend/hotel_facility/destroy'],
            ['id'=>320,'module'=>'Landmark','name'=>'Listing','description'=>'Landmark Listing','url'=>'backend/landmark'],
            ['id'=>321,'module'=>'Landmark','name'=>'New','description'=>'Landmark New','url'=>'backend/landmark/create'],
            ['id'=>322,'module'=>'Landmark','name'=>'store','description'=>'Landmark Store','url'=>'backend/landmark/store'],
            ['id'=>323,'module'=>'Landmark','name'=>'Edit','description'=>'Landmark Edit','url'=>'backend/landmark/edit'],
            ['id'=>324,'module'=>'Landmark','name'=>'Update','description'=>'Landmark Update','url'=>'backend/landmark/update'],
            ['id'=>325,'module'=>'Landmark','name'=>'Destroy','description'=>'Landmark Destroy','url'=>'backend/landmark/destroy'],
            ['id'=>330,'module'=>'HotelLandmark','name'=>'Listing','description'=>'Hotel Landmark Listing','url'=>'backend/hotel_landmark'],
            ['id'=>331,'module'=>'HotelLandmark','name'=>'New','description'=>'Hotel Landmark New','url'=>'backend/hotel_landmark/create'],
            ['id'=>332,'module'=>'HotelLandmark','name'=>'store','description'=>'Hotel Landmark Store','url'=>'backend/hotel_landmark/store'],
            ['id'=>333,'module'=>'HotelLandmark','name'=>'Edit','description'=>'Hotel Landmark Edit','url'=>'backend/hotel_landmark/edit'],
            ['id'=>334,'module'=>'HotelLandmark','name'=>'Update','description'=>'Hotel Landmark Update','url'=>'backend/hotel_landmark/update'],
            ['id'=>335,'module'=>'HotelLandmark','name'=>'Destroy','description'=>'Hotel Landmark Destroy','url'=>'backend/hotel_landmark/destroy'],
            ['id'=>340,'module'=>'RoomCategoryAmenity','name'=>'Listing','description'=>'Room Category Amenity Listing','url'=>'backend/room_category_amenity'],
            ['id'=>341,'module'=>'RoomCategoryAmenity','name'=>'New','description'=>'Room Category Amenity New','url'=>'backend/room_category_amenity/create'],
            ['id'=>342,'module'=>'RoomCategoryAmenity','name'=>'store','description'=>'Room Category Amenity Store','url'=>'backend/room_category_amenity/store'],
            ['id'=>343,'module'=>'RoomCategoryAmenity','name'=>'Edit','description'=>'Room Category Amenity Edit','url'=>'backend/room_category_amenity/edit'],
            ['id'=>344,'module'=>'RoomCategoryAmenity','name'=>'Update','description'=>'Room Category Amenity Update','url'=>'backend/room_category_amenity/update'],
            ['id'=>345,'module'=>'RoomCategoryAmenity','name'=>'Destroy','description'=>'Room Category Amenity Destroy','url'=>'backend/room_category_amenity/destroy'],
            ['id'=>350,'module'=>'HotelConfig','name'=>'Listing','description'=>'Hotel Config Listing','url'=>'backend/hotel_config'],
            ['id'=>351,'module'=>'HotelConfig','name'=>'New','description'=>'Hotel Config New','url'=>'backend/hotel_config/create'],
            ['id'=>352,'module'=>'HotelConfig','name'=>'store','description'=>'Hotel Config Store','url'=>'backend/hotel_config/store'],
            ['id'=>353,'module'=>'HotelConfig','name'=>'Edit','description'=>'Hotel Config Edit','url'=>'backend/hotel_config/edit'],
            ['id'=>354,'module'=>'HotelConfig','name'=>'Update','description'=>'Hotel Config Update','url'=>'backend/hotel_config/update'],
            ['id'=>355,'module'=>'HotelConfig','name'=>'Destroy','description'=>'Hotel Config Destroy','url'=>'backend/hotel_config/destroy'],
            ['id'=>360,'module'=>'Report','name'=>'Sale Summary Report','description'=>'Sale Summary Report Listing','url'=>'backend/salesummaryreport'],
            ['id'=>361,'module'=>'Report','name'=>'Sale Summary Report Search','description'=>'Sale Summary Report Search','url'=>'backend/salesummaryreport/search/{type?}/{from?}/{to?}'],
            ['id'=>362,'module'=>'Report','name'=>'Sale Summary Report Excel','description'=>'Sale Summary Report Excel','url'=>'backend/salesummaryreport/exportexcel/{type?}/{from?}/{to?}'],
            ['id'=>370,'module'=>'Report','name'=>'Booking Report','description'=>'Booking Report Listing','url'=>'backend/bookingreport'],
            ['id'=>371,'module'=>'Report','name'=>'Booking Report Search','description'=>'Booking Report Search','url'=>'backend/bookingreport/search/{type?}/{from?}/{to?}/{status?}'],
            ['id'=>372,'module'=>'Report','name'=>'Booking Report Excel','description'=>'Booking Report Excel','url'=>'backend/bookingreport/exportexcel/{type?}/{from?}/{to?}/{status?}'],
            ['id'=>373,'module'=>'Report','name'=>'Booking Room Detail','description'=>'Booking Room Detail Listing','url'=>'backend/bookingreport/room_detail/{id}'],
            ['id'=>500,'module'=>'Backend','name'=>'Multi_Language','description'=>'Backend Multi_Language','url'=>'backend/language'],
            ['id'=>501,'module'=>'HotelNearByCategory','name'=>'Create','description'=>'Hotel Nearby Store','url'=>'backend/nearby_category/create'],
            ['id'=>502,'module'=>'HotelNearByCategory','name'=>'Store','description'=>'Hotel Nearby Store','url'=>'backend/nearby_category/store'],
            ['id'=>503,'module'=>'HotelNearByCategory','name'=>'Listing','description'=>'Nearby Listing','url'=>'backend/nearby_category'],
            ['id'=>504,'module'=>'HotelNearByCategory','name'=>'Edit','description'=>'Nearby Edit','url'=>'backend/nearby_category/edit'],
            ['id'=>505,'module'=>'HotelNearByCategory','name'=>'Update','description'=>'Hotel Nearby Category Update','url'=>'backend/nearby_category/update'],
            ['id'=>506,'module'=>'Nearby','name'=>'Destroy','description'=>'Hotel Nearby Category Destroy','url'=>'backend/nearby_category/destroy'],
            ['id'=>510,'module'=>'HotelNearby','name'=>'Store','description'=>'Hotel Nearby Store','url'=>'backend/hotel_nearby/store'],
            ['id'=>511,'module'=>'HotelNearby','name'=>'Create','description'=>'Hotel Nearby Create','url'=>'backend/hotel_nearby/create'],
            ['id'=>512,'module'=>'HotelNearby','name'=>'Listing','description'=>'Hotel Nearby Listing','url'=>'backend/hotel_nearby'],
            ['id'=>513,'module'=>'HotelNearby','name'=>'Edit','description'=>'Hotel Nearby Edit','url'=>'backend/hotel_nearby/edit'],
            ['id'=>514,'module'=>'HotelNearby','name'=>'Update','description'=>'Hotel Nearby Update','url'=>'backend/hotel_nearby/update'],
            ['id'=>515,'module'=>'HotelNearby','name'=>'Destroy','description'=>'Hotel Nearby Destroy','url'=>'backend/hotel_nearby/destroy'],
            ['id'=>520,'module'=>'Slider','name'=>'Create','description'=>'Slider Create','url'=>'backend/slider/create'],
            ['id'=>521,'module'=>'Slider','name'=>'Store','description'=>'Slider Store','url'=>'backend/slider/store'],
            ['id'=>522,'module'=>'Slider','name'=>'Edit','description'=>'Slider Edit','url'=>'Slider Edit'],
            ['id'=>523,'module'=>'Slider','name'=>'Update','description'=>'Slider Update','url'=>'Slider Update'],
            ['id'=>524,'module'=>'Slider','name'=>'Destroy','description'=>'Slider Destroy','url'=>'backend/slider/destroy'],
            ['id'=>525,'module'=>'Slider','name'=>'Listing','description'=>'Slider Listing','url'=>'backend/slider'],
            ['id'=>531,'module'=>'Page','name'=>'Listing','description'=>'Page Listing','url'=>'backend/page'],
            ['id'=>532,'module'=>'Page','name'=>'Edit','description'=>'Page Edit','url'=>'backend/page/edit'],
            ['id'=>533,'module'=>'Page','name'=>'Update','description'=>'Page Update','url'=>'backend/page/update'],
            ['id'=>541,'module'=>'EmailEvent','name'=>'Listing','description'=>'Email Event Listing','url'=>'backend/eventemail'],
            ['id'=>542,'module'=>'EmailEvent','name'=>'Create','description'=>'Email Event Create','url'=>'backend/eventemail/create'],
            ['id'=>543,'module'=>'EmailEvent','name'=>'Store','description'=>'Email Event Store','url'=>'backend/eventemail/store'],
            ['id'=>544,'module'=>'EmailEvent','name'=>'Edit','description'=>'Email Event Edit','url'=>'backend/eventemail/edit'],
            ['id'=>545,'module'=>'EmailEvent','name'=>'Update','description'=>'Email Event Update','url'=>'backend/eventemail/update'],
            ['id'=>546,'module'=>'EmailEvent','name'=>'Destroy','description'=>'Email Event Destroy','url'=>'backend/eventemail/destroy'],
            ['id'=>550,'module'=>'EmailTemplate','name'=>'Edit','description'=>'Booking Cancel Email Template Edit','url'=>'backend/email_template_booking_cancel'],
            ['id'=>551,'module'=>'EmailTemplate','name'=>'Update','description'=>'Booking Email Template Update','url'=>'backend/email_template_booking_cancel/update'],
            ['id'=>552,'module'=>'EmailTemplate','name'=>'Edit','description'=>'Bookin Confirm Email Template Edit','url'=>'backend/email_template_booking_confirm'],
            ['id'=>553,'module'=>'EmailTemplate','name'=>'Update','description'=>'Bookin Confirm Email Template Update','url'=>'backend/email_template_booking_confirm/update'],
            ['id'=>554,'module'=>'EmailTemplate','name'=>'Edit','description'=>'Bookin Edit Email Template Edit','url'=>'backend/email_template_booking_edit'],
            ['id'=>555,'module'=>'EmailTemplate','name'=>'Update','description'=>'Bookin Edit Email Template Update','url'=>'backend/email_template_booking_edit/update'],
            ['id'=>560,'module'=>'HotelAdmin','name'=>'Dashboard','description'=>'Hotel Admin Dashboard','url'=>'backend/hotel_admin/dashboard'],
            ['id'=>570,'module'=>'HotelBooking','name'=>'Listing','description'=>'Hotel Booking Listing','url'=>'backend/booking'],
            ['id'=>571,'module'=>'HotelBooking','name'=>'Detail','description'=>'Hotel Booking Detail','url'=>'backend/booking/{id}'],
            ['id'=>580,'module'=>'Communication','name'=>'Listing','description'=>'Communication Listing','url'=>'backend/communication'],
            ['id'=>581,'module'=>'Communication','name'=>'Edit','description'=>'Communication Edit','url'=>'backend/communication/reply/{id}'],
            ['id'=>582,'module'=>'Communication','name'=>'Store','description'=>'Communication Store','url'=>'backend/communication/reply/store'],
            ['id'=>590,'module'=>'Transportation Information','name'=>'View and Store','description'=>'Transportation Information View and  Store','url'=>'backend/transportation_information'],
            ['id'=>591,'module'=>'Tour Information','name'=>'View and Store','description'=>'Tour Information View and  Store','url'=>'backend/tour_information'],




        );

//        DB::table('core_permissions')->insert($permissions);

        if(isset($existingPermissions) && count($existingPermissions)>0){

            $newPermissions = array();

            foreach ($permissions as $defaultPermission) {

                $existFlag = 0;
                foreach($existingPermissions as $existPermission) {

                    if($defaultPermission['id'] == $existPermission->id) {
                        $existFlag++;
                        break;
                    }
                }
                if($existFlag == 0) {
                    array_push($newPermissions, $defaultPermission);
                }

            }

            if(count($newPermissions)>0){
                DB::table('core_permissions')->insert($newPermissions);
            }
        }
        else{
            DB::table('core_permissions')->insert($permissions);
        }

        echo "\n";
        echo "*****************************************************";
        echo "\n";
        echo "** Finished Running Default Core Permission Seeder **";
        echo "\n";
        echo "*****************************************************";
        echo "\n";

    }
}