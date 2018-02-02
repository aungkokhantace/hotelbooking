<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/11/2017
 * Time: 3:39 PM
 */

namespace App\Setup\Booking;


interface BookingRepositoryInterface
{
    public function getBookingByCustomerId($id);
    public function getBookingRoomByCustomerId($id);
    public function create($paramObj);
    public function update($paramObj);
    public function getBookingById($id);
    public function getObjs();
    public function getUserObjs();
    public function getBookingByHotelId($hotel_id);
    public function checkHasPermission($id,$h_id);
    public function getBookingByBookIdAndUserId($b_id,$u_id);
    public function changeBookingStatus($paramObj);
//    public function sendMail($template,$emails,$subject,$logMessage);
    public function getAvailableRoom($check_in,$check_out,$room_id_arr);
    public function checkBookingByHotelId($hotel_id);
}
