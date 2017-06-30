<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/8/2017
 * Time: 5:28 PM
 */

namespace App\Setup\HotelRoomType;


interface HotelRoomTypeRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($paramObj);
    public function getHotelRoomTypeWithHotelId($hotel_id);
    public function getUserObjs();
    public function getHotelRoomTypeByUserId($id);
    public function checkHasPermission($id,$h_id);
}