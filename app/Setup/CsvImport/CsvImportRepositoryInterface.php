<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/11/2017
 * Time: 3:39 PM
 */

namespace App\Setup\CsvImport;


interface CsvImportRepositoryInterface
{
    public function createAmenities($insert_val);
    public function createFacilityGroup($insert_val);
    public function createFacility($insert_val);
    public function createLandmarks($insert_val);
    public function createAdmin($insert_val);
    public function createHotels($insert_val);
    public function getCountryIdByName($country_name);
    public function getCityIdByName($city_name);
    public function getTownshipIdByName($township_name);

}