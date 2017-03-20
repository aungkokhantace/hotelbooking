<?php
Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'frontendorbackend'], function () {

    //Frontend
    Route::get('/', 'Frontend\HomeController@index');

    //Backend
    Route::group(['prefix' => 'backend'], function () {

    Route::get('/', 'Auth\AuthController@showLogin');
    Route::get('login', array('as'=>'backend/login','uses'=>'Auth\AuthController@showLogin'));
    Route::post('login', array('as'=>'backend/login','uses'=>'Auth\AuthController@doLogin'));
    Route::get('logout', array('as'=>'backend/logout','uses'=>'Auth\AuthController@doLogout'));
    Route::get('dashboard', array('as'=>'backend/dashboard','uses'=>'Core\DashboardController@dashboard'));
    Route::get('/errors/{errorId}', array('as'=>'backend//errors/{errorId}','uses'=>'Core\ErrorController@index'));
    Route::get('/unauthorize', array('as'=>'backend/unauthorize','uses'=>'Core\ErrorController@unauthorize'));

    // Password Reset Routes...
    Route::get('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
    Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
    Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);

    //Ajax
    Route::get('hotel_room_type/get_room_type/{id}', ['as' => 'backend/hotel_room_type/get_room_type', 'uses' => 'Setup\HotelRoomType\HotelRoomTypeController@getHotelRoomType']);
    Route::get('hotel_room_category/get_room_category/{id}', ['as' => 'backend/hotel_room_category/get_room_category', 'uses' => 'Setup\HotelRoomCategory\HotelRoomCategoryController@getHotelRoomCategory']);


    });

    Route::group(['middleware' => 'right'], function () {


        //Backend
        Route::group(['prefix' => 'backend'], function () {
            // Site Configuration
            Route::get('config', array('as'=>'backend/config','uses'=>'Core\ConfigController@edit'));
            Route::post('config', array('as'=>'backend/config','uses'=>'Core\ConfigController@update'));

            //Hotel Site Config
            Route::get('site_config', array('as'=>'backend/site_config', 'uses'=>'Setup/SiteConfig/SiteConfigController@edit'));
            Route::post('site_config', array('as'=>'backend/site_config', 'uses'=>'Setup/SiteConfig/SiteConfigController@update'));

            //User
            Route::get('user', array('as'=>'backend/user','uses'=>'Core\UserController@index'));
            Route::get('user/create', array('as'=>'backend/user/create','uses'=>'Core\UserController@create'));
            Route::post('user/store', array('as'=>'backend/user/store','uses'=>'Core\UserController@store'));
            Route::get('user/edit/{id}',  array('as'=>'backend/user/edit','uses'=>'Core\UserController@edit'));
            Route::post('user/update', array('as'=>'backend/user/update','uses'=>'Core\UserController@update'));
            Route::post('user/destroy', array('as'=>'backend/user/destroy','uses'=>'Core\UserController@destroy'));
            Route::get('user/profile/{id}', array('as'=>'backend/user/profile','uses'=>'Core\UserController@profile'));
            Route::get('userAuth', array('as'=>'backend/userAuth','uses'=>'Core\UserController@getAuthUser'));

            //Role
            Route::get('role', array('as'=>'backend/role','uses'=>'Core\RoleController@index'));
            Route::get('role/create',  array('as'=>'backend/role/create','uses'=>'Core\RoleController@create'));
            Route::post('role/store',  array('as'=>'backend/role/store','uses'=>'Core\RoleController@store'));
            Route::get('role/edit/{id}',  array('as'=>'backend/role/edit','uses'=>'Core\RoleController@edit'));
            Route::post('role/update',  array('as'=>'backend/role/update','uses'=>'Core\RoleController@update'));
            Route::post('role/destroy',  array('as'=>'backend/role/destroy','uses'=>'Core\RoleController@destroy'));
            Route::get('rolePermission/{roleId}', array('as'=>'backend/rolePermission','uses'=>'Core\RoleController@rolePermission'));
            Route::post('rolePermissionAssign/{id}',   array('as'=>'backend/rolePermissionAssign','uses'=>'Core\RoleController@rolePermissionAssign'));

            //Permission
            Route::get('permission', array('as'=>'backend/permission','uses'=>'Core\PermissionController@index'));
            Route::get('permission/create', array('as'=>'backend/permission/create','uses'=>'Core\PermissionController@create'));
            Route::post('permission/store', array('as'=>'backend/permission/store','uses'=>'Core\PermissionController@store'));
            Route::get('permission/edit/{id}', array('as'=>'backend/permission/edit','uses'=>'Core\PermissionController@edit'));
            Route::post('permission/update', array('as'=>'backend/permission/update','uses'=>'Core\PermissionController@update'));
            Route::post('permission/destroy', array('as'=>'backend/permission/destroy','uses'=>'Core\PermissionController@destroy'));

            //Country
            Route::get('country', array('as'=>'backend/country','uses'=>'Setup\Country\CountryController@index'));
            Route::get('country/create',array('as'=>'backend/country/create','uses'=>'Setup\Country\CountryController@create'));
            Route::post('country/store', array('as'=>'backend/country/store','uses'=>'Setup\Country\CountryController@store'));
            Route::get('country/edit/{id}', array('as'=>'backend/country/edit','uses'=>'Setup\Country\CountryController@edit'));
            Route::post('country/update', array('as'=>'backend/country/update','uses'=>'Setup\Country\CountryController@update'));
            Route::post('country/destroy', array('as'=>'backend/country/destroy','uses'=>'Setup\Country\CountryController@destroy'));
            Route::get('country/check_country_name',array('as'=>'backend/country/check_country_name','uses'=>'Setup\Country\CountryController@check_country_name'));

            //Township
            Route::get('township',array('as'=>'backend/township','uses'=>'Setup\Township\TownshipController@index'));
            Route::get('township/create', array('as'=>'backend/township/create', 'uses'=>'Setup\Township\TownshipController@create'));
            Route::post('township/store', array('as'=>'backend/township/store', 'uses'=>'Setup\Township\TownshipController@store'));
            Route::get('township/edit/{id}', array('as'=>'backend/township/edit', 'uses'=>'Setup\Township\TownshipController@edit'));
            Route::post('township/update', array('as'=>'backend/township/update', 'uses'=>'Setup\Township\TownshipController@update'));
            Route::post('township/destroy', array('as'=>'backend/township/destroy', 'uses'=>'Setup\Township\TownshipController@destroy'));
            Route::get('township/check_township_name', array('as'=>'backend/township/check_township_name', 'uses'=>'Setup\Township\TownshipController@check_township_name'));

            //City
            Route::get('city', array('as'=>'backend/city', 'uses'=>'Setup\City\CityController@index'));
            Route::get('city/create', array('as'=>'backend/create','uses'=>'Setup\City\CityController@create'));
            Route::post('city/store', array('as'=>'backend/store', 'uses'=>'Setup\City\CityController@store'));
            Route::get('city/edit/{id}', array('as'=>'backend/city/edit', 'uses'=>'Setup\City\CityController@edit'));
            Route::post('city/update', array('as'=>'backend/city/update', 'uses'=>'Setup\City\CityController@update'));
            Route::post('city/destroy', array('as'=>'backend/city/destroy', 'uses'=>'Setup\City\CityController@destroy'));
            Route::get('city/check_city_name',array('as'=>'backend/city/check_city_name','uses'=>'Setup\City\CityController@check_city_name'));

            //Feature
            Route::get('feature', array('as'=>'backend/feature', 'uses'=>'Setup\Feature\FeatureController@index'));
            Route::get('feature/create', array('as'=>'backend/feature/create', 'uses'=>'Setup\Feature\FeatureController@create'));
            Route::post('feature/store', array('as'=>'backend/feature/store', 'uses'=>'Setup\Feature\FeatureController@store'));
            Route::get('feature/edit/{id}', array('as'=>'backend/feature/edit', 'uses'=>'Setup\Feature\FeatureController@edit'));
            Route::post('feature/update', array('as'=>'backend/feature/update', 'uses'=>'Setup\Feature\FeatureController@update'));
            Route::post('feature/destroy', array('as'=>'backend/feature/destroy', 'uses'=>'Setup\Feature\FeatureController@destroy'));

            //Amenities
            Route::get('amenities', array('as'=>'backend/amenities', 'uses'=>'Setup\Amenities\AmenitiesController@index'));
            Route::get('amenities/create', array('as'=>'backend/amenities/create', 'uses'=>'Setup\Amenities\AmenitiesController@create'));
            Route::post('amenities/store', array('as'=>'backend/amenities/store', 'uses'=>'Setup\Amenities\AmenitiesController@store'));
            Route::get('amenities/edit/{id}', array('as'=>'backend/amenities/edit', 'uses'=>'Setup\Amenities\AmenitiesController@edit'));
            Route::post('amenities/update', array('as'=>'backend/amenities/update', 'uses'=>'Setup\Amenities\AmenitiesController@update'));
            Route::post('amenities/destroy', array('as'=>'backend/amenities/destroy', 'uses'=>'Setup\Amenities\AmenitiesController@destroy'));

            //Facilities
            Route::get('facilities', array('as'=>'backend/facilities', 'uses'=>'Setup\Facilities\FacilitiesController@index'));
            Route::get('facilities/create', array('as'=>'backend/facilities/create', 'uses'=>'Setup\Facilities\FacilitiesController@create'));
            Route::post('facilities/store', array('as'=>'backend/facilities/store', 'uses'=>'Setup\Facilities\FacilitiesController@store'));
            Route::get('facilities/edit/{id}', array('as'=>'backend/facilities/edit', 'uses'=>'Setup\Facilities\FacilitiesController@edit'));
            Route::post('facilities/update', array('as'=>'backend/facilities/update', 'uses'=>'Setup\Facilities\FacilitiesController@update'));
            Route::post('facilities/destroy', array('as'=>'backend/facilities/destroy', 'uses'=>'Setup\Facilities\FacilitiesController@destroy'));

            //Hotel Restaurant Category
            Route::get('hotel_restaurant_category', array('as'=>'backend/hotel_restaurant_category', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index'));
            Route::get('hotel_restaurant_category/create', array('as'=>'backend/hotel_restaurant_category/create', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@create'));
            Route::post('hotel_restaurant_category/store', array('as'=>'backend/hotel_restaurant_category/store', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@store'));
            Route::get('hotel_restaurant_category/edit/{id}', array('as'=>'backend/hotel_restaurant_category/edit', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@edit'));
            Route::post('hotel_restaurant_category/update', array('as'=>'backend/hotel_restaurant_category/update', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@update'));
            Route::post('hotel_restaurant_category/destroy', array('as'=>'backend/hotel_restaurant_category/destroy', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@destroy'));

            //Room View
            Route::get('room_view', array('as'=>'backend/room_view', 'uses'=>'Setup\RoomView\RoomViewController@index'));
            Route::get('room_view/create', array('as'=>'backend/room_view/create', 'uses'=>'Setup\RoomView\RoomViewController@create'));
            Route::post('room_view/store', array('as'=>'backend/room_view/store', 'uses'=>'Setup\RoomView\RoomViewController@store'));
            Route::get('room_view/edit/{id}', array('as'=>'backend/room_view/edit', 'uses'=>'Setup\RoomView\RoomViewController@edit'));
            Route::post('room_view/update', array('as'=>'backend/room_view/update', 'uses'=>'Setup\RoomView\RoomViewController@update'));
            Route::post('room_view/destroy', array('as'=>'backend/room_view/destroy', 'uses'=>'Setup\RoomView\RoomViewController@destroy'));

            //Hotels
            Route::get('hotel', array('as'=>'backend/hotel', 'uses'=>'Setup\Hotel\HotelController@index'));
            Route::get('hotel/create', array('as'=>'backend/hotel/create', 'uses'=>'Setup\Hotel\HotelController@create'));
            Route::post('hotel/store', array('as'=>'backend/hotel/store', 'uses'=>'Setup\Hotel\HotelController@store'));
            Route::get('hotel/edit/{id}', array('as'=>'backend/hotel/edit', 'uses'=>'Setup\Hotel\HotelController@edit'));
            Route::post('hotel/update', array('as'=>'backend/hotel/update', 'uses'=>'Setup\Hotel\HotelController@update'));
            Route::post('hotel/destroy', array('as'=>'backend/hotel/destroy', 'uses'=>'Setup\Hotel\HotelController@destroy'));

            //Hotel Room Type
            Route::get('hotel_room_type', array('as'=>'backend/hotel_room_type', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@index'));
            Route::get('hotel_room_type/create', array('as'=>'backend/hotel_room_type/create', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@create'));
            Route::post('hotel_room_type/store', array('as'=>'backend/hotel_room_type/store', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@store'));
            Route::get('hotel_room_type/edit/{id}', array('as'=>'backend/hotel_room_type/edit', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@edit'));
            Route::post('hotel_room_type/update', array('as'=>'backend/hotel_room_type/update', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@update'));
            Route::post('hotel_room_type/destroy', array('as'=>'backend/hotel_room_type/destroy', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@destroy'));

            //Hotel Room Category
            Route::get('hotel_room_category', array('as'=>'backend/hotel_room_category', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@index'));
            Route::get('hotel_room_category/create', array('as'=>'backend/hotel_room_category/create', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@create'));
            Route::post('hotel_room_category/store', array('as'=>'backend/hotel_room_category/store', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@store'));
            Route::get('hotel_room_category/edit/{id}', array('as'=>'backend/hotel_room_category/edit', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@edit'));
            Route::post('hotel_room_category/update', array('as'=>'backend/hotel_room_category/update', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@update'));
            Route::post('hotel_room_category/destroy', array('as'=>'backend/hotel_room_category/destroy', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@destroy'));

            //Room
            Route::get('room', array('as'=>'backend/room', 'uses'=>'Setup\Room\RoomController@index'));
            Route::get('room/create', array('as'=>'backend/room/create', 'uses'=>'Setup\Room\RoomController@create'));
            Route::post('room/store', array('as'=>'backend/room/store', 'uses'=>'Setup\Room\RoomController@store'));
            Route::get('room/edit/{id}', array('as'=>'backend/room/edit', 'uses'=>'Setup\Room\RoomController@edit'));
            Route::post('room/update', array('as'=>'backend/room/update', 'uses'=>'Setup\Room\RoomController@update'));
            Route::post('room/destroy', array('as'=>'backend/room/destroy', 'uses'=>'Setup\Room\RoomController@destroy'));

            //Room Category Facility
            Route::get('room_category_facility', array('as'=>'backend/room_category_facility', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@index'));
            Route::get('room_category_facility/create', array('as'=>'backend/room_category_facility/create', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@create'));
            Route::post('room_category_facility/store', array('as'=>'backend/room_category_facility/store', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@store'));
            Route::get('room_category_facility/edit/{id}', array('as'=>'backend/room_category_facility/edit', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@edit'));
            Route::post('room_category_facility/update', array('as'=>'backend/room_category_facility/update', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@update'));
            Route::post('room_category_facility/destroy', array('as'=>'backend/room_category_facility/destroy', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@destroy'));

            //Hotel Feature
            Route::get('hotel_feature', array('as'=>'backend/hotel_feature', 'uses'=>'Setup\HotelFeature\HotelFeatureController@index'));
            Route::get('hotel_feature/create', array('as'=>'backend/hotel_feature/create', 'uses'=>'Setup\HotelFeature\HotelFeatureController@create'));
            Route::post('hotel_feature/store', array('as'=>'backend/hotel_feature/store', 'uses'=>'Setup\HotelFeature\HotelFeatureController@store'));
            Route::get('hotel_feature/edit/{id}', array('as'=>'backend/hotel_feature/edit', 'uses'=>'Setup\HotelFeature\HotelFeatureController@edit'));
            Route::post('hotel_feature/update', array('as'=>'backend/hotel_feature/update', 'uses'=>'Setup\HotelFeature\HotelFeatureController@update'));
            Route::post('hotel_feature/destroy', array('as'=>'backend/hotel_feature/destroy', 'uses'=>'Setup\HotelFeature\HotelFeatureController@destroy'));
        });

    });

    });



});


 Route::group(['prefix' => 'api'], function () {
        
        Route::post('activate', array('as'=>'activate','uses'=>'ApiController@Activate'));
        Route::post('check', array('as'=>'check','uses'=>'ApiController@check'));
    });