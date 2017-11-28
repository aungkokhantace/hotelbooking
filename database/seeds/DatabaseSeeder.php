<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Seeders

         $this->call(Default_ConfigSeeder::class);
         $this->call(Default_RoleSeeder::class);
         $this->call(Default_UserSeeder::class);
         $this->call(Default_PermissionSeeder::class);
         $this->call(Default_RolePermissionSeeder::class);
         $this->call(Default_Syncs_TablesSeeder::class);
         $this->call(Default_CountriesSeeder::class);
         $this->call(Default_CitySeeder::class);
         $this->call(Default_TownshipSeeder::class);
         $this->call(Default_SettingSeeder::class);
         $this->call(Default_PriceFilterSeeder::class);

         $this->call(Default_LandmarkSeeder::class);
         $this->call(Default_FacilityGroupSeeder::class);
         $this->call(Default_FacilitySeeder::class);
         $this->call(Default_HotelSeeder::class);
         $this->call(Default_HotelFacilitySeeder::class);
         $this->call(Default_HotelLandmarkSeeder::class);
         $this->call(Default_AmenitiesSeeder::class);
         $this->call(Default_FeatureSeeder::class);
         $this->call(Default_HotelFeatureSeeder::class);

         $this->call(Default_HotelConfigSeeder::class);
         $this->call(Default_BedTypeSeeder::class);

         $this->call(Default_HotelGallerySeeder::class);
         $this->call(Default_HotelRoomTypeSeeder::class);

         $this->call(Default_HotelRoomCategorySeeder::class);

         $this->call(Default_RoomCategoryFacilitySeeder::class);
         $this->call(Default_RoomCategoryAmenitySeeder::class);
         $this->call(Default_TemplateSeeder::class);

         $this->call(Default_RestaurantCategorySeeder::class);

    }
}
