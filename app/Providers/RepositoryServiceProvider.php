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


    }
}
