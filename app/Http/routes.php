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

            //Amendities
            Route::get('amendities', array('as'=>'backend/amendities', 'uses'=>'Setup\Amendities\AmenditiesController@index'));
            Route::get('amendities/create', array('as'=>'backend/amendities/create', 'uses'=>'Setup\Amendities\AmenditiesController@create'));
            Route::post('amendities/store', array('as'=>'backend/amendities/store', 'uses'=>'Setup\Amendities\AmenditiesController@store'));
            Route::get('amendities/edit/{id}', array('as'=>'backend/amendities/edit', 'uses'=>'Setup\Amendities\AmenditiesController@edit'));
            Route::post('amendities/update', array('as'=>'backend/amendities/update', 'uses'=>'Setup\Amendities\AmenditiesController@update'));
            Route::post('amendities/destroy', array('as'=>'backend/amendities/destroy', 'uses'=>'Setup\Amendities\AmenditiesController@destroy'));

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


        });

    });

    });



});


 Route::group(['prefix' => 'api'], function () {
        
        Route::post('activate', array('as'=>'activate','uses'=>'ApiController@Activate'));
        Route::post('check', array('as'=>'check','uses'=>'ApiController@check'));
    });