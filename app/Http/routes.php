<?php
Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => ['frontendorbackend','LanguageSwitcher']], function () {

    Route::group(['middleware' => 'checksession'], function () {
        //search
        Route::post('/search', 'Frontend\SearchController@search');
        Route::get('search','Frontend\SearchController@search');
        Route::get('/search_result', 'Frontend\SearchController@index');

        //hotel detail
        Route::get('/hotel_detail/{id}', 'Frontend\HotelDetailController@index');

        //Booking and Payment
        Route::post('/enter_details', 'Frontend\PaymentController@enterDetails');
        Route::get('enter_details', 'Frontend\PaymentController@enterDetails');
        Route::post('/confirm_reservation', 'Frontend\PaymentController@confirmReservation');
        Route::get('confirm_reservation', 'Frontend\PaymentController@confirmReservation');
        Route::post('/book_and_pay', 'Frontend\PaymentController@bookAndPay');
        Route::get('/congratulations/{booking_id}', 'Frontend\PaymentController@congratulations');
    });
    //Frontend
    Route::get('/', 'Frontend\HomeController@index');

    Route::get('/comingsoon', array('as'=>'/comingsoon','uses'=>'Frontend\HomeController@comingsoon'));
    //about us
    Route::get('/aboutus', 'Frontend\HomeController@aboutus');

    //for autocomplete destination in search form
    Route::get('/autocompletedestination', 'Frontend\HomeController@autocompleteDestination');

    //User(Customer Registration)
//    Route::get('register','Frontend\UserRegistrationController@create');
    Route::any('register','Frontend\UserRegistrationController@store');
    Route::get('register/check_email', ['as' => 'register/check_email', 'uses' => 'Frontend\UserRegistrationController@check_email']);
    Route::get('register/verify/{confirmationCode}','Frontend\UserRegistrationController@verify');
    //Authentication
//    Route::get('login','Frontend\LogianController@showLogin');
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
    /*
    Route::post('/enter_details', 'Frontend\PaymentController@enterDetails');
    Route::get('enter_details', 'Frontend\PaymentController@enterDetails');
    Route::post('/confirm_reservation', 'Frontend\PaymentController@confirmReservation');
    Route::get('confirm_reservation', 'Frontend\PaymentController@confirmReservation');
    Route::post('/book_and_pay', 'Frontend\PaymentController@bookAndPay');
    Route::get('/congratulations/{booking_id}', 'Frontend\PaymentController@congratulations');*/

    //get directions (google map) for hotel
    Route::get('/get_directions/{hotel_id}', 'Frontend\PaymentController@getDirections');

    //Manage Booking
    Route::get('booking/manage/{id}',['as'=>'booking/manage','uses'=>'Frontend\BookingController@manage'])->where('id','[0-9]+');
    Route::get('booking/manage/congratulation/{id}',['as'=>'booking/manage/congratulation',
                                                     'uses'=>'Frontend\BookingController@say_congratulation']);
    Route::get('booking/manage/print/{id}',['as'=>'booking/manage/print',
                                            'uses'=>'Frontend\BookingController@print_congratulation']);
    Route::get('booking/test/{id}',['as'=>'booking/test','uses'=>'Frontend\BookingController@test_cancel']);
    Route::post('booking/cancel',['as'=>'booking/cancel', 'uses'=>'Frontend\BookingController@cancel_booking']);
    Route::get('booking/cancel/show/{id}',['as'=>'booking/cancel/show','uses'=>'Frontend\BookingController@show_cancellation']);
    Route::post('booking/room/edit',['as'=>'booking/room/edit','uses'=>'Frontend\BookingController@edit_room']);
    Route::post('booking/communication',['as'=>'booking/communication','uses'=>'Frontend\BookingController@communication']);
    Route::post('booking/change_date',['as'=>'booking/change_date','uses'=>'Frontend\BookingController@change_date']);
    Route::get('booking/room/cancel/{b_id}/{r_id}',['as'=>'booking/room/cancel','uses'=>'Frontend\BookingController@cancel_room']);

    //Display Transportation Information
    Route::get('transportation_information', array('as'=>'/transportation_information', 'uses'=>'Frontend\TransportationInformationController@index'));

    //Display Guide Information
    Route::get('guide_information', array('as'=>'/guide_information', 'uses'=>'Frontend\GuideInformationController@index'));

    //Display About Us Information
    Route::get('about_us', array('as'=>'/about_us', 'uses'=>'Frontend\AboutUsController@index'));

    //Display Contact Us Information
    Route::get('contact_us', array('as'=>'/contact_us', 'uses'=>'Frontend\ContactUsController@index'));

    //Display Tour Information
    Route::get('tour_information', array('as'=>'/tour_information', 'uses'=>'Frontend\TourInformationController@index'));
    //Display VISA Information
    Route::get('visa_information',array('as'=>'/visa_information','uses'=>'Frontend\VisaInformationController@index'));
    //Display FAQ Information
    Route::get('faq_information',array('as'=>'/faq_information','uses'=>'Frontend\FaqInformationController@index'));
    //Email function test
    Route::get('/email_test', 'Payment\PaymentTestController@emailTest');
   //Fronted Language
    Route::get('lang/{lang}','FrontendLanguage\FrontendLanguageController@getLanguage');
    Route::post('frontend/language', ['as' => 'frontend/language', 'uses' => 'FrontendLanguage\FrontendLanguageController@changeLanguage']);

     // Ajax for hotel search result page view hotel policy
    Route::get('view/hotelpolicy/{id}',['as'=>'view/hotelpolicy','uses'=>'Frontend\SearchController@gethotelpolicy']);

    // Password Reset Routes...
    Route::get('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
    Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
    Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);

    //Backend
    // Route::get('backend_myanmarpolestar', 'Auth\AuthController@showLogin');
    Route::group(['prefix' => 'backend_mps'], function () {

    Route::get('/', 'Auth\AuthController@show_first_login');
    // Route::post('first_login', 'Auth\AuthController@dofirstLogin');
    Route::post('first_login', array('as'=>'backend_mps/first_login','uses'=>'Auth\AuthController@dofirstLogin'));
    // Route::get('/', 'Auth\AuthController@showLogin');
    Route::get('login', array('as'=>'backend_mps/login','uses'=>'Auth\AuthController@showLogin'));
    Route::post('login', array('as'=>'backend_mps/login','uses'=>'Auth\AuthController@doLogin'));
    Route::get('logout', array('as'=>'backend_mps/logout','uses'=>'Auth\AuthController@doLogout'));
    Route::get('dashboard', array('as'=>'backend_mps/dashboard','uses'=>'Core\DashboardController@dashboard'));
    Route::get('/errors/{errorId}', array('as'=>'backend_mps//errors/{errorId}','uses'=>'Core\ErrorController@index'));
    Route::get('/unauthorize', array('as'=>'backend_mps/unauthorize','uses'=>'Core\ErrorController@unauthorize'));

    Route::get('systemreference', array('as'=>'backend_mps/systemreference',
            'uses'=>'Backend\SystemReferenceController@index'));


    //Ajax
    Route::get('hotel_room_type/get_room_type/{id}', ['as' => 'backend_mps/hotel_room_type/get_room_type', 'uses' => 'Setup\HotelRoomType\HotelRoomTypeController@getHotelRoomType']);
    Route::get('hotel_room_category/get_room_category/{id}', ['as' => 'backend_mps/hotel_room_category/get_room_category', 'uses' => 'Setup\HotelRoomCategory\HotelRoomCategoryController@getHotelRoomCategory']);
    Route::get('room/get_room/{id}', ['as' => 'backend_mps/room/get_room', 'uses' => 'Setup\Room\RoomController@getRoom']);
    Route::get('hotel/get_cities/{country_id}', ['as' => 'backend_mps/hotel/get_cities', 'uses' => 'Setup\Hotel\HotelController@getCities']);
    Route::get('hotel/get_townships/{city_id}', ['as' => 'backend_mps/hotel/get_townships', 'uses' => 'Setup\Hotel\HotelController@getTownships']);
    // Route::get('hotel/check_user_email/{hotel_id}', ['as' => 'backend_mps/hotel/check_user_email', 'uses' => 'Setup\Hotel\HotelController@check_user_email']);
    Route::get('hotel/check_user_email', ['as' => 'backend_mps/hotel/check_user_email', 'uses' => 'Setup\Hotel\HotelController@check_user_email']);

    // Route::get('check_unique', ['as' => 'backend_mps/check_unique', 'uses' => 'Setup\Room\RoomController@check_unique']);



    });

    Route::group(['middleware' => 'right'], function () {


        //Backend
        Route::group(['prefix' => 'backend_mps'], function () {

            // Site Configuration
            Route::get('config', array('as'=>'backend_mps/config','uses'=>'Core\ConfigController@edit'));
            Route::post('config', array('as'=>'backend_mps/config','uses'=>'Core\ConfigController@update'));

            //Hotel Site Config
            Route::get('site_config', array('as'=>'backend_mps/site_config', 'uses'=>'Setup/SiteConfig/SiteConfigController@edit'));
            Route::post('site_config', array('as'=>'backend_mps/site_config', 'uses'=>'Setup/SiteConfig/SiteConfigController@update'));

            //User
            Route::get('user', array('as'=>'backend_mps/user','uses'=>'Core\UserController@index'));
            Route::get('user/create', array('as'=>'backend_mps/user/create','uses'=>'Core\UserController@create'));
            Route::post('user/store', array('as'=>'backend_mps/user/store','uses'=>'Core\UserController@store'));
            Route::get('user/edit/{id}',  array('as'=>'backend_mps/user/edit','uses'=>'Core\UserController@edit'));
            Route::post('user/update', array('as'=>'backend_mps/user/update','uses'=>'Core\UserController@update'));
            Route::post('user/destroy', array('as'=>'backend_mps/user/destroy','uses'=>'Core\UserController@destroy'));
            Route::get('user/profile/{id}', array('as'=>'backend_mps/user/profile','uses'=>'Core\UserController@profile'));
            Route::get('userAuth', array('as'=>'backend_mps/userAuth','uses'=>'Core\UserController@getAuthUser'));

            //User disable/enable
            Route::post('user/disable', array('as'=>'backend_mps/user/disable','uses'=>'Core\UserController@disable'));
            Route::post('user/enable', array('as'=>'backend_mps/user/enable','uses'=>'Core\UserController@enable'));
            Route::get('user/disabled_users', array('as'=>'backend_mps/user/disabled_users','uses'=>'Core\UserController@disabledUsers'));

            //Role
            Route::get('role', array('as'=>'backend_mps/role','uses'=>'Core\RoleController@index'));
            Route::get('role/create',  array('as'=>'backend_mps/role/create','uses'=>'Core\RoleController@create'));
            Route::post('role/store',  array('as'=>'backend_mps/role/store','uses'=>'Core\RoleController@store'));
            Route::get('role/edit/{id}',  array('as'=>'backend_mps/role/edit','uses'=>'Core\RoleController@edit'));
            Route::post('role/update',  array('as'=>'backend_mps/role/update','uses'=>'Core\RoleController@update'));
            Route::post('role/destroy',  array('as'=>'backend_mps/role/destroy','uses'=>'Core\RoleController@destroy'));
            Route::get('rolePermission/{roleId}', array('as'=>'backend_mps/rolePermission','uses'=>'Core\RoleController@rolePermission'));
            Route::post('rolePermissionAssign/{id}',   array('as'=>'backend_mps/rolePermissionAssign','uses'=>'Core\RoleController@rolePermissionAssign'));

            //Permission
            Route::get('permission', array('as'=>'backend_mps/permission','uses'=>'Core\PermissionController@index'));
            Route::get('permission/create', array('as'=>'backend_mps/permission/create','uses'=>'Core\PermissionController@create'));
            Route::post('permission/store', array('as'=>'backend_mps/permission/store','uses'=>'Core\PermissionController@store'));
            Route::get('permission/edit/{id}', array('as'=>'backend_mps/permission/edit','uses'=>'Core\PermissionController@edit'));
            Route::post('permission/update', array('as'=>'backend_mps/permission/update','uses'=>'Core\PermissionController@update'));
            Route::post('permission/destroy', array('as'=>'backend_mps/permission/destroy','uses'=>'Core\PermissionController@destroy'));

            //Country
            Route::get('country', array('as'=>'backend_mps/country','uses'=>'Setup\Country\CountryController@index'));
            Route::get('country/create',array('as'=>'backend_mps/country/create','uses'=>'Setup\Country\CountryController@create'));
            Route::post('country/store', array('as'=>'backend_mps/country/store','uses'=>'Setup\Country\CountryController@store'));
            Route::get('country/edit/{id}', array('as'=>'backend_mps/country/edit','uses'=>'Setup\Country\CountryController@edit'));
            Route::post('country/update', array('as'=>'backend_mps/country/update','uses'=>'Setup\Country\CountryController@update'));
            Route::post('country/destroy', array('as'=>'backend_mps/country/destroy','uses'=>'Setup\Country\CountryController@destroy'));
            Route::get('country/check_country_name',array('as'=>'backend_mps/country/check_country_name','uses'=>'Setup\Country\CountryController@check_country_name'));

            //Township
            Route::get('township',array('as'=>'backend_mps/township','uses'=>'Setup\Township\TownshipController@index'));
            Route::get('township/create', array('as'=>'backend_mps/township/create', 'uses'=>'Setup\Township\TownshipController@create'));
            Route::post('township/store', array('as'=>'backend_mps/township/store', 'uses'=>'Setup\Township\TownshipController@store'));
            Route::get('township/edit/{id}', array('as'=>'backend_mps/township/edit', 'uses'=>'Setup\Township\TownshipController@edit'));
            Route::post('township/update', array('as'=>'backend_mps/township/update', 'uses'=>'Setup\Township\TownshipController@update'));
            Route::post('township/destroy', array('as'=>'backend_mps/township/destroy', 'uses'=>'Setup\Township\TownshipController@destroy'));
            Route::get('township/check_township_name', array('as'=>'backend_mps/township/check_township_name', 'uses'=>'Setup\Township\TownshipController@check_township_name'));

            //City
            Route::get('city', array('as'=>'backend_mps/city', 'uses'=>'Setup\City\CityController@index'));
            Route::get('city/create', array('as'=>'backend_mps/city/create','uses'=>'Setup\City\CityController@create'));
            Route::post('city/store', array('as'=>'backend_mps/city/store', 'uses'=>'Setup\City\CityController@store'));
            Route::get('city/edit/{id}', array('as'=>'backend_mps/city/edit', 'uses'=>'Setup\City\CityController@edit'));
            Route::post('city/update', array('as'=>'backend_mps/city/update', 'uses'=>'Setup\City\CityController@update'));
            Route::post('city/destroy', array('as'=>'backend_mps/city/destroy', 'uses'=>'Setup\City\CityController@destroy'));
            Route::get('city/check_city_name',array('as'=>'backend_mps/city/check_city_name','uses'=>'Setup\City\CityController@check_city_name'));

            Route::get('popular_city/create', array('as'=>'backend_mps/popular_city/create','uses'=>'Setup\City\PopularCityController@create'));
            Route::post('popular_city/store', array('as'=>'backend_mps/popular_city/store','uses'=>'Setup\City\PopularCityController@store'));

            //Feature
            Route::get('feature', array('as'=>'backend_mps/feature', 'uses'=>'Setup\Feature\FeatureController@index'));
            Route::get('feature/create', array('as'=>'backend_mps/feature/create', 'uses'=>'Setup\Feature\FeatureController@create'));
            Route::post('feature/store', array('as'=>'backend_mps/feature/store', 'uses'=>'Setup\Feature\FeatureController@store'));
            Route::get('feature/edit/{id}', array('as'=>'backend_mps/feature/edit', 'uses'=>'Setup\Feature\FeatureController@edit'));
            Route::post('feature/update', array('as'=>'backend_mps/feature/update', 'uses'=>'Setup\Feature\FeatureController@update'));
            Route::post('feature/destroy', array('as'=>'backend_mps/feature/destroy', 'uses'=>'Setup\Feature\FeatureController@destroy'));

            //Amenities
            Route::get('amenities', array('as'=>'backend_mps/amenities', 'uses'=>'Setup\Amenities\AmenitiesController@index'));
            Route::get('amenities/create', array('as'=>'backend_mps/amenities/create', 'uses'=>'Setup\Amenities\AmenitiesController@create'));
            Route::post('amenities/store', array('as'=>'backend_mps/amenities/store', 'uses'=>'Setup\Amenities\AmenitiesController@store'));
            Route::get('amenities/edit/{id}', array('as'=>'backend_mps/amenities/edit', 'uses'=>'Setup\Amenities\AmenitiesController@edit'));
            Route::post('amenities/update', array('as'=>'backend_mps/amenities/update', 'uses'=>'Setup\Amenities\AmenitiesController@update'));
            Route::post('amenities/destroy', array('as'=>'backend_mps/amenities/destroy', 'uses'=>'Setup\Amenities\AmenitiesController@destroy'));

            //Facilities
            Route::get('facilities', array('as'=>'backend_mps/facilities', 'uses'=>'Setup\Facilities\FacilitiesController@index'));
            Route::get('facilities/create', array('as'=>'backend_mps/facilities/create', 'uses'=>'Setup\Facilities\FacilitiesController@create'));
            Route::post('facilities/store', array('as'=>'backend_mps/facilities/store', 'uses'=>'Setup\Facilities\FacilitiesController@store'));
            Route::get('facilities/edit/{id}', array('as'=>'backend_mps/facilities/edit', 'uses'=>'Setup\Facilities\FacilitiesController@edit'));
            Route::post('facilities/update', array('as'=>'backend_mps/facilities/update', 'uses'=>'Setup\Facilities\FacilitiesController@update'));
            Route::post('facilities/destroy', array('as'=>'backend_mps/facilities/destroy', 'uses'=>'Setup\Facilities\FacilitiesController@destroy'));

            //Hotel Restaurant Category
            Route::get('hotel_restaurant_category', array('as'=>'backend_mps/hotel_restaurant_category', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@index'));
            Route::get('hotel_restaurant_category/create', array('as'=>'backend_mps/hotel_restaurant_category/create', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@create'));
            Route::post('hotel_restaurant_category/store', array('as'=>'backend_mps/hotel_restaurant_category/store', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@store'));
            Route::get('hotel_restaurant_category/edit/{id}', array('as'=>'backend_mps/hotel_restaurant_category/edit', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@edit'));
            Route::post('hotel_restaurant_category/update', array('as'=>'backend_mps/hotel_restaurant_category/update', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@update'));
            Route::post('hotel_restaurant_category/destroy', array('as'=>'backend_mps/hotel_restaurant_category/destroy', 'uses'=>'Setup\HotelRestaurantCategory\HotelRestaurantCategoryController@destroy'));

            //Room View
            Route::get('room_view', array('as'=>'backend_mps/room_view', 'uses'=>'Setup\RoomView\RoomViewController@index'));
            Route::get('room_view/create', array('as'=>'backend_mps/room_view/create', 'uses'=>'Setup\RoomView\RoomViewController@create'));
            Route::post('room_view/store', array('as'=>'backend_mps/room_view/store', 'uses'=>'Setup\RoomView\RoomViewController@store'));
            Route::get('room_view/edit/{id}', array('as'=>'backend_mps/room_view/edit', 'uses'=>'Setup\RoomView\RoomViewController@edit'));
            Route::post('room_view/update', array('as'=>'backend_mps/room_view/update', 'uses'=>'Setup\RoomView\RoomViewController@update'));
            Route::post('room_view/destroy', array('as'=>'backend_mps/room_view/destroy', 'uses'=>'Setup\RoomView\RoomViewController@destroy'));

            //Hotels
            Route::get('hotel', array('as'=>'backend_mps/hotel', 'uses'=>'Setup\Hotel\HotelController@index'));
            Route::get('hotel/create', array('as'=>'backend_mps/hotel/create', 'uses'=>'Setup\Hotel\HotelController@create'));
            Route::post('hotel/store', array('as'=>'backend_mps/hotel/store', 'uses'=>'Setup\Hotel\HotelController@store'));
            Route::get('hotel/edit/{id}', array('as'=>'backend_mps/hotel/edit', 'uses'=>'Setup\Hotel\HotelController@edit'));
            Route::post('hotel/update', array('as'=>'backend_mps/hotel/update', 'uses'=>'Setup\Hotel\HotelController@update'));
            Route::post('hotel/destroy', array('as'=>'backend_mps/hotel/destroy', 'uses'=>'Setup\Hotel\HotelController@destroy'));

            //Hotel Disable/Enable
            Route::post('hotel/disable', array('as'=>'backend_mps/hotel/disable', 'uses'=>'Setup\Hotel\HotelController@disable'));
            Route::get('hotel/disabled_hotels', array('as'=>'backend_mps/hotel/disabled_hotels', 'uses'=>'Setup\Hotel\HotelController@disabled_hotels'));
            Route::post('hotel/enable', array('as'=>'backend_mps/hotel/enable', 'uses'=>'Setup\Hotel\HotelController@enable'));
            Route::get('hotel/active_booking_list/{hotel_id}', array('as'=>'backend_mps/hotel/active_booking_list{hotel_id}', 'uses'=>'Setup\Hotel\HotelController@activeBookingList'));

            //Hotel Nearby Category
            Route::get('nearby_category', array('as'=>'backend_mps/nearby_category', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@index'));
            Route::get('nearby_category/create', array('as'=>'backend_mps/nearby_category/create', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@create'));
            Route::post('nearby_category/store', array('as'=>'backend_mps/nearby_category/store', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@store'));
            Route::get('nearby_category/edit/{id}', array('as'=>'backend_mps/nearby_category/edit', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@edit'));
            Route::post('nearby_category/update', array('as'=>'backend_mps/nearby_category/update', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@update'));
            Route::post('nearby_category/destroy', array('as'=>'backend_mps/nearby_category/destroy', 'uses'=>'Setup\HotelNearbyCategory\HotelNearbyCategoryController@destroy'));

            //Hotel Nearby
            Route::get('hotel_nearby', array('as'=>'backend_mps/hotel_nearby', 'uses'=>'Setup\HotelNearby\HotelNearbyController@index'));
            Route::get('hotel_nearby/create', array('as'=>'backend_mps/hotel_nearby/create', 'uses'=>'Setup\HotelNearby\HotelNearbyController@create'));
            Route::post('hotel_nearby/store', array('as'=>'backend_mps/hotel_nearby/store', 'uses'=>'Setup\HotelNearby\HotelNearbyController@store'));
            Route::get('hotel_nearby/edit/{id}', array('as'=>'backend_mps/hotel_nearby/edit', 'uses'=>'Setup\HotelNearby\HotelNearbyController@edit'));
            Route::post('hotel_nearby/update', array('as'=>'backend_mps/hotel_nearby/update', 'uses'=>'Setup\HotelNearby\HotelNearbyController@update'));
            Route::post('hotel_nearby/destroy', array('as'=>'backend_mps/hotel_nearby/destroy', 'uses'=>'Setup\HotelNearby\HotelNearbyController@destroy'));

            //Recommended Hotels
            Route::get('recommend_hotel/create', array('as'=>'backend_mps/recommend_hotel/create', 'uses'=>'Setup\Hotel\RecommendHotelController@create'));
            Route::post('recommend_hotel/store', array('as'=>'backend_mps/recommend_hotel/store', 'uses'=>'Setup\Hotel\RecommendHotelController@store'));

            //Hotel Room Type
            Route::get('hotel_room_type', array('as'=>'backend_mps/hotel_room_type', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@index'));
            Route::get('hotel_room_type/create', array('as'=>'backend_mps/hotel_room_type/create', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@create'));
            Route::post('hotel_room_type/store', array('as'=>'backend_mps/hotel_room_type/store', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@store'));
            Route::get('hotel_room_type/edit/{id}', array('as'=>'backend_mps/hotel_room_type/edit', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@edit'));
            Route::post('hotel_room_type/update', array('as'=>'backend_mps/hotel_room_type/update', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@update'));
            Route::post('hotel_room_type/destroy', array('as'=>'backend_mps/hotel_room_type/destroy', 'uses'=>'Setup\HotelRoomType\HotelRoomTypeController@destroy'));

            //Hotel Room Category
            Route::get('hotel_room_category', array('as'=>'backend_mps/hotel_room_category', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@index'));
            Route::get('hotel_room_category/create/{hotel_id?}', array('as'=>'backend_mps/hotel_room_category/create/{hotel_id?}', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@create'));
            Route::post('hotel_room_category/store', array('as'=>'backend_mps/hotel_room_category/store', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@store'));
            Route::get('hotel_room_category/edit/{id}', array('as'=>'backend_mps/hotel_room_category/edit', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@edit'));
            Route::post('hotel_room_category/update', array('as'=>'backend_mps/hotel_room_category/update', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@update'));
            Route::post('hotel_room_category/destroy', array('as'=>'backend_mps/hotel_room_category/destroy', 'uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@destroy'));
            Route::get('hotel_room_category/{hotel_id?}',array('as'=>'backend_mps/hotel_room_category/{hotel_id?}','uses'=>'Setup\HotelRoomCategory\HotelRoomCategoryController@search'));

            //Room
            Route::get('room', array('as'=>'backend_mps/room', 'uses'=>'Setup\Room\RoomController@index'));
            Route::get('room/create', array('as'=>'backend_mps/room/create', 'uses'=>'Setup\Room\RoomController@create'));
            Route::post('room/store', array('as'=>'backend_mps/room/store', 'uses'=>'Setup\Room\RoomController@store'));
            Route::get('room/edit/{id}', array('as'=>'backend_mps/room/edit', 'uses'=>'Setup\Room\RoomController@edit'));
            Route::post('room/update', array('as'=>'backend_mps/room/update', 'uses'=>'Setup\Room\RoomController@update'));
            Route::post('room/destroy', array('as'=>'backend_mps/room/destroy', 'uses'=>'Setup\Room\RoomController@destroy'));

            //Room Category Facility
            Route::get('room_category_facility', array('as'=>'backend_mps/room_category_facility', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@index'));
            Route::get('room_category_facility/create', array('as'=>'backend_mps/room_category_facility/create', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@create'));
            Route::post('room_category_facility/store', array('as'=>'backend_mps/room_category_facility/store', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@store'));
            Route::get('room_category_facility/edit/{id}', array('as'=>'backend_mps/room_category_facility/edit', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@edit'));
            Route::post('room_category_facility/update', array('as'=>'backend_mps/room_category_facility/update', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@update'));
            Route::post('room_category_facility/destroy', array('as'=>'backend_mps/room_category_facility/destroy', 'uses'=>'Setup\RoomCategoryFacility\RoomCategoryFacilityController@destroy'));

            //Hotel Feature
            Route::get('hotel_feature', array('as'=>'backend_mps/hotel_feature', 'uses'=>'Setup\HotelFeature\HotelFeatureController@index'));
            Route::get('hotel_feature/create', array('as'=>'backend_mps/hotel_feature/create', 'uses'=>'Setup\HotelFeature\HotelFeatureController@create'));
            Route::post('hotel_feature/store', array('as'=>'backend_mps/hotel_feature/store', 'uses'=>'Setup\HotelFeature\HotelFeatureController@store'));
            Route::get('hotel_feature/edit/{id}', array('as'=>'backend_mps/hotel_feature/edit', 'uses'=>'Setup\HotelFeature\HotelFeatureController@edit'));
            Route::post('hotel_feature/update', array('as'=>'backend_mps/hotel_feature/update', 'uses'=>'Setup\HotelFeature\HotelFeatureController@update'));
            Route::post('hotel_feature/destroy', array('as'=>'backend_mps/hotel_feature/destroy', 'uses'=>'Setup\HotelFeature\HotelFeatureController@destroy'));

            //Room Discount
            Route::get('room_discount', array('as'=>'backend_mps/room_discount', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@index'));
            Route::get('room_discount/create', array('as'=>'backend_mps/room_discount/create', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@create'));
            Route::post('room_discount/store', array('as'=>'backend_mps/room_discount/store', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@store'));
            Route::get('room_discount/edit/{id}', array('as'=>'backend_mps/room_discount/edit', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@edit'));
            Route::post('room_discount/update', array('as'=>'backend_mps/room_discount/update', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@update'));
            Route::post('room_discount/destroy', array('as'=>'backend_mps/room_discount/destroy', 'uses'=>'Setup\RoomDiscount\RoomDiscountController@destroy'));

            //Room Blackout Period
            Route::get('room_blackout_period', array('as'=>'backend_mps/room_blackout_period', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@index'));
            Route::get('room_blackout_period/create', array('as'=>'backend_mps/room_blackout_period/create', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@create'));
            Route::post('room_blackout_period/store', array('as'=>'backend_mps/room_blackout_period/store', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@store'));
            Route::get('room_blackout_period/edit/{id}', array('as'=>'backend_mps/room_blackout_period/edit', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@edit'));
            Route::post('room_blackout_period/update', array('as'=>'backend_mps/room_blackout_period/update', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@update'));
            Route::post('room_blackout_period/destroy', array('as'=>'backend_mps/room_blackout_period/destroy', 'uses'=>'Setup\RoomBlackoutPeriod\RoomBlackoutPeriodController@destroy'));

            //Room Available Period
            Route::get('room_available_period', array('as'=>'backend_mps/room_available_period', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@index'));
            Route::get('room_available_period/create', array('as'=>'backend_mps/room_available_period/create', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@create'));
            Route::post('room_available_period/store', array('as'=>'backend_mps/room_available_period/store', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@store'));
            Route::get('room_available_period/edit/{id}', array('as'=>'backend_mps/room_available_period/edit', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@edit'));
            Route::post('room_available_period/update', array('as'=>'backend_mps/room_available_period/update', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@update'));
            Route::post('room_available_period/destroy', array('as'=>'backend_mps/room_available_period/destroy', 'uses'=>'Setup\RoomAvailablePeriod\RoomAvailablePeriodController@destroy'));

            //Hotel Nearby Airport
            Route::get('hotel_nearby_airport', array('as'=>'backend_mps/hotel_nearby_airport', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@index'));
            Route::get('hotel_nearby_airport/create', array('as'=>'backend_mps/hotel_nearby_airport/create', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@create'));
            Route::post('hotel_nearby_airport/store', array('as'=>'backend_mps/hotel_nearby_airport/store', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@store'));
            Route::get('hotel_nearby_airport/edit/{id}', array('as'=>'backend_mps/hotel_nearby_airport/edit', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@edit'));
            Route::post('hotel_nearby_airport/update', array('as'=>'backend_mps/hotel_nearby_airport/update', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@update'));
            Route::post('hotel_nearby_airport/destroy', array('as'=>'backend_mps/hotel_nearby_airport/destroy', 'uses'=>'Setup\HotelNearbyAirport\HotelNearbyAirportController@destroy'));

            //Hotel Nearby Station
            Route::get('hotel_nearby_station', array('as'=>'backend_mps/hotel_nearby_station', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@index'));
            Route::get('hotel_nearby_station/create', array('as'=>'backend_mps/hotel_nearby_station/create', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@create'));
            Route::post('hotel_nearby_station/store', array('as'=>'backend_mps/hotel_nearby_station/store', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@store'));
            Route::get('hotel_nearby_station/edit/{id}', array('as'=>'backend_mps/hotel_nearby_station/edit', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@edit'));
            Route::post('hotel_nearby_station/update', array('as'=>'backend_mps/hotel_nearby_station/update', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@update'));
            Route::post('hotel_nearby_station/destroy', array('as'=>'backend_mps/hotel_nearby_station/destroy', 'uses'=>'Setup\HotelNearbyStation\HotelNearbyStationController@destroy'));

            //Hotel Nearby Hospital
            Route::get('hotel_nearby_hospital', array('as'=>'backend_mps/hotel_nearby_hospital', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@index'));
            Route::get('hotel_nearby_hospital/create', array('as'=>'backend_mps/hotel_nearby_hospital/create', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@create'));
            Route::post('hotel_nearby_hospital/store', array('as'=>'backend_mps/hotel_nearby_hospital/store', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@store'));
            Route::get('hotel_nearby_hospital/edit/{id}', array('as'=>'backend_mps/hotel_nearby_hospital/edit', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@edit'));
            Route::post('hotel_nearby_hospital/update', array('as'=>'backend_mps/hotel_nearby_hospital/update', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@update'));
            Route::post('hotel_nearby_hospital/destroy', array('as'=>'backend_mps/hotel_nearby_hospital/destroy', 'uses'=>'Setup\HotelNearbyHospital\HotelNearbyHospitalController@destroy'));

            //Hotel Nearby Convenience Store
            Route::get('hotel_nearby_convenience_store', array('as'=>'backend_mps/hotel_nearby_convenience_store', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@index'));
            Route::get('hotel_nearby_convenience_store/create', array('as'=>'backend_mps/hotel_nearby_convenience_store/create', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@create'));
            Route::post('hotel_nearby_convenience_store/store', array('as'=>'backend_mps/hotel_nearby_convenience_store/store', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@store'));
            Route::get('hotel_nearby_convenience_store/edit/{id}', array('as'=>'backend_mps/hotel_nearby_convenience_store/edit', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@edit'));
            Route::post('hotel_nearby_convenience_store/update', array('as'=>'backend_mps/hotel_nearby_convenience_store/update', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@update'));
            Route::post('hotel_nearby_convenience_store/destroy', array('as'=>'backend_mps/hotel_nearby_convenience_store/destroy', 'uses'=>'Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreController@destroy'));

            //Hotel Nearby Drug Store
            Route::get('hotel_nearby_drug_store', array('as'=>'backend_mps/hotel_nearby_drug_store', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@index'));
            Route::get('hotel_nearby_drug_store/create', array('as'=>'backend_mps/hotel_nearby_drug_store/create', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@create'));
            Route::post('hotel_nearby_drug_store/store', array('as'=>'backend_mps/hotel_nearby_drug_store/store', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@store'));
            Route::get('hotel_nearby_drug_store/edit/{id}', array('as'=>'backend_mps/hotel_nearby_drug_store/edit', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@edit'));
            Route::post('hotel_nearby_drug_store/update', array('as'=>'backend_mps/hotel_nearby_drug_store/update', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@update'));
            Route::post('hotel_nearby_drug_store/destroy', array('as'=>'backend_mps/hotel_nearby_drug_store/destroy', 'uses'=>'Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreController@destroy'));

            /** TEST MULTI LANGUAGE */
            Route::get('test_multilanguage',['as' => 'backend_mps/test_multilanguage', 'uses' => 'Language\LanguageController@test']);
            Route::post('language', ['as' => 'backend_mps/language', 'uses' => 'Language\LanguageController@changeLanguage']);

            //Facility Group
            Route::get('facility_group', array('as'=>'backend_mps/facility_group', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@index'));
            Route::get('facility_group/create', array('as'=>'backend_mps/facility_group/create', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@create'));
            Route::post('facility_group/store', array('as'=>'backend_mps/facility_group/store', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@store'));
            Route::get('facility_group/edit/{id}', array('as'=>'backend_mps/facility_group/edit', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@edit'));
            Route::post('facility_group/update', array('as'=>'backend_mps/facility_group/update', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@update'));
            Route::post('facility_group/destroy', array('as'=>'backend_mps/facility_group/destroy', 'uses'=>'Setup\FacilityGroup\FacilityGroupController@destroy'));

            //Hotel Restaurant
            Route::get('hotel_restaurant', array('as'=>'backend_mps/hotel_restaurant', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@index'));
            Route::get('hotel_restaurant/create', array('as'=>'backend_mps/hotel_restaurant/create', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@create'));
            Route::post('hotel_restaurant/store', array('as'=>'backend_mps/hotel_restaurant/store', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@store'));
            Route::get('hotel_restaurant/edit/{id}', array('as'=>'backend_mps/hotel_restaurant/edit', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@edit'));
            Route::post('hotel_restaurant/update', array('as'=>'backend_mps/hotel_restaurant/update', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@update'));
            Route::post('hotel_restaurant/destroy', array('as'=>'backend_mps/hotel_restaurant/destroy', 'uses'=>'Setup\HotelRestaurant\HotelRestaurantController@destroy'));

            //Hotel Facility
            Route::get('hotel_facility', array('as'=>'backend_mps/hotel_facility', 'uses'=>'Setup\HotelFacility\HotelFacilityController@index'));
            Route::get('hotel_facility/create', array('as'=>'backend_mps/hotel_facility/create', 'uses'=>'Setup\HotelFacility\HotelFacilityController@create'));
            Route::post('hotel_facility/store', array('as'=>'backend_mps/hotel_facility/store', 'uses'=>'Setup\HotelFacility\HotelFacilityController@store'));
            Route::get('hotel_facility/edit/{id}', array('as'=>'backend_mps/hotel_facility/edit', 'uses'=>'Setup\HotelFacility\HotelFacilityController@edit'));
            Route::post('hotel_facility/update', array('as'=>'backend_mps/hotel_facility/update', 'uses'=>'Setup\HotelFacility\HotelFacilityController@update'));
            Route::post('hotel_facility/destroy', array('as'=>'backend_mps/hotel_facility/destroy', 'uses'=>'Setup\HotelFacility\HotelFacilityController@destroy'));

            //Landmark
            Route::get('landmark', array('as'=>'backend_mps/landmark', 'uses'=>'Setup\Landmark\LandmarkController@index'));
            Route::get('landmark/create', array('as'=>'backend_mps/landmark/create', 'uses'=>'Setup\Landmark\LandmarkController@create'));
            Route::post('landmark/store', array('as'=>'backend_mps/landmark/store', 'uses'=>'Setup\Landmark\LandmarkController@store'));
            Route::get('landmark/edit/{id}', array('as'=>'backend_mps/landmark/edit', 'uses'=>'Setup\Landmark\LandmarkController@edit'));
            Route::post('landmark/update', array('as'=>'backend_mps/landmark/update', 'uses'=>'Setup\Landmark\LandmarkController@update'));
            Route::post('landmark/destroy', array('as'=>'backend_mps/landmark/destroy', 'uses'=>'Setup\Landmark\LandmarkController@destroy'));

            //Hotel Landmark
            Route::get('hotel_landmark', array('as'=>'backend_mps/hotel_landmark', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@index'));
            Route::get('hotel_landmark/create', array('as'=>'backend_mps/hotel_landmark/create', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@create'));
            Route::post('hotel_landmark/store', array('as'=>'backend_mps/hotel_landmark/store', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@store'));
            Route::get('hotel_landmark/edit/{id}', array('as'=>'backend_mps/hotel_landmark/edit', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@edit'));
            Route::post('hotel_landmark/update', array('as'=>'backend_mps/hotel_landmark/update', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@update'));
            Route::post('hotel_landmark/destroy', array('as'=>'backend_mps/hotel_landmark/destroy', 'uses'=>'Setup\HotelLandmark\HotelLandmarkController@destroy'));

            //Room Category Amenity
            Route::get('room_category_amenity', array('as'=>'backend_mps/room_category_amenity', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@index'));
            Route::get('room_category_amenity/create', array('as'=>'backend_mps/room_category_amenity/create', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@create'));
            Route::post('room_category_amenity/store', array('as'=>'backend_mps/room_category_amenity/store', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@store'));
            Route::get('room_category_amenity/edit/{id}', array('as'=>'backend_mps/room_category_amenity/edit', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@edit'));
            Route::post('room_category_amenity/update', array('as'=>'backend_mps/room_category_amenity/update', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@update'));
            Route::post('room_category_amenity/destroy', array('as'=>'backend_mps/room_category_amenity/destroy', 'uses'=>'Setup\RoomCategoryAmenity\RoomCategoryAmenityController@destroy'));

            //Slider
            Route::get('slider', array('as'=>'backend_mps/slider', 'uses'=>'Setup\Slider\SliderController@index'));
            Route::get('slider/create', array('as'=>'backend_mps/slider/create', 'uses'=>'Setup\Slider\SliderController@create'));
            Route::post('slider/store', array('as'=>'backend_mps/slider/store', 'uses'=>'Setup\Slider\SliderController@store'));
            Route::post('slider/destroy', array('as'=>'backend_mps/slider/destroy', 'uses'=>'Setup\Slider\SliderController@destroy'));

            //Hotel Config
            Route::get('hotel_config', array('as'=>'backend_mps/hotel_config', 'uses'=>'Setup\HotelConfig\HotelConfigController@index'));
            Route::get('hotel_config/create', array('as'=>'backend_mps/hotel_config/create', 'uses'=>'Setup\HotelConfig\HotelConfigController@create'));
            Route::post('hotel_config/store', array('as'=>'backend_mps/hotel_config/store', 'uses'=>'Setup\HotelConfig\HotelConfigController@store'));
            Route::get('hotel_config/edit/{id}', array('as'=>'backend_mps/hotel_config/edit', 'uses'=>'Setup\HotelConfig\HotelConfigController@edit'));
            Route::post('hotel_config/update', array('as'=>'backend_mps/hotel_config/update', 'uses'=>'Setup\HotelConfig\HotelConfigController@update'));
            Route::post('hotel_config/destroy', array('as'=>'backend_mps/hotel_config/destroy', 'uses'=>'Setup\HotelConfig\HotelConfigController@destroy'));

            //Page
            Route::get('page', array('as'=>'backend_mps/page', 'uses'=>'Setup\Page\PageController@index'));
            Route::get('page/edit/{id}', array('as'=>'backend_mps/page/edit', 'uses'=>'Setup\Page\PageController@edit'));
            Route::post('page/update', array('as'=>'backend_mps/page/update', 'uses'=>'Setup\Page\PageController@update'));
            Route::post('page/upload', array('as'=>'backend_mps/page/upload', 'uses'=>'Setup\Page\PageController@upload'));

            //Event Email
            Route::get('eventemail', array('as'=>'backend_mps/eventemail', 'uses'=>'Setup\EventEmail\EventEmailController@index'));
            Route::get('eventemail/create', array('as'=>'backend_mps/eventemail/create', 'uses'=>'Setup\EventEmail\EventEmailController@create'));
            Route::post('eventemail/store', array('as'=>'backend_mps/eventemail/store', 'uses'=>'Setup\EventEmail\EventEmailController@store'));
            Route::get('eventemail/edit/{id}', array('as'=>'backend_mps/eventemail/edit', 'uses'=>'Setup\EventEmail\EventEmailController@edit'));
            Route::post('eventemail/update', array('as'=>'backend_mps/eventemail/update', 'uses'=>'Setup\EventEmail\EventEmailController@update'));
            Route::post('eventemail/destroy', array('as'=>'backend_mps/eventemail/destroy', 'uses'=>'Setup\EventEmail\EventEmailController@destroy'));

            //Backend Email Sending
            Route::get('email_template_booking_confirm', array('as'=>'backend_mps/email_template_booking_confirm', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@booking_confirm'));
            Route::post('email_template_booking_confirm/update', array('as'=>'backend_mps/email_template_booking_confirm/update', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@update'));
            Route::get('email_template_booking_cancel', array('as'=>'backend_mps/email_template_booking_cancel', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@booking_cancel'));
            Route::post('email_template_booking_cancel/update', array('as'=>'backend_mps/email_template_booking_cancel/update', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@update'));
            Route::get('email_template_booking_edit', array('as'=>'backend_mps/email_template_booking_edit', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@booking_edit'));
            Route::post('email_template_booking_edit/update', array('as'=>'backend_mps/email_template_booking_edit/update', 'uses'=>'Setup\EmailTemplate\EmailTemplateController@update'));


            //Hotel Admin Group
            Route::get('hotel_admin/dashboard', array('as'=>'backend_mps/hotel_admin/dashboard', 'uses'=>'Setup\HotelAdmin\HotelDashboardController@dashboard'));
            Route::get('system_admin/dashboard', array('as'=>'backend_mps/system_admin/dashboard', 'uses'=>'Setup\SystemAdmin\SystemAdminDashboardController@dashboard'));

            //Booking List
            Route::get('booking', array('as'=>'backend_mps/booking', 'uses'=>'Setup\HotelBooking\HotelBookingController@index'));
            Route::get('booking/{id}', array('as'=>'backend_mps/booking/{id}', 'uses'=>'Setup\HotelBooking\HotelBookingController@detail'));
            Route::post('booking/refund',array('as'=>'backend_mps/booking/refund',
                                               'uses'=>'Setup\HotelBooking\HotelBookingController@refundByHotelAdmin'));
            Route::get('communication', array('as'=>'backend_mps/communication', 'uses'=>'Setup\HotelBooking\CommunicationController@index'));
            Route::get('communication/reply/{id}', array('as'=>'backend_mps/communication/reply/{id}', 'uses'=>'Setup\HotelBooking\CommunicationController@show'));
            Route::post('communication/reply/store', array('as'=>'backend_mps/communication/reply/store', 'uses'=>'Setup\HotelBooking\CommunicationController@store'));

            //stored in service_price table
            // //Transportation Information
            // Route::get('transportation_information', array('as'=>'backend_mps/transportation_information', 'uses'=>'Setup\TransportationInformation\TransportationInformationController@edit'));
            // Route::post('transportation_information', array('as'=>'backend_mps/transportation_information', 'uses'=>'Setup\TransportationInformation\TransportationInformationController@update'));

            //stored in display_information table [updated]
            //Transportation Information
            Route::get('transportation_information', array('as'=>'backend_mps/transportation_information', 'uses'=>'Setup\TransportationInformation\TransportationInformationController@edit'));
            Route::post('transportation_information', array('as'=>'backend_mps/transportation_information', 'uses'=>'Setup\TransportationInformation\TransportationInformationController@update'));

            //Guide Information
            Route::get('guide_information', array('as'=>'backend_mps/guide_information', 'uses'=>'Setup\GuideInformation\GuideInformationController@edit'));
            Route::post('guide_information', array('as'=>'backend_mps/guide_information', 'uses'=>'Setup\GuideInformation\GuideInformationController@update'));

            //Visa Information
            Route::get('visa_information',array('as'=>'backend_mps/visa_information','uses'=>'Setup\VisaInformation\VisaInformationController@edit'));

            Route::post('visa_information',array('as'=>'backend_mps/visa_information','uses'=>'Setup\VisaInformation\VisaInformationController@update'));

            //FAQ Information
            Route::get('faq_information',array('as'=>'backend_mps/faq_information','uses'=>'Setup\FaqInformation\FaqInformationController@edit'));
             Route::post('faq_information',array('as'=>'backend_mps/faq_information','uses'=>'Setup\FaqInformation\FaqInformationController@update'));

            //Tour Information
            Route::get('tour_information', array('as'=>'backend_mps/tour_information', 'uses'=>'Setup\TourInformation\TourInformationController@edit'));
            Route::post('tour_information', array('as'=>'backend_mps/tour_information', 'uses'=>'Setup\TourInformation\TourInformationController@update'));

            //About Us Information
            Route::get('about_us', array('as'=>'backend_mps/about_us', 'uses'=>'Setup\AboutUs\AboutUsController@edit'));
            Route::post('about_us', array('as'=>'backend_mps/about_us', 'uses'=>'Setup\AboutUs\AboutUsController@update'));

            //Contact Us Information
            Route::get('contact_us', array('as'=>'backend_mps/contact_us', 'uses'=>'Setup\ContactUs\ContactUsController@edit'));
            Route::post('contact_us', array('as'=>'backend_mps/contact_us', 'uses'=>'Setup\ContactUs\ContactUsController@update'));

            //start Home Page display information text setup
            //Popular Destination
            Route::get('popular_destination_information', array('as'=>'backend_mps/popular_destination_information', 'uses'=>'Setup\PopularDestinationInformation\PopularDestinationInformationController@edit'));
            Route::post('popular_destination_information', array('as'=>'backend_mps/popular_destination_information', 'uses'=>'Setup\PopularDestinationInformation\PopularDestinationInformationController@update'));

            //Recommended Hotels
            Route::get('recommended_hotel_information', array('as'=>'backend_mps/recommended_hotel_information', 'uses'=>'Setup\RecommendedHotelInformation\RecommendedHotelInformationController@edit'));
            Route::post('recommended_hotel_information', array('as'=>'backend_mps/recommended_hotel_information', 'uses'=>'Setup\RecommendedHotelInformation\RecommendedHotelInformationController@update'));

            //Promotions for this month
            Route::get('promotion_information', array('as'=>'backend_mps/promotion_information', 'uses'=>'Setup\PromotionInformation\PromotionInformationController@edit'));
            Route::post('promotion_information', array('as'=>'backend_mps/promotion_information', 'uses'=>'Setup\PromotionInformation\PromotionInformationController@update'));

            //Promotions for this month
            Route::get('terms_and_condition', array('as'=>'backend_mps/terms_and_condition', 'uses'=>'Setup\TermsAndCondition\TermsAndConditionController@edit'));
            Route::post('terms_and_condition', array('as'=>'backend_mps/terms_and_condition', 'uses'=>'Setup\TermsAndCondition\TermsAndConditionController@update'));
            //end Home Page display information text setup

            //Activities
            Route::get('activities', array('as'=>'backend_mps/activities','uses'=>'Setup\Activities\ActivitiesController@index'));

            //SaleSummary Report
            Route::get('salesummaryreport',array(
                'as'=>'backend_mps/salesummaryreport',
                'uses'=>'Report\SaleSummaryReportController@index'
            ));
            Route::get('salesummaryreport/search/{type?}/{from?}/{to?}',
                array(
                    'as'=>'backend_mps/salesummaryreport/search/{type?}/{from?}/{to?}',
                    'uses'=>'Report\SaleSummaryReportController@search'
                ));
            Route::get('salesummaryreport/exportexcel/{type?}/{from?}/{to?}',
                array(
                    'as'=>'backend_mps/salesummaryreport/exportexcel/{type?}/{from?}/{to?}',
                    'uses'=>'Report\SaleSummaryReportController@excel'
                ));

            //Booking Report
            Route::get('bookingreport',array(
                'as'=>'backend_mps/bookingreport',
                'uses'=>'Report\BookingReportController@index'
            ));
            Route::get('bookingreport/search/{type?}/{from?}/{to?}/{status?}',
                array(
                    'as'=>'backend_mps/bookingreport/search/{type?}/{from?}/{to?}/{status?}',
                    'uses'=>'Report\BookingReportController@search'
                ));
            Route::get('bookingreport/exportexcel/{type?}/{from?}/{to?}/{status?}',
                array(
                    'as'=>'backend_mps/bookingreport/exportexcel/{type?}/{from?}/{to?}/{status?}',
                    'uses'=>'Report\BookingReportController@excel'
                ));
            Route::get('bookingreport/room_detail/{id}',array(
                'as'=>'backend_mps/bookingreport/room_detail/{id}',
                'uses'=>'Report\BookingReportController@booking_room_detail'
            ));

            //Csv Import
            Route::get('import',array(
                'as'=>'backend_mps/import',
                'uses'=>'Setup\CSVImport\CSVImportController@import'
            ));
            Route::post('import/store',array(
                'as'=>'backend_mps/import/store',
                'uses'=>'Setup\CSVImport\CSVImportController@store'
            ));

            //Hotel Gallery
            Route::get('hotel_gallery', array('as'=>'backend_mps/hotel_gallery', 'uses'=>'Setup\HotelGallery\HotelGalleryController@index'));
            Route::get('hotel_gallery/create/{hotel_id?}', array('as'=>'backend_mps/hotel_gallery/create/{hotel_id?}', 'uses'=>'Setup\HotelGallery\HotelGalleryController@create'));
            Route::post('hotel_gallery/store', array('as'=>'backend_mps/hotel_gallery/store', 'uses'=>'Setup\HotelGallery\HotelGalleryController@store'));
            Route::get('hotel_gallery/edit/{id}', array('as'=>'backend_mps/hotel_gallery/edit', 'uses'=>'Setup\HotelGallery\HotelGalleryController@edit'));
            Route::post('hotel_gallery/update', array('as'=>'backend_mps/hotel_gallery/update', 'uses'=>'Setup\HotelGallery\HotelGalleryController@update'));
            Route::post('hotel_gallery/destroy', array('as'=>'backend_mps/hotel_gallery/destroy', 'uses'=>'Setup\HotelGallery\HotelGalleryController@destroy'));
            Route::get('hotel_gallery/{hotel_id?}',array('as'=>'backend_mps/hotel_gallery/{hotel_id?}','uses'=>'Setup\HotelGallery\HotelGalleryController@search'));

            //Hotel Policy
            Route::get('hotel_policy', array('as'=>'backend_mps/hotel_policy', 'uses'=>'Setup\HotelPolicy\HotelPolicyController@index'));
            Route::get('hotel_policy/create/{hotel_id?}', array('as'=>'backend_mps/hotel_policy/create/{hotel_id?}', 'uses'=>'Setup\HotelPolicy\HotelPolicyController@create'));
            Route::post('hotel_policy/store', array('as'=>'backend_mps/hotel_policy/store', 'uses'=>'Setup\HotelPolicy\HotelPolicyController@store'));
            Route::get('hotel_policy/edit/{id}', array('as'=>'backend_mps/hotel_policy/edit', 'uses'=>'Setup\HotelPolicy\HotelPolicyController@edit'));
            Route::post('hotel_policy/update', array('as'=>'backend_mps/hotel_policy/update', 'uses'=>'Setup\HotelPolicy\HotelPolicyController@update'));
            Route::post('hotel_policy/destroy', array('as'=>'backend_mps/hotel_policy/destroy', 'uses'=>'Setup\HotelPolicy\HotelPolicyController@destroy'));
            Route::get('hotel_policy/{hotel_id?}',array('as'=>'backend_mps/hotel_policy/{hotel_id?}','uses'=>'Setup\HotelPolicy\HotelPolicyController@search'));

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
