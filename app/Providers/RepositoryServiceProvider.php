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
        $this->app->bind('App\Setup\Amendities\AmenditiesRepositoryInterface','App\Setup\Amendities\AmenditiesRepository');
        $this->app->bind('App\Setup\Facilities\FacilitiesRepositoryInterface','App\Setup\Facilities\FacilitiesRepository');
        $this->app->bind('App\Setup\HotelRestaurantCategory\HotelRestaurantCategoryRepositoryInterface','App\Setup\HotelRestaurantCategory\HotelRestaurantCategoryRepository');

    }
}
