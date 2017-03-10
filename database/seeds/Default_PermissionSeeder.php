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
        DB::table('core_permissions')->delete();

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

            // Users
            ['id'=>9,'module'=>'User','name'=>'Listing','description'=>'User Listing','url'=>'backend/user'],
            ['id'=>10,'module'=>'User','name'=>'New','description'=>'User New','url'=>'backend/user/create'],
            ['id'=>11,'module'=>'User','name'=>'Store','description'=>'User Store','url'=>'backend/user/store'],
            ['id'=>12,'module'=>'User','name'=>'Edit','description'=>'User Edit','url'=>'backend/user/edit'],
            ['id'=>13,'module'=>'User','name'=>'Update','description'=>'User Update','url'=>'backend/user/update'],
            ['id'=>14,'module'=>'User','name'=>'Destroy','description'=>'User Destroy','url'=>'backend/user/destroy'],
            ['id'=>15,'module'=>'User','name'=>'Auth','description'=>'Getting Auth User','url'=>'backend/userAuth'],
            ['id'=>16,'module'=>'User','name'=>'Profile','description'=>'User Profile','url'=>'backend/user/profile'],

            // Permissions
            ['id'=>17,'module'=>'Permission','name'=>'Listing','description'=>'Permission Listing','url'=>'backend/permission'],
            ['id'=>18,'module'=>'Permission','name'=>'New','description'=>'Permission New','url'=>'backend/permission/create'],
            ['id'=>19,'module'=>'Permission','name'=>'Store','description'=>'Permission Store','url'=>'backend/permission/store'],
            ['id'=>20,'module'=>'Permission','name'=>'Edit','description'=>'Permission Edit','url'=>'backend/permission/edit'],
            ['id'=>21,'module'=>'Permission','name'=>'Update','description'=>'Permission Update','url'=>'backend/permission/update'],
            ['id'=>22,'module'=>'Permission','name'=>'Destroy','description'=>'Permission Destroy','url'=>'backend/permission/destroy'],

            // Configs
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

            //Site Config
            ['id'=>44,'module'=>'Backend','name'=>'View','description'=>'Editing','url'=>'backend/site_config'],

            //Country
            ['id'=>50,'module'=>'Country','name'=>'Listing','description'=>'Country Listing','url'=>'backend/country'],
            ['id'=>51,'module'=>'Country','name'=>'New','description'=>'Country New','url'=>'backend/country/create'],
            ['id'=>52,'module'=>'Country','name'=>'store','description'=>'Country Store','url'=>'backend/country/store'],
            ['id'=>53,'module'=>'Country','name'=>'Edit','description'=>'Country Edit','url'=>'backend/country/edit'],
            ['id'=>54,'module'=>'Country','name'=>'Update','description'=>'Country Update','url'=>'backend/country/update'],
            ['id'=>55,'module'=>'Country','name'=>'Destroy','description'=>'Country Destroy','url'=>'backend/country/destroy'],

            //Township
            ['id'=>60,'module'=>'Township','name'=>'Listing','description'=>'Township Listing','url'=>'backend/township'],
            ['id'=>61,'module'=>'Township','name'=>'New','description'=>'Township New','url'=>'backend/township/create'],
            ['id'=>62,'module'=>'Township','name'=>'store','description'=>'Township Store','url'=>'backend/township/store'],
            ['id'=>63,'module'=>'Township','name'=>'Edit','description'=>'Township Edit','url'=>'backend/township/edit'],
            ['id'=>64,'module'=>'Township','name'=>'Update','description'=>'Township Update','url'=>'backend/township/update'],
            ['id'=>65,'module'=>'Township','name'=>'Destroy','description'=>'Township Destroy','url'=>'backend/township/destroy'],

            //City
            ['id'=>70,'module'=>'City','name'=>'Listing','description'=>'City Listing','url'=>'backend/city'],
            ['id'=>71,'module'=>'City','name'=>'New','description'=>'City New','url'=>'backend/city/create'],
            ['id'=>72,'module'=>'City','name'=>'store','description'=>'City Store','url'=>'backend/city/store'],
            ['id'=>73,'module'=>'City','name'=>'Edit','description'=>'City Edit','url'=>'backend/city/edit'],
            ['id'=>74,'module'=>'City','name'=>'Update','description'=>'City Update','url'=>'backend/city/update'],
            ['id'=>75,'module'=>'City','name'=>'Destroy','description'=>'City Destroy','url'=>'backend/city/destroy'],

            //Features
            ['id'=>80,'module'=>'Features','name'=>'Listing','description'=>'Features Listing','url'=>'backend/feature'],
            ['id'=>81,'module'=>'Features','name'=>'New','description'=>'Features New','url'=>'backend/feature/create'],
            ['id'=>82,'module'=>'Features','name'=>'store','description'=>'Features Store','url'=>'backend/feature/store'],
            ['id'=>83,'module'=>'Features','name'=>'Edit','description'=>'Features Edit','url'=>'backend/feature/edit'],
            ['id'=>84,'module'=>'Features','name'=>'Update','description'=>'Features Update','url'=>'backend/feature/update'],
            ['id'=>85,'module'=>'Features','name'=>'Destroy','description'=>'Features Destroy','url'=>'backend/feature/destroy'],

            //Amenities
            ['id'=>90,'module'=>'Amenities','name'=>'Listing','description'=>'Amenities Listing','url'=>'backend/amenities'],
            ['id'=>91,'module'=>'Amenities','name'=>'New','description'=>'Amenities New','url'=>'backend/amenities/create'],
            ['id'=>92,'module'=>'Amenities','name'=>'store','description'=>'Amenities Store','url'=>'backend/amenities/store'],
            ['id'=>93,'module'=>'Amenities','name'=>'Edit','description'=>'Amenities Edit','url'=>'backend/amenities/edit'],
            ['id'=>94,'module'=>'Amenities','name'=>'Update','description'=>'Amenities Update','url'=>'backend/amenities/update'],
            ['id'=>95,'module'=>'Amenities','name'=>'Destroy','description'=>'Amenities Destroy','url'=>'backend/amenities/destroy'],

            //Facilities
            ['id'=>100,'module'=>'Facilities','name'=>'Listing','description'=>'Facilities Listing','url'=>'backend/facilities'],
            ['id'=>101,'module'=>'Facilities','name'=>'New','description'=>'Facilities New','url'=>'backend/facilities/create'],
            ['id'=>102,'module'=>'Facilities','name'=>'store','description'=>'Facilities Store','url'=>'backend/facilities/store'],
            ['id'=>103,'module'=>'Facilities','name'=>'Edit','description'=>'Facilities Edit','url'=>'backend/facilities/edit'],
            ['id'=>104,'module'=>'Facilities','name'=>'Update','description'=>'Facilities Update','url'=>'backend/facilities/update'],
            ['id'=>105,'module'=>'Facilities','name'=>'Destroy','description'=>'Facilities Destroy','url'=>'backend/facilities/destroy'],

            //Hotel Restaurant Category
            ['id'=>110,'module'=>'HotelRestaurantCategory','name'=>'Listing','description'=>'HotelRestaurantCategory Listing','url'=>'backend/hotel_restaurant_category'],
            ['id'=>111,'module'=>'HotelRestaurantCategory','name'=>'New','description'=>'HotelRestaurantCategory New','url'=>'backend/hotel_restaurant_category/create'],
            ['id'=>112,'module'=>'HotelRestaurantCategory','name'=>'store','description'=>'HotelRestaurantCategory Store','url'=>'backend/hotel_restaurant_category/store'],
            ['id'=>113,'module'=>'HotelRestaurantCategory','name'=>'Edit','description'=>'HotelRestaurantCategory Edit','url'=>'backend/hotel_restaurant_category/edit'],
            ['id'=>114,'module'=>'HotelRestaurantCategory','name'=>'Update','description'=>'HotelRestaurantCategory Update','url'=>'backend/hotel_restaurant_category/update'],
            ['id'=>115,'module'=>'HotelRestaurantCategory','name'=>'Destroy','description'=>'HotelRestaurantCategory Destroy','url'=>'backend/hotel_restaurant_category/destroy'],

            //Room Category Amenities
            ['id'=>120,'module'=>'RoomCategoryAmenities','name'=>'Listing','description'=>'RoomCategoryAmenities Listing','url'=>'backend/room_category_amenities'],
            ['id'=>121,'module'=>'RoomCategoryAmenities','name'=>'New','description'=>'RoomCategoryAmenities New','url'=>'backend/room_category_amenities/create'],
            ['id'=>122,'module'=>'RoomCategoryAmenities','name'=>'store','description'=>'RoomCategoryAmenities Store','url'=>'backend/room_category_amenities/store'],
            ['id'=>123,'module'=>'RoomCategoryAmenities','name'=>'Edit','description'=>'RoomCategoryAmenities Edit','url'=>'backend/room_category_amenities/edit'],
            ['id'=>124,'module'=>'RoomCategoryAmenities','name'=>'Update','description'=>'RoomCategoryAmenities Update','url'=>'backend/room_category_amenities/update'],
            ['id'=>125,'module'=>'RoomCategoryAmenities','name'=>'Destroy','description'=>'RoomCategoryAmenities Destroy','url'=>'backend/room_category_amenities/destroy'],

            //Jquery Validation for Country and Township
            ['id'=>130,'module'=>'Country','name'=>'Jquery Validation','description'=>'Country Jquery Validation','url'=>'backend/country/check_country_name'],
            ['id'=>131,'module'=>'City','name'=>'Jquery Validation','description'=>'City Jquery Validation','url'=>'backend/city/check_city_name'],

            //Room View
            ['id'=>140,'module'=>'Room View','name'=>'Listing','description'=>'Room View Listing','url'=>'backend/room_view'],
            ['id'=>141,'module'=>'Room View','name'=>'New','description'=>'Room View New','url'=>'backend/room_view/create'],
            ['id'=>142,'module'=>'Room View','name'=>'store','description'=>'Room View Store','url'=>'backend/room_view/store'],
            ['id'=>143,'module'=>'Room View','name'=>'Edit','description'=>'Room View Edit','url'=>'backend/room_view/edit'],
            ['id'=>144,'module'=>'Room View','name'=>'Update','description'=>'Room View Update','url'=>'backend/room_view/update'],
            ['id'=>145,'module'=>'Room View','name'=>'Destroy','description'=>'Room View Destroy','url'=>'backend/room_view/destroy'],

            //Hotel
            ['id'=>150,'module'=>'Hotel','name'=>'Listing','description'=>'Hotel Listing','url'=>'backend/hotel'],
            ['id'=>151,'module'=>'Hotel','name'=>'New','description'=>'Hotel New','url'=>'backend/hotel/create'],
            ['id'=>152,'module'=>'Hotel','name'=>'store','description'=>'Hotel Store','url'=>'backend/hotel/store'],
            ['id'=>153,'module'=>'Hotel','name'=>'Edit','description'=>'Hotel Edit','url'=>'backend/hotel/edit'],
            ['id'=>154,'module'=>'Hotel','name'=>'Update','description'=>'Hotel Update','url'=>'backend/hotel/update'],
            ['id'=>155,'module'=>'Hotel','name'=>'Destroy','description'=>'Hotel Destroy','url'=>'backend/hotel/destroy'],

            //Hotel Room Type
            ['id'=>160,'module'=>'HotelRoomType','name'=>'Listing','description'=>'Hotel Room Type Listing','url'=>'backend/hotel_room_type'],
            ['id'=>161,'module'=>'HotelRoomType','name'=>'New','description'=>'Hotel Room Type New','url'=>'backend/hotel_room_type/create'],
            ['id'=>162,'module'=>'HotelRoomType','name'=>'store','description'=>'Hotel Room Type Store','url'=>'backend/hotel_room_type/store'],
            ['id'=>163,'module'=>'HotelRoomType','name'=>'Edit','description'=>'Hotel Room Type Edit','url'=>'backend/hotel_room_type/edit'],
            ['id'=>164,'module'=>'HotelRoomType','name'=>'Update','description'=>'Hotel Room Type Update','url'=>'backend/hotel_room_type/update'],
            ['id'=>165,'module'=>'HotelRoomType','name'=>'Destroy','description'=>'Hotel Room Type Destroy','url'=>'backend/hotel_room_type/destroy'],

            //Hotel Room Category
            ['id'=>170,'module'=>'HotelRoomCategory','name'=>'Listing','description'=>'Hotel Room Category Listing','url'=>'backend/hotel_room_category'],
            ['id'=>171,'module'=>'HotelRoomCategory','name'=>'New','description'=>'Hotel Room Category New','url'=>'backend/hotel_room_category/create'],
            ['id'=>172,'module'=>'HotelRoomCategory','name'=>'store','description'=>'Hotel Room Category Store','url'=>'backend/hotel_room_category/store'],
            ['id'=>173,'module'=>'HotelRoomCategory','name'=>'Edit','description'=>'Hotel Room Category Edit','url'=>'backend/hotel_room_category/edit'],
            ['id'=>174,'module'=>'HotelRoomCategory','name'=>'Update','description'=>'Hotel Room Category Update','url'=>'backend/hotel_room_category/update'],
            ['id'=>175,'module'=>'HotelRoomCategory','name'=>'Destroy','description'=>'Hotel Room Category Destroy','url'=>'backend/hotel_room_category/destroy'],
        );

        DB::table('core_permissions')->insert($permissions);
    }
}