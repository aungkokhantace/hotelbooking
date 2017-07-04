<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/15/2017
 * Time: 9:57 PM
 */

namespace App\Setup\Room;


interface RoomRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($paramObj);
    public function getObjsByHotelId($hotel_id);
    public function getRoomCountByRoomCategoryId($r_category_id,$check_in,$check_out);
    public function getRoomArrayByRoomCategoryId($r_category_id,$check_in,$check_out);
    public function getUserObjs();
}