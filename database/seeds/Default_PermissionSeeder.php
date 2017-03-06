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

            //Features
            ['id'=>45,'module'=>'Features','name'=>'Listing','description'=>'Features Listing','url'=>'backend/feature'],
            ['id'=>46,'module'=>'Features','name'=>'New','description'=>'Features New','url'=>'backend/feature/create'],
            ['id'=>47,'module'=>'Features','name'=>'store','description'=>'Features Store','url'=>'backend/feature/store'],
            ['id'=>48,'module'=>'Features','name'=>'Edit','description'=>'Features Edit','url'=>'backend/feature/edit'],
            ['id'=>49,'module'=>'Features','name'=>'Update','description'=>'Features Update','url'=>'backend/feature/update'],
            ['id'=>50,'module'=>'Features','name'=>'Destroy','description'=>'Features Destroy','url'=>'backend/feature/destroy'],

            //Amenities
            ['id'=>51,'module'=>'Amenities','name'=>'Listing','description'=>'Amenities Listing','url'=>'backend/amenities'],
            ['id'=>52,'module'=>'Amenities','name'=>'New','description'=>'Amenities New','url'=>'backend/amenities/create'],
            ['id'=>53,'module'=>'Amenities','name'=>'store','description'=>'Amenities Store','url'=>'backend/amenities/store'],
            ['id'=>54,'module'=>'Amenities','name'=>'Edit','description'=>'Amenities Edit','url'=>'backend/amenities/edit'],
            ['id'=>55,'module'=>'Amenities','name'=>'Update','description'=>'Amenities Update','url'=>'backend/amenities/update'],
            ['id'=>56,'module'=>'Amenities','name'=>'Destroy','description'=>'Amenities Destroy','url'=>'backend/amenities/destroy'],

            //Facilities
            ['id'=>57,'module'=>'Facilities','name'=>'Listing','description'=>'Facilities Listing','url'=>'backend/facilities'],
            ['id'=>58,'module'=>'Facilities','name'=>'New','description'=>'Facilities New','url'=>'backend/facilities/create'],
            ['id'=>59,'module'=>'Facilities','name'=>'store','description'=>'Facilities Store','url'=>'backend/facilities/store'],
            ['id'=>60,'module'=>'Facilities','name'=>'Edit','description'=>'Facilities Edit','url'=>'backend/facilities/edit'],
            ['id'=>61,'module'=>'Facilities','name'=>'Update','description'=>'Facilities Update','url'=>'backend/facilities/update'],
            ['id'=>62,'module'=>'Facilities','name'=>'Destroy','description'=>'Facilities Destroy','url'=>'backend/facilities/destroy'],

            //Hotel Restaurant Category
            ['id'=>63,'module'=>'HotelRestaurantCategory','name'=>'Listing','description'=>'HotelRestaurantCategory Listing','url'=>'backend/hotel_restaurant_category'],
            ['id'=>64,'module'=>'HotelRestaurantCategory','name'=>'New','description'=>'HotelRestaurantCategory New','url'=>'backend/hotel_restaurant_category/create'],
            ['id'=>65,'module'=>'HotelRestaurantCategory','name'=>'store','description'=>'HotelRestaurantCategory Store','url'=>'backend/hotel_restaurant_category/store'],
            ['id'=>66,'module'=>'HotelRestaurantCategory','name'=>'Edit','description'=>'HotelRestaurantCategory Edit','url'=>'backend/hotel_restaurant_category/edit'],
            ['id'=>67,'module'=>'HotelRestaurantCategory','name'=>'Update','description'=>'HotelRestaurantCategory Update','url'=>'backend/hotel_restaurant_category/update'],
            ['id'=>68,'module'=>'HotelRestaurantCategory','name'=>'Destroy','description'=>'HotelRestaurantCategory Destroy','url'=>'backend/hotel_restaurant_category/destroy'],

            //Country
            ['id'=>69,'module'=>'Country','name'=>'Listing','description'=>'Country Listing','url'=>'backend/country'],
            ['id'=>70,'module'=>'Country','name'=>'New','description'=>'Country New','url'=>'backend/country/create'],
            ['id'=>71,'module'=>'Country','name'=>'store','description'=>'Country Store','url'=>'backend/country/store'],
            ['id'=>72,'module'=>'Country','name'=>'Edit','description'=>'Country Edit','url'=>'backend/country/edit'],
            ['id'=>73,'module'=>'Country','name'=>'Update','description'=>'Country Update','url'=>'backend/country/update'],
            ['id'=>74,'module'=>'Country','name'=>'Destroy','description'=>'Country Destroy','url'=>'backend/country/destroy'],

            //Township
            ['id'=>75,'module'=>'Township','name'=>'Listing','description'=>'Township Listing','url'=>'backend/township'],
            ['id'=>76,'module'=>'Township','name'=>'New','description'=>'Township New','url'=>'backend/township/create'],
            ['id'=>77,'module'=>'Township','name'=>'store','description'=>'Township Store','url'=>'backend/township/store'],
            ['id'=>78,'module'=>'Township','name'=>'Edit','description'=>'Township Edit','url'=>'backend/township/edit'],
            ['id'=>79,'module'=>'Township','name'=>'Update','description'=>'Township Update','url'=>'backend/township/update'],
            ['id'=>80,'module'=>'Township','name'=>'Destroy','description'=>'Township Destroy','url'=>'backend/township/destroy'],

            //City
            ['id'=>81,'module'=>'City','name'=>'Listing','description'=>'City Listing','url'=>'backend/city'],
            ['id'=>82,'module'=>'City','name'=>'New','description'=>'City New','url'=>'backend/city/create'],
            ['id'=>83,'module'=>'City','name'=>'store','description'=>'City Store','url'=>'backend/city/store'],
            ['id'=>84,'module'=>'City','name'=>'Edit','description'=>'City Edit','url'=>'backend/city/edit'],
            ['id'=>85,'module'=>'City','name'=>'Update','description'=>'City Update','url'=>'backend/city/update'],
            ['id'=>86,'module'=>'City','name'=>'Destroy','description'=>'City Destroy','url'=>'backend/city/destroy'],

            //Room Category Amenities
            ['id'=>87,'module'=>'RoomCategoryAmenities','name'=>'Listing','description'=>'RoomCategoryAmenities Listing','url'=>'backend/room_category_amenities'],
            ['id'=>88,'module'=>'RoomCategoryAmenities','name'=>'New','description'=>'RoomCategoryAmenities New','url'=>'backend/room_category_amenities/create'],
            ['id'=>89,'module'=>'RoomCategoryAmenities','name'=>'store','description'=>'RoomCategoryAmenities Store','url'=>'backend/room_category_amenities/store'],
            ['id'=>90,'module'=>'RoomCategoryAmenities','name'=>'Edit','description'=>'RoomCategoryAmenities Edit','url'=>'backend/room_category_amenities/edit'],
            ['id'=>91,'module'=>'RoomCategoryAmenities','name'=>'Update','description'=>'RoomCategoryAmenities Update','url'=>'backend/room_category_amenities/update'],
            ['id'=>92,'module'=>'RoomCategoryAmenities','name'=>'Destroy','description'=>'RoomCategoryAmenities Destroy','url'=>'backend/room_category_amenities/destroy'],

            //Jquery Validation for Country and Township
            ['id'=>93,'module'=>'Country','name'=>'Jquery Validation','description'=>'Country Jquery Validation','url'=>'backend/country/check_country_name'],
            ['id'=>94,'module'=>'City','name'=>'Jquery Validation','description'=>'City Jquery Validation','url'=>'backend/city/check_city_name'],



        );

        DB::table('core_permissions')->insert($permissions);
    }
}