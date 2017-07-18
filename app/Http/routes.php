<?php
Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => ['frontendorbackend','LanguageSwitcher']], function () {

    //Frontend
    Route::get('/', 'Frontend\HomeController@index');

    Route::get('/comingsoon', array('as'=>'/comingsoon','uses'=>'Frontend\HomeController@comingsoon'));

    //for autocomplete destination in search form
    Route::get('/autocompletedestination', 'Frontend\HomeController@autocompleteDestination');

    //search
    Route::post('/search', 'Frontend\SearchController@search');
    Route::get('/search_result', 'Frontend\SearchController@index');

    //hotel detail
    Route::get('/hotel_detail/{id}', 'Frontend\HotelDetailController@index');

    //about us
    Route::get('/aboutus', 'Frontend\HomeController@aboutus');

    //User(Customer Registration)
//    Route::get('register','Frontend\UserRegistrationController@create');
    Route::any('register','Frontend\UserRegistrationController@store');
    Route::get('register/check_email', ['as' => 'register/check_email', 'uses' => 'Frontend\UserRegistrationController@check_email']);
    //Authentication
//    Route::get('login','Frontend\LoginController@showLogin');
    Route::any('login','Frontend\LoginController@doLogin');
    Route::get('logout','Frontend\LoginController@logout');
    Route::get('test','Frontend\HomeController@test');
    Route::get('lang/{lang}','Language\LanguageController@getLanguage');
//    Route::get('/getlocations/{destination}', array('as'=>'/getlocations', 'uses'=>'Frontend\SearchController@getLocations'));
    Route::post('/getlocations', array('as'=>'/getlocations', 'uses'=>'Frontend\SearchController@getLocations'));
    //User Profile
    Route::get('profile',['as'=>'profile','uses'=>'Frontend\UserProfileController@showMyProfile']);
    Route::post('profile',['as'=>'profile','uses'=>'Frontend\UserProfileController@updateProfile']);
    Route::get('profile/check_email', ['as' => 'profile/check_email', 'uses' => 'Frontend\UserProfileController@check_email']);
    //Booking List
    Route::get('bookingList',['as'=>'bookingList','uses'=>'Frontend\BookingController@booking_list']);

    //Payment TESting
    Route::get('payTest',['as'=>'payTest','uses'=>'Payment\PaymentTestController@payment_for_later']);
    Route::post('pay',['as'=>'pay','uses'=>'Payment\PaymentTestController@paymentForLater_Payment']);
    Route::post('pay2',['as'=>'pay2','uses'=>'Payment\PaymentTestController@paymentForLater_Payment2']);
    Route::get('testCapture',['as'=>'testCapture','uses'=>'Payment\PaymentTestController@testCapture']);
    Route::get('testRefund',['as'=>'testRefund','uses'=>'Payment\PaymentTestController@testRefund']);
    //Cron Test
    Route::get('cronTest',['as'=>'cronTest','uses'=>'Payment\PaymentTestController@cron_test']);
    //Static Pages
    Route::get('transportations', 'Frontend\StaticPageController@transportations');
    Route::get('airtickets', 'Frontend\StaticPageController@airtickets');

    //Booking and Payment
    Route::post('/enter_details', 'Frontend\PaymentController@enterDetails');
    Route::post('/confirm_reservation', 'Frontend\PaymentController@confirmReservation');
    Route::post('/book_and_pay', 'Frontend\PaymentController@bookAndPay');
    Route::get('/congratulations', 'Frontend\PaymentController@congratulations');

    //Manage Booking
    Route::get('booking/manage/{id}',['as'=>'booking/manage','uses'=>'Frontend\BookingController@manage']);
    Route::get('booking/manage/congratulation/{id}',['as'=>'booking/manage/congratulation',
                                                     'uses'=>'Frontend\BookingController@say_congratulation']);
    Route::get('booking/manage/print/{id}',['as'=>'booking/manage/print',
                                            'uses'=>'Frontend\BookingController@print_congratulation']);
    Route::get('booking/cancel',['as'=>'booking/cancel',
                                            'uses'=>'Frontend\BookingController@cancel_booking']);
    //Backend
    Route::group(['prefix' => 'backend'], function () {

    Route::get('/', 'Auth\AuthController@showLogin');
    Route::get('login', array('as'=>'backend/login','uses'=>'Auth\AuthController@showLogin'));
    Route::post('login', array('as'=>'backend/login','uses'=>'Auth\AuthController@doLogin'));
    Route::get('logout', array('as'=>'backend/logout','uses'=>'Auth\AuthController@doLogout'));
    Route::get('dashboard', array('as'=>'backend/dashboard','uses'=>'Core\DashboardController@dashboard'));
    Route::get('/errors/{errorId}', array('as'=>'backend//errors/{errorId}','uses'=>'Core\ErrorController@index'));
    Route::get('/unauthorize', array('as'=>'backend/unauthorize','uses'=>'Core\ErrorController@unauthorize'));

    Route::get('systemreference', array('as'=>'backend/systemreference',
            'uses'=>'Backend\SystemReferenceController@index'));

    // Password Reset Routes...
    Route::get('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
    Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
    Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);

    //Ajax
    Route::get('hotel_room_type/get_room_type/{id}', ['as' => 'backend/hotel_room_type/get_room_type', 'uses' => 'Setup\HotelRoomType\HotelRoomTypeController@getHotelRoomType']);
    Route::get('hotel_room_category/get_room_category/{id}', ['as' => 'backend/hotel_room_category/get_room_category', 'uses' => 'Setup\HotelRoomCategory\HotelRoomCategoryController@getHotelRoomCategory']);
    Route::get('room/get_room/{id}', ['as' => 'backend/room/get_room', 'uses' => 'Setup\Room\RoomController@getRoom']);
    Route::get('hotel/get_cities/{country_id}', ['as' => 'backend/hotel/get_cities', 'uses' => 'Setup\Hotel\HotelController@getCities']);
    Route::get('hotel/get_townships/{city_id}', ['as' => 'backend/hotel/get_townships', 'uses' => 'Setup\Hotel\HotelController@getTownships']);

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
            Route::get('city/create', array('as'=>'backend/city/create','uses'=>'Setup\City\CityController@create'));
            Route::post('city/store', array('as'=>'backend/city/store', 'uses'=>'Setup\City\CityController@store'));
            Route::get('city/edit/{id}', array('as'=>'backend/city/edit', 'uses'=>'Setup\City\CityController@edit'));
            Route::post('city/update', array('as'=>'backend/city/update', 'uses'=>'Setup\City\CityController@update'));
            Route::post('city/destroy', array('as'=>'backend/city/destroy', 'uses'=>'Setup\City\CityController@destroy'));
            Route::get('city/check_city_name',array('as'=>'backend/city/check_city_name','uses'=>'Setup\City\CityController@check_city_name'));

            Route::get('popular_city/create', array('as'=>'backend/popular_city/create','uses'=>'Setup\City\PopularCityController@create'));
            Route::post('popular_city/store', array('as'=>'backend/popular_city/store','uses'=>'Setup\City\PopularCityController@store'));

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

            //Hotel Nearby Category
            Route::get('nearby_category', array('as'=>'backend/nearby_category', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@index'));
            Route::get('nearby_category/create', array('as'=>'backend/nearby_category/create', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@create'));
            Route::post('nearby_category/store', array('as'=>'backend/nearby_category/store', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@store'));
            Route::get('nearby_category/edit/{id}', array('as'=>'backend/nearby_category/edit', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@edit'));
            Route::post('nearby_category/update', array('as'=>'backend/nearby_category/update', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@update'));
            Route::post('nearby_category/destroy', array('as'=>'backend/nearby_category/destroy', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@destroy'));

            //Hotel Nearby
            Route::get('hotel_nearby', array('as'=>'backend/hotel_nearby', 'uses'=>'Setup\HotelNearby\HotelNearbyController@index'));
            Route::get('hotel_nearby/create', array('as'=>'backend/hotel_nearby/create', 'uses'=>'Setup\HotelNearby\HotelNearbyController@create'));
            Route::post('hotel_nearby/store', array('as'=>'backend/hotel_nearby/store', 'uses'=>'Setup\HotelNearby\HotelNearbyController@store'));
            Route::get('hotel_nearby/edit/{id}', array('as'=>'backend/hotel_nearby/edit', 'uses'=>'Setup\HotelNearby\HotelNearbyController@edit'));
            Route::post('hotel_nearby/update', array('as'=>'backend/hotel_nearby/update', 'uses'=>'Setup\HotelNearby\HotelNearbyController@update'));
            Route::post('hotel_nearby/destroy', array('as'=>'backend/hotel_nearby/destroy', 'uses'=>'Setup\HotelNearby\HotelNearbyController@destroy'));

            //Recommended Hotels
            Route::get('recommend_hotel/create', array('as'=>'backend/recommend_hotel/create', 'uses'=>'Setup\Hotel\RecommendHotelController@create'));
            Route::post('recommend_hotel/store', array('as'=>'backend/recommend_hotel/store', 'uses'=>'Setup\Hotel\RecommendHotelController@store'));

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

            //Room Discount
            Route::get('room_discount', array('as'=>'backend/room_discount', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@index'));
            Route::get('room_discount/create', array('as'=>'backend/room_discount/create', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@create'));
            Route::post('room_discount/store', array('as'=>'backend/room_discount/store', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@store'));
            Route::get('room_discount/edit/{id}', array('as'=>'backend/room_discount/edit', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@edit'));
            Route::post('room_discount/update', array('as'=>'backend/room_discount/update', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@update'));
            Route::post('room_discount/destroy', array('as'=>'backend/room_discount/destroy', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@destroy'));

            //Room Blackout Period
            Route::get('room_blackout_period', array('as'=>'backend/room_blackout_period', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@index'));
            Route::get('room_blackout_period/create', array('as'=>'backend/room_blackout_period/create', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@create'));
            Route::post('room_blackout_period/store', array('as'=>'backend/room_blackout_period/store', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@store'));
            Route::get('room_blackout_period/edit/{id}', array('as'=>'backend/room_blackout_period/edit', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@edit'));
            Route::post('room_blackout_period/update', array('as'=>'backend/room_blackout_period/update', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@update'));
            Route::post('room_blackout_period/destroy', array('as'=>'backend/room_blackout_period/destroy', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@destroy'));

            //Room Available Period
            Route::get('room_available_period', array('as'=>'backend/room_available_period', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@index'));
            Route::get('room_available_period/create', array('as'=>'backend/room_available_period/create', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@create'));
            Route::post('room_available_period/store', array('as'=>'backend/room_available_period/store', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@store'));
            Route::get('room_available_period/edit/{id}', array('as'=>'backend/room_available_period/edit', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@edit'));
            Route::post('room_available_period/update', array('as'=>'backend/room_available_period/update', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@update'));
            Route::post('room_available_period/destroy', array('as'=>'backend/room_available_period/destroy', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@destroy'));

            //Hotel Nearby Airport
            Route::get('hotel_nearby_airport', array('as'=>'backend/hotel_nearby_airport', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@index'));
            Route::get('hotel_nearby_airport/create', array('as'=>'backend/hotel_nearby_airport/create', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@create'));
            Route::post('hotel_nearby_airport/store', array('as'=>'backend/hotel_nearby_airport/store', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@store'));
            Route::get('hotel_nearby_airport/edit/{id}', array('as'=>'backend/hotel_nearby_airport/edit', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@edit'));
            Route::post('hotel_nearby_airport/update', array('as'=>'backend/hotel_nearby_airport/update', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@update'));
            Route::post('hotel_nearby_airport/destroy', array('as'=>'backend/hotel_nearby_airport/destroy', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@destroy'));

            //Hotel Nearby Station
            Route::get('hotel_nearby_station', array('as'=>'backend/hotel_nearby_station', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@index'));
            Route::get('hotel_nearby_station/create', array('as'=>'backend/hotel_nearby_station/create', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@create'));
            Route::post('hotel_nearby_station/store', array('as'=>'backend/hotel_nearby_station/store', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@store'));
            Route::get('hotel_nearby_station/edit/{id}', array('as'=>'backend/hotel_nearby_station/edit', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@edit'));
            Route::post('hotel_nearby_station/update', array('as'=>'backend/hotel_nearby_station/update', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@update'));
            Route::post('hotel_nearby_station/destroy', array('as'=>'backend/hotel_nearby_station/destroy', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@destroy'));

            //Hotel Nearby Hospital
            Route::get('hotel_nearby_hospital', array('as'=>'backend/hotel_nearby_hospital', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@index'));
            Route::get('hotel_nearby_hospital/create', array('as'=>'backend/hotel_nearby_hospital/create', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@create'));
            Route::post('hotel_nearby_hospital/store', array('as'=>'backend/hotel_nearby_hospital/store', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@store'));
            Route::get('hotel_nearby_hospital/edit/{id}', array('as'=>'backend/hotel_nearby_hospital/edit', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@edit'));
            Route::post('hotel_nearby_hospital/update', array('as'=>'backend/hotel_nearby_hospital/update', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@update'));
            Route::post('hotel_nearby_hospital/destroy', array('as'=>'backend/hotel_nearby_hospital/destroy', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@destroy'));

            //Hotel Nearby Convenience Store
            Route::get('hotel_nearby_convenience_store', array('as'=>'backend/hotel_nearby_convenience_store', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@index'));
            Route::get('hotel_nearby_convenience_store/create', array('as'=>'backend/hotel_nearby_convenience_store/create', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@create'));
            Route::post('hotel_nearby_convenience_store/store', array('as'=>'backend/hotel_nearby_convenience_store/store', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@store'));
            Route::get('hotel_nearby_convenience_store/edit/{id}', array('as'=>'backend/hotel_nearby_convenience_store/edit', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@edit'));
            Route::post('hotel_nearby_convenience_store/update', array('as'=>'backend/hotel_nearby_convenience_store/update', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@update'));
            Route::post('hotel_nearby_convenience_store/destroy', array('as'=>'backend/hotel_nearby_convenience_store/destroy', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@destroy'));

            //Hotel Nearby Drug Store
            Route::get('hotel_nearby_drug_store', array('as'=>'backend/hotel_nearby_drug_store', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@index'));
            Route::get('hotel_nearby_drug_store/create', array('as'=>'backend/hotel_nearby_drug_store/create', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@create'));
            Route::post('hotel_nearby_drug_store/store', array('as'=>'backend/hotel_nearby_drug_store/store', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@store'));
            Route::get('hotel_nearby_drug_store/edit/{id}', array('as'=>'backend/hotel_nearby_drug_store/edit', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@edit'));
            Route::post('hotel_nearby_drug_store/update', array('as'=>'backend/hotel_nearby_drug_store/update', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@update'));
            Route::post('hotel_nearby_drug_store/destroy', array('as'=>'backend/hotel_nearby_drug_store/destroy', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@destroy'));

            /** TEST MULTI LANGUAGE */
            Route::get('test_multilanguage',['as' => 'backend/test_multilanguage', 'uses' => 'Language\LanguageController@test']);
            Route::post('language', ['as' => 'backend/language', 'uses' => 'Language\LanguageController@changeLanguage']);

            //Facility Group
            Route::get('facility_group', array('as'=>'backend/facility_group', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@index'));
            Route::get('facility_group/create', array('as'=>'backend/facility_group/create', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@create'));
            Route::post('facility_group/store', array('as'=>'backend/facility_group/store', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@store'));
            Route::get('facility_group/edit/{id}', array('as'=>'backend/facility_group/edit', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@edit'));
            Route::post('facility_group/update', array('as'=>'backend/facility_group/update', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@update'));
            Route::post('facility_group/destroy', array('as'=>'backend/facility_group/destroy', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@destroy'));

            //Hotel Restaurant
            Route::get('hotel_restaurant', array('as'=>'backend/hotel_restaurant', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@index'));
            Route::get('hotel_restaurant/create', array('as'=>'backend/hotel_restaurant/create', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@create'));
            Route::post('hotel_restaurant/store', array('as'=>'backend/hotel_restaurant/store', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@store'));
            Route::get('hotel_restaurant/edit/{id}', array('as'=>'backend/hotel_restaurant/edit', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@edit'));
            Route::post('hotel_restaurant/update', array('as'=>'backend/hotel_restaurant/update', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@update'));
            Route::post('hotel_restaurant/destroy', array('as'=>'backend/hotel_restaurant/destroy', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@destroy'));

            //Hotel Facility
            Route::get('hotel_facility', array('as'=>'backend/hotel_facility', 'uses'=>'Setup\HotelFacility\HotelFacilityController@index'));
            Route::get('hotel_facility/create', array('as'=>'backend/hotel_facility/create', 'uses'=>'Setup\HotelFacility\HotelFacilityController@create'));
            Route::post('hotel_facility/store', array('as'=>'backend/hotel_facility/store', 'uses'=>'Setup\HotelFacility\HotelFacilityController@store'));
            Route::get('hotel_facility/edit/{id}', array('as'=>'backend/hotel_facility/edit', 'uses'=>'Setup\HotelFacility\HotelFacilityController@edit'));
            Route::post('hotel_facility/update', array('as'=>'backend/hotel_facility/update', 'uses'=>'Setup\HotelFacility\HotelFacilityController@update'));
            Route::post('hotel_facility/destroy', array('as'=>'backend/hotel_facility/destroy', 'uses'=>'Setup\HotelFacility\HotelFacilityController@destroy'));

            //Landmark
            Route::get('landmark', array('as'=>'backend/landmark', 'uses'=>'Setup\Landmark\LandmarkController@index'));
            Route::get('landmark/create', array('as'=>'backend/landmark/create', 'uses'=>'Setup\Landmark\LandmarkController@create'));
            Route::post('landmark/store', array('as'=>'backend/landmark/store', 'uses'=>'Setup\Landmark\LandmarkController@store'));
            Route::get('landmark/edit/{id}', array('as'=>'backend/landmark/edit', 'uses'=>'Setup\Landmark\LandmarkController@edit'));
            Route::post('landmark/update', array('as'=>'backend/landmark/update', 'uses'=>'Setup\Landmark\LandmarkController@update'));
            Route::post('landmark/destroy', array('as'=>'backend/landmark/destroy', 'uses'=>'Setup\Landmark\LandmarkController@destroy'));

            //Hotel Landmark
            Route::get('hotel_landmark', array('as'=>'backend/hotel_landmark', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@index'));
            Route::get('hotel_landmark/create', array('as'=>'backend/hotel_landmark/create', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@create'));
            Route::post('hotel_landmark/store', array('as'=>'backend/hotel_landmark/store', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@store'));
            Route::get('hotel_landmark/edit/{id}', array('as'=>'backend/hotel_landmark/edit', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@edit'));
            Route::post('hotel_landmark/update', array('as'=>'backend/hotel_landmark/update', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@update'));
            Route::post('hotel_landmark/destroy', array('as'=>'backend/hotel_landmark/destroy', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@destroy'));

            //Room Category Amenity
            Route::get('room_category_amenity', array('as'=>'backend/room_category_amenity', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@index'));
            Route::get('room_category_amenity/create', array('as'=>'backend/room_category_amenity/create', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@create'));
            Route::post('room_category_amenity/store', array('as'=>'backend/room_category_amenity/store', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@store'));
            Route::get('room_category_amenity/edit/{id}', array('as'=>'backend/room_category_amenity/edit', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@edit'));
            Route::post('room_category_amenity/update', array('as'=>'backend/room_category_amenity/update', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@update'));
            Route::post('room_category_amenity/destroy', array('as'=>'backend/room_category_amenity/destroy', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@destroy'));

            //Slider
            Route::get('slider', array('as'=>'backend/slider', 'uses'=>'Setup\Slider\SliderController@index'));
            Route::get('slider/create', array('as'=>'backend/slider/create', 'uses'=>'Setup\Slider\SliderController@create'));
            Route::post('slider/store', array('as'=>'backend/slider/store', 'uses'=>'Setup\Slider\SliderController@store'));
            Route::post('slider/destroy', array('as'=>'backend/slider/destroy', 'uses'=>'Setup\Slider\SliderController@destroy'));

            //Hotel Config
            Route::get('hotel_config', array('as'=>'backend/hotel_config', 'uses'=>'Setup\HotelConfig\HotelConfigController@index'));
            Route::get('hotel_config/create', array('as'=>'backend/hotel_config/create', 'uses'=>'Setup\HotelConfig\HotelConfigController@create'));
            Route::post('hotel_config/store', array('as'=>'backend/hotel_config/store', 'uses'=>'Setup\HotelConfig\HotelConfigController@store'));
            Route::get('hotel_config/edit/{id}', array('as'=>'backend/hotel_config/edit', 'uses'=>'Setup\HotelConfig\HotelConfigController@edit'));
            Route::post('hotel_config/update', array('as'=>'backend/hotel_config/update', 'uses'=>'Setup\HotelConfig\HotelConfigController@update'));
            Route::post('hotel_config/destroy', array('as'=>'backend/hotel_config/destroy', 'uses'=>'Setup\HotelConfig\HotelConfigController@destroy'));

            //Page
            Route::get('page', array('as'=>'backend/page', 'uses'=>'Setup\Page\PageController@index'));
            Route::get('page/edit/{id}', array('as'=>'backend/page/edit', 'uses'=>'Setup\Page\PageController@edit'));
            Route::post('page/update', array('as'=>'backend/page/update', 'uses'=>'Setup\Page\PageController@update'));
            Route::post('page/upload', array('as'=>'backend/page/upload', 'uses'=>'Setup\Page\PageController@upload'));

            //Event Email
            Route::get('eventemail', array('as'=>'backend/eventemail', 'uses'=>'Setup\EventEmail\EventEmailController@index'));
            Route::get('eventemail/create', array('as'=>'backend/eventemail/create', 'uses'=>'Setup\EventEmail\EventEmailController@create'));
            Route::post('eventemail/store', array('as'=>'backend/eventemail/store', 'uses'=>'Setup\EventEmail\EventEmailController@store'));
            Route::get('eventemail/edit/{id}', array('as'=>'backend/eventemail/edit', 'uses'=>'Setup\EventEmail\EventEmailController@edit'));
            Route::post('eventemail/update', array('as'=>'backend/eventemail/update', 'uses'=>'Setup\EventEmail\EventEmailController@update'));
            Route::post('eventemail/destroy', array('as'=>'backend/eventemail/destroy', 'uses'=>'Setup\EventEmail\EventEmailController@destroy'));

            //Backend Email Sending
            Route::get('email_template_booking_confirm', array('as'=>'backend/email_template_booking_confirm', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@booking_confirm'));
            Route::post('email_template_booking_confirm/update', array('as'=>'backend/email_template_booking_confirm/update', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@update'));
            Route::get('email_template_booking_cancel', array('as'=>'backend/email_template_booking_cancel', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@booking_cancel'));
            Route::post('email_template_booking_cancel/update', array('as'=>'backend/email_template_booking_cancel/update', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@update'));
            Route::get('email_template_booking_edit', array('as'=>'backend/email_template_booking_edit', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@booking_edit'));
            Route::post('email_template_booking_edit/update', array('as'=>'backend/email_template_booking_edit/update', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@update'));


            //Hotel Admin Group
            Route::get('hotel_admin/dashboard', array('as'=>'backend/hotel_admin/dashboard', 'uses'=>'Setup\HotelAdmin\HotelDashboardController@dashboard'));

            //Hotel Booking
            Route::get('booking', array('as'=>'backend/booking', 'uses'=>'Setup\HotelBooking\HotelBookingController@index'));
            Route::get('booking/{id}', array('as'=>'backend/booking/{id}', 'uses'=>'Setup\HotelBooking\HotelBookingController@detail'));

            //SaleSummary Report
            Route::get('salesummaryreport',array(
                'as'=>'backend/salesummaryreport',
                'uses'=>'Report\SaleSummaryReportController@index'
            ));
            Route::get('salesummaryreport/search/{type?}/{from?}/{to?}',
                array(
                    'as'=>'backend/salesummaryreport/search/{type?}/{from?}/{to?}',
                    'uses'=>'Report\SaleSummaryReportController@search'
                ));
            Route::get('salesummaryreport/exportexcel/{type?}/{from?}/{to?}',
                array(
                    'as'=>'backend/salesummaryreport/exportexcel/{type?}/{from?}/{to?}',
                    'uses'=>'Report\SaleSummaryReportController@excel'
                ));

            //Booking Report
            Route::get('bookingreport',array(
                'as'=>'backend/bookingreport',
                'uses'=>'Report\BookingReportController@index'
            ));
            Route::get('bookingreport/search/{type?}/{from?}/{to?}/{status?}',
                array(
                    'as'=>'backend/bookingreport/search/{type?}/{from?}/{to?}/{status?}',
                    'uses'=>'Report\BookingReportController@search'
                ));
            Route::get('bookingreport/exportexcel/{type?}/{from?}/{to?}/{status?}',
                array(
                    'as'=>'backend/bookingreport/exportexcel/{type?}/{from?}/{to?}/{status?}',
                    'uses'=>'Report\BookingReportController@excel'
                ));
            Route::get('bookingreport/room_detail/{id}',array(
                'as'=>'backend/bookingreport/room_detail/{id}',
                'uses'=>'Report\BookingReportController@booking_room_detail'
            ));


        });

    });

    });



});


 Route::group(['prefix' => 'api'], function () {

        Route::post('activate', array('as'=>'activate','uses'=>'ApiController@Activate'));
        Route::post('check', array('as'=>'check','uses'=>'ApiController@check'));
    });

// Samples For Developers
//Google Map Api
Route::get('samples/googlemap', array('as'=>'samples/googlemap', 'uses'=>'Sample\SamplesController@index'));
Route::get('samples/getlocations', array('as'=>'samples/getlocations', 'uses'=>'Sample\SamplesController@getLocations'));