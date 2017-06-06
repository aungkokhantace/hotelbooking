<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/11/2017
 * Time: 3:40 PM
 */

namespace App\Setup\Booking;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
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

    public function create($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $userSession = session('customer');
            $loginUserId = $userSession['id'];
            $paramObj->updated_by = $loginUserId;
            $paramObj->created_by = $loginUserId;
            $paramObj->save();

            //create info log
            $date = $paramObj->created_at;
            $message = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' created booking_id = '.$paramObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' created a booking and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getBookingById($id){
        $result = Booking::find($id);

        return $result;
    }
}