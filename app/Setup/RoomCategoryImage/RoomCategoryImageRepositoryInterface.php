<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/13/2017
 * Time: 5:03 PM
 */

namespace App\Setup\RoomCategoryImage;


interface RoomCategoryImageRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function getRoomCategoryImageByHotelRoomCategoryId($h_room_category_id);
    public function getRoomCategoryImageByHotelRoomCategoryIdArray($h_room_category_id_array);
}