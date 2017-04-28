<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Core\Role\RoleRepositoryInterface','App\Core\Role\RoleRepository');
        $this->app->bind('App\Core\Permission\PermissionRepositoryInterface','App\Core\Permission\PermissionRepository');
        $this->app->bind('App\Core\Config\ConfigRepositoryInterface','App\Core\Config\ConfigRepository');
        $this->app->bind('App\Core\User\UserRepositoryInterface','App\Core\User\UserRepository');
        $this->app->bind('App\Setup\Customer\CustomerRepositoryInterface','App\Setup\Customer\CustomerRepository');

        //Backend
        $this->app->bind('App\Setup\Country\CountryRepositoryInterface','App\Setup\Country\CountryRepository');
        $this->app->bind('App\Setup\Township\TownshipRepositoryInterface','App\Setup\Township\TownshipRepository');
        $this->app->bind('App\Setup\City\CityRepositoryInterface','App\Setup\City\CityRepository');
        $this->app->bind('App\Setup\Feature\FeatureRepositoryInterface','App\Setup\Feature\FeatureRepository');
        $this->app->bind('App\Setup\Amenities\AmenitiesRepositoryInterface','App\Setup\Amenities\AmenitiesRepository');
        $this->app->bind('App\Setup\Facilities\FacilitiesRepositoryInterface','App\Setup\Facilities\FacilitiesRepository');
        $this->app->bind('App\Setup\HotelRestaurantCategory\HotelRestaurantCategoryRepositoryInterface','App\Setup\HotelRestaurantCategory\HotelRestaurantCategoryRepository');
        $this->app->bind('App\Setup\RoomView\RoomViewRepositoryInterface','App\Setup\RoomView\RoomViewRepository');
        $this->app->bind('App\Setup\Hotel\HotelRepositoryInterface','App\Setup\Hotel\HotelRepository');
        $this->app->bind('App\Setup\HotelRoomType\HotelRoomTypeRepositoryInterface','App\Setup\HotelRoomType\HotelRoomTypeRepository');
        $this->app->bind('App\Setup\HotelRoomCategory\HotelRoomCategoryRepositoryInterface','App\Setup\HotelRoomCategory\HotelRoomCategoryRepository');
        $this->app->bind('App\Setup\Room\RoomRepositoryInterface','App\Setup\Room\RoomRepository');
        $this->app->bind('App\Setup\RoomCategoryFacility\RoomCategoryFacilityRepositoryInterface','App\Setup\RoomCategoryFacility\RoomCategoryFacilityRepository');
        $this->app->bind('App\Setup\HotelFeature\HotelFeatureRepositoryInterface','App\Setup\HotelFeature\HotelFeatureRepository');
        $this->app->bind('App\Setup\RoomDiscount\RoomDiscountRepositoryInterface','App\Setup\RoomDiscount\RoomDiscountRepository');
        $this->app->bind('App\Setup\RoomBlackoutPeriod\RoomBlackoutPeriodRepositoryInterface','App\Setup\RoomBlackoutPeriod\RoomBlackoutPeriodRepository');
        $this->app->bind('App\Setup\RoomAvailablePeriod\RoomAvailablePeriodRepositoryInterface','App\Setup\RoomAvailablePeriod\RoomAvailablePeriodRepository');
        $this->app->bind('App\Setup\HotelNearbyAirport\HotelNearbyAirportRepositoryInterface','App\Setup\HotelNearbyAirport\HotelNearbyAirportRepository');
        $this->app->bind('App\Setup\HotelNearbyStation\HotelNearbyStationRepositoryInterface','App\Setup\HotelNearbyStation\HotelNearbyStationRepository');
        $this->app->bind('App\Setup\HotelNearbyHospital\HotelNearbyHospitalRepositoryInterface','App\Setup\HotelNearbyHospital\HotelNearbyHospitalRepository');
        $this->app->bind('App\Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreRepositoryInterface','App\Setup\HotelNearbyConvenienceStore\HotelNearbyConvenienceStoreRepository');
        $this->app->bind('App\Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreRepositoryInterface','App\Setup\HotelNearbyDrugStore\HotelNearbyDrugStoreRepository');
        $this->app->bind('App\Setup\FacilityGroup\FacilityGroupRepositoryInterface','App\Setup\FacilityGroup\FacilityGroupRepository');
        $this->app->bind('App\Setup\HotelRestaurant\HotelRestaurantRepositoryInterface','App\Setup\HotelRestaurant\HotelRestaurantRepository');
        $this->app->bind('App\Setup\HotelFacility\HotelFacilityRepositoryInterface','App\Setup\HotelFacility\HotelFacilityRepository');
        $this->app->bind('App\Setup\Landmark\LandmarkRepositoryInterface','App\Setup\Landmark\LandmarkRepository');
        $this->app->bind('App\Setup\HotelLandmark\HotelLandmarkRepositoryInterface','App\Setup\HotelLandmark\HotelLandmarkRepository');
        $this->app->bind('App\Setup\City\PopularCityRepositoryInterface','App\Setup\City\PopularCityRepository');
        $this->app->bind('App\Setup\Hotel\RecommendHotelRepositoryInterface','App\Setup\Hotel\RecommendHotelRepository');
        $this->app->bind('App\Setup\Autocomplete\AutocompleteRepositoryInterface','App\Setup\Autocomplete\AutocompleteRepository');
        $this->app->bind('App\Setup\Customer\CustomerRepositoryInterface','App\Setup\Customer\CustomerRepository');

    }
}
