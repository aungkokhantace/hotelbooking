<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/11/2017
 * Time: 3:40 PM
 */

namespace App\Setup\Booking;


use App\Setup\BookingRoom\BookingRoom;

class BookingRepository implements BookingRepositoryInterface
{
    public function getBookingByCustomerId($id){
        $bookings   = Booking::where('user_id','=',$id)->get();
        return $bookings;
    }

    public function getBookingRoomByCustomerId($id){
        $booking_room   = BookingRoom::where('user_id','=',$id)->get();
        return $booking_room;
    }
}