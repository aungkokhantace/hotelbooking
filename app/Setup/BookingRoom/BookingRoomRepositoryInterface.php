<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/12/2017
 * Time: 10:23 AM
 */

namespace App\Setup\BookingRoom;


interface BookingRoomRepositoryInterface
{
    public function create($paramObj);
    public function getAllBookingRoom();
    public function getBookingRoomByBookingId($id);
    public function getAllBookingRoomByBookingId($id);
    public function getBookingRoomAndRoomByBookingId($id);
    public function getObjectById($id);
    public function update($paramObj);
    public function getActiveBookingRoom($booking_id);
}