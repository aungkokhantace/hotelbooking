<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/8/2017
 * Time: 5:28 PM
 */

namespace App\Setup\HotelRoomCategory;


interface HotelRoomCategoryRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj,$childArray);
    public function update($paramObj,$childArray);
    public function getHotelRoomCategoryWithRoomTypeId($h_room_type_id);
    public function getMinPriceByHotelId($hotel_id);
    public function getRoomTypeByHotelIdAndPrice($hotel_id,$price);
    public function getRoomCategoriesByHotelId($hotel_id);
    public function getUserObjs();
    public function checkHasPermission($id,$h_id);
    public function getObjsByIdArr($id_arr);
    public function getRoomCategories($hotel_id);
    public function getRoomCategoryAmenityByID($id);
    public function getRoomCategoryFacilityByID($id);
}
