<?php
/**
 * Created by PhpStorm.
 * Author: Aung Ko Khant
 * Date: 2017-03-06
 * Time: 05:38 PM
 */

namespace App\Setup\Hotel;


interface HotelRepositoryInterface
{
    public function getObjs();
    public function create($paramObj);
    public function update($paramObj);
    public function getObjByID($id);
    public function getHConfigByID($id);
    public function getHLandmarkByID($id);
    public function getHNearbyID($id);
    public function getHFacilityID($id);
    public function getHFeatureID($id);
    public function getHotelRoomTypeByID($id);
    public function delete($id);
    public function getArrays();
    public function getHotelsByDestination($name);
    public function getHotelsByFilters($destination,$price_filter,$star_filter,$facility_filter,$landmark_filter);
    public function getSuggestedHotelsByDestination($hotelIdArr,$countryIdArr,$cityIdArr,$townshipIdArr);
    public function getObjsNotInConfig($hotel_config_array);
    public function getHotelByUserEmail($email);
    public function getLandMarkByHotelID($landmark_id);
    public function getHotelByAdminId($admin_id);
    public function getUserObjs();

}