<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 2:55 PM
 */

namespace App\Setup\HotelFacility;


interface HotelFacilityRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($paramObj);
    public function getHotelFacilitiesByHotelIDandGroupID($hotel_id,$facility_group_id);
}