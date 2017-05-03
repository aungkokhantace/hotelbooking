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
    public function delete($id);
    public function getArrays();
    public function getHotelsByDestination($name);
    public function getHotelsByFilters($destination,$price_filter,$star_filter,$facility_filter,$landmark_filter);
    public function getSuggestedHotelsByDestination($hotelIdArr,$countryIdArr,$cityIdArr,$townshipIdArr);
}