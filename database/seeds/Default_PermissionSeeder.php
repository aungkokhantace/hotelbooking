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
            ['id'=>1,'module'=>'Role','name'=>'Listing','description'=>'Role Listing','url'=>'backend_mps/role'],
            ['id'=>2,'module'=>'Role','name'=>'New','description'=>'Role New','url'=>'backend_mps/role/create'],
            ['id'=>3,'module'=>'Role','name'=>'Store','description'=>'Role Store','url'=>'backend_mps/role/store'],
            ['id'=>4,'module'=>'Role','name'=>'Edit','description'=>'Role Edit','url'=>'backend_mps/role/edit'],
            ['id'=>5,'module'=>'Role','name'=>'Update','description'=>'Role Update','url'=>'backend_mps/role/update'],
            ['id'=>6,'module'=>'Role','name'=>'Destroy','description'=>'Role Destroy','url'=>'backend_mps/role/destroy'],
            ['id'=>7,'module'=>'Role','name'=>'Permission View','description'=>'Role Permission View','url'=>'backend_mps/rolePermission'],
            ['id'=>8,'module'=>'Role','name'=>'Permission Assign','description'=>'Role Permission Assign','url'=>'backend_mps/rolePermissionAssign'],
            ['id'=>9,'module'=>'User','name'=>'Listing','description'=>'User Listing','url'=>'backend_mps/user'],
            ['id'=>10,'module'=>'User','name'=>'New','description'=>'User New','url'=>'backend_mps/user/create'],
            ['id'=>11,'module'=>'User','name'=>'Store','description'=>'User Store','url'=>'backend_mps/user/store'],
            ['id'=>12,'module'=>'User','name'=>'Edit','description'=>'User Edit','url'=>'backend_mps/user/edit'],
            ['id'=>13,'module'=>'User','name'=>'Update','description'=>'User Update','url'=>'backend_mps/user/update'],
            ['id'=>14,'module'=>'User','name'=>'Destroy','description'=>'User Destroy','url'=>'backend_mps/user/destroy'],
            ['id'=>15,'module'=>'User','name'=>'Auth','description'=>'Getting Auth User','url'=>'backend_mps/userAuth'],
            ['id'=>16,'module'=>'User','name'=>'Profile','description'=>'User Profile','url'=>'backend_mps/user/profile'],
            ['id'=>17,'module'=>'Permission','name'=>'Listing','description'=>'Permission Listing','url'=>'backend_mps/permission'],
            ['id'=>18,'module'=>'Permission','name'=>'New','description'=>'Permission New','url'=>'backend_mps/permission/create'],
            ['id'=>19,'module'=>'Permission','name'=>'Store','description'=>'Permission Store','url'=>'backend_mps/permission/store'],
            ['id'=>20,'module'=>'Permission','name'=>'Edit','description'=>'Permission Edit','url'=>'backend_mps/permission/edit'],
            ['id'=>21,'module'=>'Permission','name'=>'Update','description'=>'Permission Update','url'=>'backend_mps/permission/update'],
            ['id'=>22,'module'=>'Permission','name'=>'Destroy','description'=>'Permission Destroy','url'=>'backend_mps/permission/destroy'],
            ['id'=>23,'module'=>'Config','name'=>'View','description'=>'Editing','url'=>'backend_mps/config'],

            //user disable/enable
            ['id'=>24,'module'=>'User','name'=>'Disable','description'=>'User Disable','url'=>'backend_mps/user/disable'],
            ['id'=>25,'module'=>'User','name'=>'Enable','description'=>'User Enable','url'=>'backend_mps/user/enable'],
            ['id'=>26,'module'=>'User','name'=>'Disabled Users','description'=>'Disabled User List','url'=>'backend_mps/user/disabled_users'],

            ['id'=>30,'module'=>'Backend','name'=>'Listing','description'=>'Backend Listing','url'=>'backend'],
            ['id'=>31,'module'=>'Backend','name'=>'New','description'=>'Backend New','url'=>'backend_mps/create'],
            ['id'=>32,'module'=>'Backend','name'=>'Store','description'=>'Backend Store','url'=>'backend_mps/store'],
            ['id'=>33,'module'=>'Backend','name'=>'Edit','description'=>'Backend Edit','url'=>'backend_mps/edit'],
            ['id'=>34,'module'=>'Backend','name'=>'Update','description'=>'Backend Update','url'=>'backend_mps/update'],
            ['id'=>35,'module'=>'Backend','name'=>'Detail','description'=>'Backend Detail','url'=>'backend_mps/detail'],
            ['id'=>36,'module'=>'Backend','name'=>'Detail Update','description'=>'Backend Update','url'=>'backend_mps/detail/update'],
            ['id'=>37,'module'=>'Frontend','name'=>'Listing','description'=>'Listing','url'=>'frontend'],
            ['id'=>38,'module'=>'Frontend','name'=>'Log','description'=>'Backend','url'=>'log/backend'],
            ['id'=>39,'module'=>'Frontend','name'=>'Log','description'=>'Frontend','url'=>'log/frontend'],

            ['id'=>40,'module'=>'Frontend','name'=>'Log','description'=>'Activation','url'=>'log/activation'],
            ['id'=>41,'module'=>'Frontend','name'=>'Update Status','description'=>'Update Status','url'=>'frontend/updatestatus'],
            ['id'=>42,'module'=>'Frontend','name'=>'Update','description'=>'Update Frontend','url'=>'frontend/update'],
            ['id'=>43,'module'=>'Frontend','name'=>'Edit','description'=>'Edit Frontend','url'=>'frontend/edit'],
            ['id'=>44,'module'=>'Backend','name'=>'View','description'=>'Editing','url'=>'backend_mps/site_config'],

            ['id'=>50,'module'=>'Country','name'=>'Listing','description'=>'Country Listing','url'=>'backend_mps/country'],
            ['id'=>51,'module'=>'Country','name'=>'New','description'=>'Country New','url'=>'backend_mps/country/create'],
            ['id'=>52,'module'=>'Country','name'=>'store','description'=>'Country Store','url'=>'backend_mps/country/store'],
            ['id'=>53,'module'=>'Country','name'=>'Edit','description'=>'Country Edit','url'=>'backend_mps/country/edit'],
            ['id'=>54,'module'=>'Country','name'=>'Update','description'=>'Country Update','url'=>'backend_mps/country/update'],
            ['id'=>55,'module'=>'Country','name'=>'Destroy','description'=>'Country Destroy','url'=>'backend_mps/country/destroy'],

            ['id'=>60,'module'=>'Township','name'=>'Listing','description'=>'Township Listing','url'=>'backend_mps/township'],
            ['id'=>61,'module'=>'Township','name'=>'New','description'=>'Township New','url'=>'backend_mps/township/create'],
            ['id'=>62,'module'=>'Township','name'=>'store','description'=>'Township Store','url'=>'backend_mps/township/store'],
            ['id'=>63,'module'=>'Township','name'=>'Edit','description'=>'Township Edit','url'=>'backend_mps/township/edit'],
            ['id'=>64,'module'=>'Township','name'=>'Update','description'=>'Township Update','url'=>'backend_mps/township/update'],
            ['id'=>65,'module'=>'Township','name'=>'Destroy','description'=>'Township Destroy','url'=>'backend_mps/township/destroy'],

            ['id'=>70,'module'=>'City','name'=>'Listing','description'=>'City Listing','url'=>'backend_mps/city'],
            ['id'=>71,'module'=>'City','name'=>'New','description'=>'City New','url'=>'backend_mps/city/create'],
            ['id'=>72,'module'=>'City','name'=>'store','description'=>'City Store','url'=>'backend_mps/city/store'],
            ['id'=>73,'module'=>'City','name'=>'Edit','description'=>'City Edit','url'=>'backend_mps/city/edit'],
            ['id'=>74,'module'=>'City','name'=>'Update','description'=>'City Update','url'=>'backend_mps/city/update'],
            ['id'=>75,'module'=>'City','name'=>'Destroy','description'=>'City Destroy','url'=>'backend_mps/city/destroy'],
            ['id'=>76,'module'=>'PopularCity','name'=>'New','description'=>'Popular City New','url'=>'backend_mps/popular_city/create'],
            ['id'=>77,'module'=>'PopularCity','name'=>'Store','description'=>'Popular City Store','url'=>'backend_mps/popular_city/store'],

            ['id'=>80,'module'=>'Features','name'=>'Listing','description'=>'Features Listing','url'=>'backend_mps/feature'],
            ['id'=>81,'module'=>'Features','name'=>'New','description'=>'Features New','url'=>'backend_mps/feature/create'],
            ['id'=>82,'module'=>'Features','name'=>'store','description'=>'Features Store','url'=>'backend_mps/feature/store'],
            ['id'=>83,'module'=>'Features','name'=>'Edit','description'=>'Features Edit','url'=>'backend_mps/feature/edit'],
            ['id'=>84,'module'=>'Features','name'=>'Update','description'=>'Features Update','url'=>'backend_mps/feature/update'],
            ['id'=>85,'module'=>'Features','name'=>'Destroy','description'=>'Features Destroy','url'=>'backend_mps/feature/destroy'],

            ['id'=>90,'module'=>'Amenities','name'=>'Listing','description'=>'Amenities Listing','url'=>'backend_mps/amenities'],
            ['id'=>91,'module'=>'Amenities','name'=>'New','description'=>'Amenities New','url'=>'backend_mps/amenities/create'],
            ['id'=>92,'module'=>'Amenities','name'=>'store','description'=>'Amenities Store','url'=>'backend_mps/amenities/store'],
            ['id'=>93,'module'=>'Amenities','name'=>'Edit','description'=>'Amenities Edit','url'=>'backend_mps/amenities/edit'],
            ['id'=>94,'module'=>'Amenities','name'=>'Update','description'=>'Amenities Update','url'=>'backend_mps/amenities/update'],
            ['id'=>95,'module'=>'Amenities','name'=>'Destroy','description'=>'Amenities Destroy','url'=>'backend_mps/amenities/destroy'],

            ['id'=>100,'module'=>'Facilities','name'=>'Listing','description'=>'Facilities Listing','url'=>'backend_mps/facilities'],
            ['id'=>101,'module'=>'Facilities','name'=>'New','description'=>'Facilities New','url'=>'backend_mps/facilities/create'],
            ['id'=>102,'module'=>'Facilities','name'=>'store','description'=>'Facilities Store','url'=>'backend_mps/facilities/store'],
            ['id'=>103,'module'=>'Facilities','name'=>'Edit','description'=>'Facilities Edit','url'=>'backend_mps/facilities/edit'],
            ['id'=>104,'module'=>'Facilities','name'=>'Update','description'=>'Facilities Update','url'=>'backend_mps/facilities/update'],
            ['id'=>105,'module'=>'Facilities','name'=>'Destroy','description'=>'Facilities Destroy','url'=>'backend_mps/facilities/destroy'],

            ['id'=>110,'module'=>'HotelRestaurantCategory','name'=>'Listing','description'=>'HotelRestaurantCategory Listing','url'=>'backend_mps/hotel_restaurant_category'],
            ['id'=>111,'module'=>'HotelRestaurantCategory','name'=>'New','description'=>'HotelRestaurantCategory New','url'=>'backend_mps/hotel_restaurant_category/create'],
            ['id'=>112,'module'=>'HotelRestaurantCategory','name'=>'store','description'=>'HotelRestaurantCategory Store','url'=>'backend_mps/hotel_restaurant_category/store'],
            ['id'=>113,'module'=>'HotelRestaurantCategory','name'=>'Edit','description'=>'HotelRestaurantCategory Edit','url'=>'backend_mps/hotel_restaurant_category/edit'],
            ['id'=>114,'module'=>'HotelRestaurantCategory','name'=>'Update','description'=>'HotelRestaurantCategory Update','url'=>'backend_mps/hotel_restaurant_category/update'],
            ['id'=>115,'module'=>'HotelRestaurantCategory','name'=>'Destroy','description'=>'HotelRestaurantCategory Destroy','url'=>'backend_mps/hotel_restaurant_category/destroy'],

            ['id'=>120,'module'=>'RoomCategoryAmenities','name'=>'Listing','description'=>'RoomCategoryAmenities Listing','url'=>'backend_mps/room_category_amenities'],
            ['id'=>121,'module'=>'RoomCategoryAmenities','name'=>'New','description'=>'RoomCategoryAmenities New','url'=>'backend_mps/room_category_amenities/create'],
            ['id'=>122,'module'=>'RoomCategoryAmenities','name'=>'store','description'=>'RoomCategoryAmenities Store','url'=>'backend_mps/room_category_amenities/store'],
            ['id'=>123,'module'=>'RoomCategoryAmenities','name'=>'Edit','description'=>'RoomCategoryAmenities Edit','url'=>'backend_mps/room_category_amenities/edit'],
            ['id'=>124,'module'=>'RoomCategoryAmenities','name'=>'Update','description'=>'RoomCategoryAmenities Update','url'=>'backend_mps/room_category_amenities/update'],
            ['id'=>125,'module'=>'RoomCategoryAmenities','name'=>'Destroy','description'=>'RoomCategoryAmenities Destroy','url'=>'backend_mps/room_category_amenities/destroy'],

            ['id'=>130,'module'=>'Country','name'=>'Jquery Validation','description'=>'Country Jquery Validation','url'=>'backend_mps/country/check_country_name'],
            ['id'=>131,'module'=>'City','name'=>'Jquery Validation','description'=>'City Jquery Validation','url'=>'backend_mps/city/check_city_name'],

            ['id'=>140,'module'=>'RoomView','name'=>'Listing','description'=>'Room View Listing','url'=>'backend_mps/room_view'],
            ['id'=>142,'module'=>'RoomView','name'=>'store','description'=>'Room View Store','url'=>'backend_mps/room_view/store'],
            ['id'=>141,'module'=>'RoomView','name'=>'New','description'=>'Room View New','url'=>'backend_mps/room_view/create'],
            ['id'=>143,'module'=>'RoomView','name'=>'Edit','description'=>'Room View Edit','url'=>'backend_mps/room_view/edit'],
            ['id'=>144,'module'=>'RoomView','name'=>'Update','description'=>'Room View Update','url'=>'backend_mps/room_view/update'],
            ['id'=>145,'module'=>'RoomView','name'=>'Destroy','description'=>'Room View Destroy','url'=>'backend_mps/room_view/destroy'],

            ['id'=>150,'module'=>'Hotel','name'=>'Listing','description'=>'Hotel Listing','url'=>'backend_mps/hotel'],
            ['id'=>151,'module'=>'Hotel','name'=>'New','description'=>'Hotel New','url'=>'backend_mps/hotel/create'],
            ['id'=>152,'module'=>'Hotel','name'=>'store','description'=>'Hotel Store','url'=>'backend_mps/hotel/store'],
            ['id'=>153,'module'=>'Hotel','name'=>'Edit','description'=>'Hotel Edit','url'=>'backend_mps/hotel/edit'],
            ['id'=>154,'module'=>'Hotel','name'=>'Update','description'=>'Hotel Update','url'=>'backend_mps/hotel/update'],
            ['id'=>155,'module'=>'Hotel','name'=>'Destroy','description'=>'Hotel Destroy','url'=>'backend_mps/hotel/destroy'],
            ['id'=>156,'module'=>'RecommendHotel','name'=>'New','description'=>'Recommend Hotel New','url'=>'backend_mps/recommend_hotel/create'],
            ['id'=>157,'module'=>'RecommendHotel','name'=>'Store','description'=>'Recommend Hotel Store','url'=>'backend_mps/recommend_hotel/store'],

            ['id'=>160,'module'=>'HotelRoomType','name'=>'Listing','description'=>'Hotel Room Type Listing','url'=>'backend_mps/hotel_room_type'],
            ['id'=>161,'module'=>'HotelRoomType','name'=>'New','description'=>'Hotel Room Type New','url'=>'backend_mps/hotel_room_type/create'],
            ['id'=>162,'module'=>'HotelRoomType','name'=>'store','description'=>'Hotel Room Type Store','url'=>'backend_mps/hotel_room_type/store'],
            ['id'=>163,'module'=>'HotelRoomType','name'=>'Edit','description'=>'Hotel Room Type Edit','url'=>'backend_mps/hotel_room_type/edit'],
            ['id'=>164,'module'=>'HotelRoomType','name'=>'Update','description'=>'Hotel Room Type Update','url'=>'backend_mps/hotel_room_type/update'],
            ['id'=>165,'module'=>'HotelRoomType','name'=>'Destroy','description'=>'Hotel Room Type Destroy','url'=>'backend_mps/hotel_room_type/destroy'],

            ['id'=>170,'module'=>'HotelRoomCategory','name'=>'Listing','description'=>'Hotel Room Category Listing','url'=>'backend_mps/hotel_room_category'],
            ['id'=>171,'module'=>'HotelRoomCategory','name'=>'New','description'=>'Hotel Room Category New','url'=>'backend_mps/hotel_room_category/create/{hotel_id?}'],
            ['id'=>172,'module'=>'HotelRoomCategory','name'=>'store','description'=>'Hotel Room Category Store','url'=>'backend_mps/hotel_room_category/store'],
            ['id'=>173,'module'=>'HotelRoomCategory','name'=>'Edit','description'=>'Hotel Room Category Edit','url'=>'backend_mps/hotel_room_category/edit'],
            ['id'=>174,'module'=>'HotelRoomCategory','name'=>'Update','description'=>'Hotel Room Category Update','url'=>'backend_mps/hotel_room_category/update'],
            ['id'=>175,'module'=>'HotelRoomCategory','name'=>'Destroy','description'=>'Hotel Room Category Destroy','url'=>'backend_mps/hotel_room_category/destroy'],
            ['id'=>176,'module'=>'HotelRoomCategory','name'=>'Filter with Hotel_id','description'=>'Hotel Room Category Filter','url'=>'backend_mps/hotel_room_category/{hotel_id?}'],

            ['id'=>180,'module'=>'Room','name'=>'Listing','description'=>'Room Listing','url'=>'backend_mps/room'],
            ['id'=>181,'module'=>'Room','name'=>'New','description'=>'Room New','url'=>'backend_mps/room/create'],
            ['id'=>182,'module'=>'Room','name'=>'store','description'=>'Room Store','url'=>'backend_mps/room/store'],
            ['id'=>183,'module'=>'Room','name'=>'Edit','description'=>'Room Edit','url'=>'backend_mps/room/edit'],
            ['id'=>184,'module'=>'Room','name'=>'Update','description'=>'Room Update','url'=>'backend_mps/room/update'],
            ['id'=>185,'module'=>'Room','name'=>'Destroy','description'=>'Room Destroy','url'=>'backend_mps/room/destroy'],

            ['id'=>190,'module'=>'RoomCategoryFacility','name'=>'Listing','description'=>'Room Category Facility Listing','url'=>'backend_mps/room_category_facility'],
            ['id'=>191,'module'=>'RoomCategoryFacility','name'=>'New','description'=>'Room Category Facility New','url'=>'backend_mps/room_category_facility/create'],
            ['id'=>192,'module'=>'RoomCategoryFacility','name'=>'store','description'=>'Room Category Facility Store','url'=>'backend_mps/room_category_facility/store'],
            ['id'=>193,'module'=>'RoomCategoryFacility','name'=>'Edit','description'=>'Room Category Facility Edit','url'=>'backend_mps/room_category_facility/edit'],
            ['id'=>194,'module'=>'RoomCategoryFacility','name'=>'Update','description'=>'Room Category Facility Update','url'=>'backend_mps/room_category_facility/update'],
            ['id'=>195,'module'=>'RoomCategoryFacility','name'=>'Destroy','description'=>'Room Category Facility Destroy','url'=>'backend_mps/room_category_facility/destroy'],

            ['id'=>200,'module'=>'HotelFeature','name'=>'Listing','description'=>'Hotel Feature Listing','url'=>'backend_mps/hotel_feature'],
            ['id'=>201,'module'=>'HotelFeature','name'=>'New','description'=>'Hotel Feature New','url'=>'backend_mps/hotel_feature/create'],
            ['id'=>202,'module'=>'HotelFeature','name'=>'store','description'=>'Hotel Feature Store','url'=>'backend_mps/hotel_feature/store'],
            ['id'=>203,'module'=>'HotelFeature','name'=>'Edit','description'=>'Hotel Feature Edit','url'=>'backend_mps/hotel_feature/edit'],
            ['id'=>204,'module'=>'HotelFeature','name'=>'Update','description'=>'Hotel Feature Update','url'=>'backend_mps/hotel_feature/update'],
            ['id'=>205,'module'=>'HotelFeature','name'=>'Destroy','description'=>'Hotel Feature Destroy','url'=>'backend_mps/hotel_feature/destroy'],

            ['id'=>210,'module'=>'RoomDiscount','name'=>'Listing','description'=>'Room Discount Listing','url'=>'backend_mps/room_discount'],
            ['id'=>211,'module'=>'RoomDiscount','name'=>'New','description'=>'Room Discount New','url'=>'backend_mps/room_discount/create'],
            ['id'=>212,'module'=>'RoomDiscount','name'=>'store','description'=>'Room Discount Store','url'=>'backend_mps/room_discount/store'],
            ['id'=>213,'module'=>'RoomDiscount','name'=>'Edit','description'=>'Room Discount Edit','url'=>'backend_mps/room_discount/edit'],
            ['id'=>214,'module'=>'RoomDiscount','name'=>'Update','description'=>'Room Discount Update','url'=>'backend_mps/room_discount/update'],
            ['id'=>215,'module'=>'RoomDiscount','name'=>'Destroy','description'=>'Room Discount Destroy','url'=>'backend_mps/room_discount/destroy'],

            ['id'=>220,'module'=>'RoomBlackoutPeriod','name'=>'Listing','description'=>'Room Blackout Period Listing','url'=>'backend_mps/room_blackout_period'],
            ['id'=>221,'module'=>'RoomBlackoutPeriod','name'=>'New','description'=>'Room Blackout Period New','url'=>'backend_mps/room_blackout_period/create'],
            ['id'=>222,'module'=>'RoomBlackoutPeriod','name'=>'store','description'=>'Room Blackout Period Store','url'=>'backend_mps/room_blackout_period/store'],
            ['id'=>223,'module'=>'RoomBlackoutPeriod','name'=>'Edit','description'=>'Room Blackout Period Edit','url'=>'backend_mps/room_blackout_period/edit'],
            ['id'=>224,'module'=>'RoomBlackoutPeriod','name'=>'Update','description'=>'Room Blackout Period Update','url'=>'backend_mps/room_blackout_period/update'],
            ['id'=>225,'module'=>'RoomBlackoutPeriod','name'=>'Destroy','description'=>'Room Blackout Period Destroy','url'=>'backend_mps/room_blackout_period/destroy'],

            ['id'=>230,'module'=>'RoomAvailablePeriod','name'=>'Listing','description'=>'Room Available Period Listing','url'=>'backend_mps/room_available_period'],
            ['id'=>231,'module'=>'RoomAvailablePeriod','name'=>'New','description'=>'Room Available Period New','url'=>'backend_mps/room_available_period/create'],
            ['id'=>232,'module'=>'RoomAvailablePeriod','name'=>'store','description'=>'Room Available Period Store','url'=>'backend_mps/room_available_period/store'],
            ['id'=>233,'module'=>'RoomAvailablePeriod','name'=>'Edit','description'=>'Room Available Period Edit','url'=>'backend_mps/room_available_period/edit'],
            ['id'=>234,'module'=>'RoomAvailablePeriod','name'=>'Update','description'=>'Room Available Period Update','url'=>'backend_mps/room_available_period/update'],
            ['id'=>235,'module'=>'RoomAvailablePeriod','name'=>'Destroy','description'=>'Room Available Period Destroy','url'=>'backend_mps/room_available_period/destroy'],

            ['id'=>240,'module'=>'HotelNearbyAirport','name'=>'Listing','description'=>'Hotel Nearby Airport Listing','url'=>'backend_mps/hotel_nearby_airport'],
            ['id'=>241,'module'=>'HotelNearbyAirport','name'=>'New','description'=>'Hotel Nearby Airport New','url'=>'backend_mps/hotel_nearby_airport/create'],
            ['id'=>242,'module'=>'HotelNearbyAirport','name'=>'store','description'=>'Hotel Nearby Airport Store','url'=>'backend_mps/hotel_nearby_airport/store'],
            ['id'=>243,'module'=>'HotelNearbyAirport','name'=>'Edit','description'=>'Hotel Nearby Airport Edit','url'=>'backend_mps/hotel_nearby_airport/edit'],
            ['id'=>244,'module'=>'HotelNearbyAirport','name'=>'Update','description'=>'Hotel Nearby Airport Update','url'=>'backend_mps/hotel_nearby_airport/update'],
            ['id'=>245,'module'=>'HotelNearbyAirport','name'=>'Destroy','description'=>'Hotel Nearby Airport Destroy','url'=>'backend_mps/hotel_nearby_airport/destroy'],

            ['id'=>250,'module'=>'HotelNearbyStation','name'=>'Listing','description'=>'Hotel Nearby Station Listing','url'=>'backend_mps/hotel_nearby_station'],
            ['id'=>251,'module'=>'HotelNearbyStation','name'=>'New','description'=>'Hotel Nearby Station New','url'=>'backend_mps/hotel_nearby_station/create'],
            ['id'=>252,'module'=>'HotelNearbyStation','name'=>'store','description'=>'Hotel Nearby Station Store','url'=>'backend_mps/hotel_nearby_station/store'],
            ['id'=>253,'module'=>'HotelNearbyStation','name'=>'Edit','description'=>'Hotel Nearby Station Edit','url'=>'backend_mps/hotel_nearby_station/edit'],
            ['id'=>254,'module'=>'HotelNearbyStation','name'=>'Update','description'=>'Hotel Nearby Station Update','url'=>'backend_mps/hotel_nearby_station/update'],
            ['id'=>255,'module'=>'HotelNearbyStation','name'=>'Destroy','description'=>'Hotel Nearby Station Destroy','url'=>'backend_mps/hotel_nearby_station/destroy'],

            ['id'=>260,'module'=>'HotelNearbyHospital','name'=>'Listing','description'=>'Hotel Nearby Hospital Listing','url'=>'backend_mps/hotel_nearby_hospital'],
            ['id'=>261,'module'=>'HotelNearbyHospital','name'=>'New','description'=>'Hotel Nearby Hospital New','url'=>'backend_mps/hotel_nearby_hospital/create'],
            ['id'=>262,'module'=>'HotelNearbyHospital','name'=>'store','description'=>'Hotel Nearby Hospital Store','url'=>'backend_mps/hotel_nearby_hospital/store'],
            ['id'=>263,'module'=>'HotelNearbyHospital','name'=>'Edit','description'=>'Hotel Nearby Hospital Edit','url'=>'backend_mps/hotel_nearby_hospital/edit'],
            ['id'=>264,'module'=>'HotelNearbyHospital','name'=>'Update','description'=>'Hotel Nearby Hospital Update','url'=>'backend_mps/hotel_nearby_hospital/update'],
            ['id'=>265,'module'=>'HotelNearbyHospital','name'=>'Destroy','description'=>'Hotel Nearby Hospital Destroy','url'=>'backend_mps/hotel_nearby_hospital/destroy'],

            ['id'=>270,'module'=>'HotelNearbyConvenienceStore','name'=>'Listing','description'=>'Hotel Nearby Convenience Store Listing','url'=>'backend_mps/hotel_nearby_convenience_store'],
            ['id'=>271,'module'=>'HotelNearbyConvenienceStore','name'=>'New','description'=>'Hotel Nearby Convenience Store New','url'=>'backend_mps/hotel_nearby_convenience_store/create'],
            ['id'=>272,'module'=>'HotelNearbyConvenienceStore','name'=>'store','description'=>'Hotel Nearby Convenience Store Store','url'=>'backend_mps/hotel_nearby_convenience_store/store'],
            ['id'=>273,'module'=>'HotelNearbyConvenienceStore','name'=>'Edit','description'=>'Hotel Nearby Convenience Store Edit','url'=>'backend_mps/hotel_nearby_convenience_store/edit'],
            ['id'=>274,'module'=>'HotelNearbyConvenienceStore','name'=>'Update','description'=>'Hotel Nearby Convenience Store Update','url'=>'backend_mps/hotel_nearby_convenience_store/update'],
            ['id'=>275,'module'=>'HotelNearbyConvenienceStore','name'=>'Destroy','description'=>'Hotel Nearby Convenience Store Destroy','url'=>'backend_mps/hotel_nearby_convenience_store/destroy'],

            ['id'=>280,'module'=>'HotelNearbyDrugStore','name'=>'Listing','description'=>'Hotel Nearby Drug Store Listing','url'=>'backend_mps/hotel_nearby_drug_store'],
            ['id'=>281,'module'=>'HotelNearbyDrugStore','name'=>'New','description'=>'Hotel Nearby Drug Store New','url'=>'backend_mps/hotel_nearby_drug_store/create'],
            ['id'=>282,'module'=>'HotelNearbyDrugStore','name'=>'store','description'=>'Hotel Nearby Drug Store Store','url'=>'backend_mps/hotel_nearby_drug_store/store'],
            ['id'=>283,'module'=>'HotelNearbyDrugStore','name'=>'Edit','description'=>'Hotel Nearby Drug Store Edit','url'=>'backend_mps/hotel_nearby_drug_store/edit'],
            ['id'=>284,'module'=>'HotelNearbyDrugStore','name'=>'Update','description'=>'Hotel Nearby Drug Store Update','url'=>'backend_mps/hotel_nearby_drug_store/update'],
            ['id'=>285,'module'=>'HotelNearbyDrugStore','name'=>'Destroy','description'=>'Hotel Nearby Drug Store Destroy','url'=>'backend_mps/hotel_nearby_drug_store/destroy'],

            ['id'=>290,'module'=>'FacilityGroup','name'=>'Listing','description'=>'Facility Group Listing','url'=>'backend_mps/facility_group'],
            ['id'=>291,'module'=>'FacilityGroup','name'=>'New','description'=>'Facility Group New','url'=>'backend_mps/facility_group/create'],
            ['id'=>292,'module'=>'FacilityGroup','name'=>'store','description'=>'Facility Group Store','url'=>'backend_mps/facility_group/store'],
            ['id'=>293,'module'=>'FacilityGroup','name'=>'Edit','description'=>'Facility Group Edit','url'=>'backend_mps/facility_group/edit'],
            ['id'=>294,'module'=>'FacilityGroup','name'=>'Update','description'=>'Facility Group Update','url'=>'backend_mps/facility_group/update'],
            ['id'=>295,'module'=>'FacilityGroup','name'=>'Destroy','description'=>'Facility Group Destroy','url'=>'backend_mps/facility_group/destroy'],

            ['id'=>300,'module'=>'HotelRestaurant','name'=>'Listing','description'=>'Hotel Restaurant Listing','url'=>'backend_mps/hotel_restaurant'],
            ['id'=>301,'module'=>'HotelRestaurant','name'=>'New','description'=>'Hotel Restaurant New','url'=>'backend_mps/hotel_restaurant/create'],
            ['id'=>302,'module'=>'HotelRestaurant','name'=>'store','description'=>'Hotel Restaurant Store','url'=>'backend_mps/hotel_restaurant/store'],
            ['id'=>303,'module'=>'HotelRestaurant','name'=>'Edit','description'=>'Hotel Restaurant Edit','url'=>'backend_mps/hotel_restaurant/edit'],
            ['id'=>304,'module'=>'HotelRestaurant','name'=>'Update','description'=>'Hotel Restaurant Update','url'=>'backend_mps/hotel_restaurant/update'],
            ['id'=>305,'module'=>'HotelRestaurant','name'=>'Destroy','description'=>'Hotel Restaurant Destroy','url'=>'backend_mps/hotel_restaurant/destroy'],

            ['id'=>310,'module'=>'HotelFacility','name'=>'Listing','description'=>'Hotel Facility Listing','url'=>'backend_mps/hotel_facility'],
            ['id'=>311,'module'=>'HotelFacility','name'=>'New','description'=>'Hotel Facility New','url'=>'backend_mps/hotel_facility/create'],
            ['id'=>312,'module'=>'HotelFacility','name'=>'store','description'=>'Hotel Facility Store','url'=>'backend_mps/hotel_facility/store'],
            ['id'=>313,'module'=>'HotelFacility','name'=>'Edit','description'=>'Hotel Facility Edit','url'=>'backend_mps/hotel_facility/edit'],
            ['id'=>314,'module'=>'HotelFacility','name'=>'Update','description'=>'Hotel Facility Update','url'=>'backend_mps/hotel_facility/update'],
            ['id'=>315,'module'=>'HotelFacility','name'=>'Destroy','description'=>'Hotel Facility Destroy','url'=>'backend_mps/hotel_facility/destroy'],

            ['id'=>320,'module'=>'Landmark','name'=>'Listing','description'=>'Landmark Listing','url'=>'backend_mps/landmark'],
            ['id'=>321,'module'=>'Landmark','name'=>'New','description'=>'Landmark New','url'=>'backend_mps/landmark/create'],
            ['id'=>322,'module'=>'Landmark','name'=>'store','description'=>'Landmark Store','url'=>'backend_mps/landmark/store'],
            ['id'=>323,'module'=>'Landmark','name'=>'Edit','description'=>'Landmark Edit','url'=>'backend_mps/landmark/edit'],
            ['id'=>324,'module'=>'Landmark','name'=>'Update','description'=>'Landmark Update','url'=>'backend_mps/landmark/update'],
            ['id'=>325,'module'=>'Landmark','name'=>'Destroy','description'=>'Landmark Destroy','url'=>'backend_mps/landmark/destroy'],

            ['id'=>330,'module'=>'HotelLandmark','name'=>'Listing','description'=>'Hotel Landmark Listing','url'=>'backend_mps/hotel_landmark'],
            ['id'=>331,'module'=>'HotelLandmark','name'=>'New','description'=>'Hotel Landmark New','url'=>'backend_mps/hotel_landmark/create'],
            ['id'=>332,'module'=>'HotelLandmark','name'=>'store','description'=>'Hotel Landmark Store','url'=>'backend_mps/hotel_landmark/store'],
            ['id'=>333,'module'=>'HotelLandmark','name'=>'Edit','description'=>'Hotel Landmark Edit','url'=>'backend_mps/hotel_landmark/edit'],
            ['id'=>334,'module'=>'HotelLandmark','name'=>'Update','description'=>'Hotel Landmark Update','url'=>'backend_mps/hotel_landmark/update'],
            ['id'=>335,'module'=>'HotelLandmark','name'=>'Destroy','description'=>'Hotel Landmark Destroy','url'=>'backend_mps/hotel_landmark/destroy'],

            ['id'=>340,'module'=>'RoomCategoryAmenity','name'=>'Listing','description'=>'Room Category Amenity Listing','url'=>'backend_mps/room_category_amenity'],
            ['id'=>341,'module'=>'RoomCategoryAmenity','name'=>'New','description'=>'Room Category Amenity New','url'=>'backend_mps/room_category_amenity/create'],
            ['id'=>342,'module'=>'RoomCategoryAmenity','name'=>'store','description'=>'Room Category Amenity Store','url'=>'backend_mps/room_category_amenity/store'],
            ['id'=>343,'module'=>'RoomCategoryAmenity','name'=>'Edit','description'=>'Room Category Amenity Edit','url'=>'backend_mps/room_category_amenity/edit'],
            ['id'=>344,'module'=>'RoomCategoryAmenity','name'=>'Update','description'=>'Room Category Amenity Update','url'=>'backend_mps/room_category_amenity/update'],
            ['id'=>345,'module'=>'RoomCategoryAmenity','name'=>'Destroy','description'=>'Room Category Amenity Destroy','url'=>'backend_mps/room_category_amenity/destroy'],

            ['id'=>350,'module'=>'HotelConfig','name'=>'Listing','description'=>'Hotel Config Listing','url'=>'backend_mps/hotel_config'],
            ['id'=>351,'module'=>'HotelConfig','name'=>'New','description'=>'Hotel Config New','url'=>'backend_mps/hotel_config/create'],
            ['id'=>352,'module'=>'HotelConfig','name'=>'store','description'=>'Hotel Config Store','url'=>'backend_mps/hotel_config/store'],
            ['id'=>353,'module'=>'HotelConfig','name'=>'Edit','description'=>'Hotel Config Edit','url'=>'backend_mps/hotel_config/edit'],
            ['id'=>354,'module'=>'HotelConfig','name'=>'Update','description'=>'Hotel Config Update','url'=>'backend_mps/hotel_config/update'],
            ['id'=>355,'module'=>'HotelConfig','name'=>'Destroy','description'=>'Hotel Config Destroy','url'=>'backend_mps/hotel_config/destroy'],

            ['id'=>360,'module'=>'Report','name'=>'Sale Summary Report','description'=>'Sale Summary Report Listing','url'=>'backend_mps/salesummaryreport'],
            ['id'=>361,'module'=>'Report','name'=>'Sale Summary Report Search','description'=>'Sale Summary Report Search','url'=>'backend_mps/salesummaryreport/search/{type?}/{from?}/{to?}'],
            ['id'=>362,'module'=>'Report','name'=>'Sale Summary Report Excel','description'=>'Sale Summary Report Excel','url'=>'backend_mps/salesummaryreport/exportexcel/{type?}/{from?}/{to?}'],

            ['id'=>370,'module'=>'Report','name'=>'Booking Report','description'=>'Booking Report Listing','url'=>'backend_mps/bookingreport'],
            ['id'=>371,'module'=>'Report','name'=>'Booking Report Search','description'=>'Booking Report Search','url'=>'backend_mps/bookingreport/search/{type?}/{from?}/{to?}/{status?}'],
            ['id'=>372,'module'=>'Report','name'=>'Booking Report Excel','description'=>'Booking Report Excel','url'=>'backend_mps/bookingreport/exportexcel/{type?}/{from?}/{to?}/{status?}'],
            ['id'=>373,'module'=>'Report','name'=>'Booking Room Detail','description'=>'Booking Room Detail Listing','url'=>'backend_mps/bookingreport/room_detail/{id}'],

            ['id'=>500,'module'=>'Backend','name'=>'Multi_Language','description'=>'Backend Multi_Language','url'=>'backend_mps/language'],
            ['id'=>501,'module'=>'HotelNearByCategory','name'=>'Create','description'=>'Hotel Nearby Store','url'=>'backend_mps/nearby_category/create'],
            ['id'=>502,'module'=>'HotelNearByCategory','name'=>'Store','description'=>'Hotel Nearby Store','url'=>'backend_mps/nearby_category/store'],
            ['id'=>503,'module'=>'HotelNearByCategory','name'=>'Listing','description'=>'Nearby Listing','url'=>'backend_mps/nearby_category'],
            ['id'=>504,'module'=>'HotelNearByCategory','name'=>'Edit','description'=>'Nearby Edit','url'=>'backend_mps/nearby_category/edit'],
            ['id'=>505,'module'=>'HotelNearByCategory','name'=>'Update','description'=>'Hotel Nearby Category Update','url'=>'backend_mps/nearby_category/update'],
            ['id'=>506,'module'=>'Nearby','name'=>'Destroy','description'=>'Hotel Nearby Category Destroy','url'=>'backend_mps/nearby_category/destroy'],

            ['id'=>510,'module'=>'HotelNearby','name'=>'Store','description'=>'Hotel Nearby Store','url'=>'backend_mps/hotel_nearby/store'],
            ['id'=>511,'module'=>'HotelNearby','name'=>'Create','description'=>'Hotel Nearby Create','url'=>'backend_mps/hotel_nearby/create'],
            ['id'=>512,'module'=>'HotelNearby','name'=>'Listing','description'=>'Hotel Nearby Listing','url'=>'backend_mps/hotel_nearby'],
            ['id'=>513,'module'=>'HotelNearby','name'=>'Edit','description'=>'Hotel Nearby Edit','url'=>'backend_mps/hotel_nearby/edit'],
            ['id'=>514,'module'=>'HotelNearby','name'=>'Update','description'=>'Hotel Nearby Update','url'=>'backend_mps/hotel_nearby/update'],
            ['id'=>515,'module'=>'HotelNearby','name'=>'Destroy','description'=>'Hotel Nearby Destroy','url'=>'backend_mps/hotel_nearby/destroy'],

            ['id'=>520,'module'=>'Slider','name'=>'Create','description'=>'Slider Create','url'=>'backend_mps/slider/create'],
            ['id'=>521,'module'=>'Slider','name'=>'Store','description'=>'Slider Store','url'=>'backend_mps/slider/store'],
            ['id'=>522,'module'=>'Slider','name'=>'Edit','description'=>'Slider Edit','url'=>'Slider Edit'],
            ['id'=>523,'module'=>'Slider','name'=>'Update','description'=>'Slider Update','url'=>'Slider Update'],
            ['id'=>524,'module'=>'Slider','name'=>'Destroy','description'=>'Slider Destroy','url'=>'backend_mps/slider/destroy'],
            ['id'=>525,'module'=>'Slider','name'=>'Listing','description'=>'Slider Listing','url'=>'backend_mps/slider'],

            ['id'=>531,'module'=>'Page','name'=>'Listing','description'=>'Page Listing','url'=>'backend_mps/page'],
            ['id'=>532,'module'=>'Page','name'=>'Edit','description'=>'Page Edit','url'=>'backend_mps/page/edit'],
            ['id'=>533,'module'=>'Page','name'=>'Update','description'=>'Page Update','url'=>'backend_mps/page/update'],

            ['id'=>541,'module'=>'EmailEvent','name'=>'Listing','description'=>'Email Event Listing','url'=>'backend_mps/eventemail'],
            ['id'=>542,'module'=>'EmailEvent','name'=>'Create','description'=>'Email Event Create','url'=>'backend_mps/eventemail/create'],
            ['id'=>543,'module'=>'EmailEvent','name'=>'Store','description'=>'Email Event Store','url'=>'backend_mps/eventemail/store'],
            ['id'=>544,'module'=>'EmailEvent','name'=>'Edit','description'=>'Email Event Edit','url'=>'backend_mps/eventemail/edit'],
            ['id'=>545,'module'=>'EmailEvent','name'=>'Update','description'=>'Email Event Update','url'=>'backend_mps/eventemail/update'],
            ['id'=>546,'module'=>'EmailEvent','name'=>'Destroy','description'=>'Email Event Destroy','url'=>'backend_mps/eventemail/destroy'],

            ['id'=>550,'module'=>'EmailTemplate','name'=>'Edit','description'=>'Booking Cancel Email Template Edit','url'=>'backend_mps/email_template_booking_cancel'],
            ['id'=>551,'module'=>'EmailTemplate','name'=>'Update','description'=>'Booking Email Template Update','url'=>'backend_mps/email_template_booking_cancel/update'],
            ['id'=>552,'module'=>'EmailTemplate','name'=>'Edit','description'=>'Bookin Confirm Email Template Edit','url'=>'backend_mps/email_template_booking_confirm'],
            ['id'=>553,'module'=>'EmailTemplate','name'=>'Update','description'=>'Bookin Confirm Email Template Update','url'=>'backend_mps/email_template_booking_confirm/update'],
            ['id'=>554,'module'=>'EmailTemplate','name'=>'Edit','description'=>'Bookin Edit Email Template Edit','url'=>'backend_mps/email_template_booking_edit'],
            ['id'=>555,'module'=>'EmailTemplate','name'=>'Update','description'=>'Bookin Edit Email Template Update','url'=>'backend_mps/email_template_booking_edit/update'],

            ['id'=>560,'module'=>'HotelAdmin','name'=>'Dashboard','description'=>'Hotel Admin Dashboard','url'=>'backend_mps/hotel_admin/dashboard'],

            ['id'=>570,'module'=>'HotelBooking','name'=>'Listing','description'=>'Hotel Booking Listing','url'=>'backend_mps/booking'],
            ['id'=>571,'module'=>'HotelBooking','name'=>'Detail','description'=>'Hotel Booking Detail','url'=>'backend_mps/booking/{id}'],
            ['id'=>572,'module'=>'HotelBooking','name'=>'Refund','description'=>'Hotel Booking Refund','url'=>'backend_mps/booking/refund'],

            ['id'=>580,'module'=>'Communication','name'=>'Listing','description'=>'Communication Listing','url'=>'backend_mps/communication'],
            ['id'=>581,'module'=>'Communication','name'=>'Edit','description'=>'Communication Edit','url'=>'backend_mps/communication/reply/{id}'],
            ['id'=>582,'module'=>'Communication','name'=>'Store','description'=>'Communication Store','url'=>'backend_mps/communication/reply/store'],
            ['id'=>590,'module'=>'Transportation Information','name'=>'View and Store','description'=>'Transportation Information View and  Store','url'=>'backend_mps/transportation_information'],
            ['id'=>591,'module'=>'TourInformation','name'=>'View and Store','description'=>'Tour Information View and  Store','url'=>'backend_mps/tour_information'],

            //CSVImport
            ['id'=>600,'module'=>'CSVImport','name'=>'Listing','description'=>'CSVImport Listing','url'=>'backend_mps/import'],
            ['id'=>601,'module'=>'CSVImport','name'=>'Store','description'=>'CSVImport Store','url'=>'backend_mps/import/store'],

            //system_admin
            ['id'=>602,'module'=>'SystemAdmin','name'=>'Dashboard','description'=>'System Admin Dashboard','url'=>'backend_mps/system_admin/dashboard'],

            //Hotel Gallery
            ['id'=>610,'module'=>'HotelGallery','name'=>'Listing','description'=>'Hotel Gallery Listing','url'=>'backend_mps/hotel_gallery'],
            ['id'=>611,'module'=>'HotelGallery','name'=>'Create','description'=>'Hotel Gallery Create','url'=>'backend_mps/hotel_gallery/create/{hotel_id?}'],
            ['id'=>612,'module'=>'HotelGallery','name'=>'Store','description'=>'Hotel Gallery Store','url'=>'backend_mps/hotel_gallery/store'],
            ['id'=>613,'module'=>'HotelGallery','name'=>'Edit','description'=>'Hotel Gallery Edit','url'=>'backend_mps/hotel_gallery/edit'],
            ['id'=>614,'module'=>'HotelGallery','name'=>'Update','description'=>'Hotel Gallery Update','url'=>'backend_mps/hotel_gallery/update'],
            ['id'=>615,'module'=>'HotelGallery','name'=>'Destroy','description'=>'Hotel Gallery Destroy','url'=>'backend_mps/hotel_gallery/destroy'],
            ['id'=>616,'module'=>'HotelGallery','name'=>'Filter','description'=>'Hotel Gallery Filter','url'=>'backend_mps/hotel_gallery/{hotel_id?}'],

            //Activity Log
            ['id'=>620,'module'=>'Activity Log','name'=>'Activity Log','description'=>'Activity Log','url'=>'backend_mps/activities'],

            //Hotel Policy
            ['id'=>630,'module'=>'HotelPolicy','name'=>'Listing','description'=>'Hotel Policy Listing','url'=>'backend_mps/hotel_policy'],
            ['id'=>631,'module'=>'HotelPolicy','name'=>'Create','description'=>'Hotel Policy Create','url'=>'backend_mps/hotel_policy/create/{hotel_id?}'],
            ['id'=>632,'module'=>'HotelPolicy','name'=>'Store','description'=>'Hotel Policy Store','url'=>'backend_mps/hotel_policy/store'],
            ['id'=>633,'module'=>'HotelPolicy','name'=>'Edit','description'=>'Hotel Policy Edit','url'=>'backend_mps/hotel_policy/edit'],
            ['id'=>634,'module'=>'HotelPolicy','name'=>'Update','description'=>'Hotel Policy Update','url'=>'backend_mps/hotel_policy/update'],
            ['id'=>635,'module'=>'HotelPolicy','name'=>'Destroy','description'=>'Hotel Policy Destroy','url'=>'backend_mps/hotel_policy/destroy'],
            ['id'=>636,'module'=>'HotelPolicy','name'=>'Filter','description'=>'Hotel Policy Filter','url'=>'backend_mps/hotel_policy/{hotel_id?}'],

           //Visa Information
            ['id'=>640,'module'=>'VisaInformation','name'=>'View and Store','description'=>'Visa Information View and Store','url'=>'backend_mps/visa_information'],

           // Hotel Disable
            ['id'=>650,'module'=>'Hotel','name'=>'Disable','description'=>'Hotel Disable','url'=>'backend_mps/hotel/disable'],
            ['id'=>651,'module'=>'Hotel','name'=>'Disabled Hotel List','description'=>'Disabled Hotel List','url'=>'backend_mps/hotel/disabled_hotels'],
            ['id'=>652,'module'=>'Hotel','name'=>'Enable Hotel','description'=>'Hotel Enable','url'=>'backend_mps/hotel/enable'],
            ['id'=>653,'module'=>'Hotel','name'=>'Active Booking List','description'=>'Hotel active booking list','url'=>'backend_mps/hotel/active_booking_list{hotel_id}'],

            //Faq Information
             ['id'=>660,'module'=>'FaqInformation','name'=>'View and Store','description'=>'Faq Information View and Store','url'=>'backend_mps/faq_information'],

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
