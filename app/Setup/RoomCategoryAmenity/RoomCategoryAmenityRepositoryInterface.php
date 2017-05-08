<?php
namespace App\Setup\RoomCategoryAmenity;
/**
 * Created by PhpStorm.
 * Author: Khin Zar Ni Wint
 * Date: 3/19/2017
 * Time: 8:49 PM
 */
interface RoomCategoryAmenityRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($paramObj);
    public function getAmenitiesByHotelRoomCategoryIdArray($h_room_category_id_array);
    public function getAmenitiesByRoomCategoryId($room_category_id);
}