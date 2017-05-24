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
}