<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/12/2017
 * Time: 10:23 AM
 */

namespace App\Setup\BookingRoom;


use App\Core\ReturnMessage;
use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;

class BookingRoomRepository implements BookingRoomRepositoryInterface
{

    public function create($paramObj){
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
            $message = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' created booking_room_id = '.$paramObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' created a booking room and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getAllBookingRoom(){
        $result     = BookingRoom::whereNull('deleted_at')->get();

        return $result;
    }

    public function getBookingRoomByBookingId($id){
        $result     = BookingRoom::whereNull('deleted_at')->where('booking_id','=',$id)->get();

        return $result;
    }

    public function getBookingRoomAndRoomByBookingId($id){
        $result = DB::select("SELECT booking_room.*,
                                     h_room_type.name as room_type,
                                     h_room_category.name as room_category,
                                     rooms.h_room_category_id,
                                     r_category_image.img_path as category_image
                              FROM booking_room
                              JOIN rooms
                              ON booking_room.room_id = rooms.id
                              JOIN h_room_type
                              ON rooms.h_room_type_id = h_room_type.id
                              JOIN h_room_category
                              ON rooms.h_room_category_id = h_room_category.id
                              JOIN r_category_image
                              ON h_room_category.id = r_category_image.h_room_category_id
                              WHERE booking_room.booking_id = $id
                              AND r_category_image.default_image = 1
                            ");

        return $result;
    }

    public function getObjectById($id){
        $result = BookingRoom::find($id);

        return $result;
    }

    public function update($paramObj){
        $returnedObj                            = array();
        $returnedObj['aceplusStatusCode']       = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $userSession                        = session('customer');
            $loginUserId                        = $userSession['id'];
            $paramObj->updated_by               = $loginUserId;
            $paramObj->save();

            //create info log
            $date                               = $paramObj->updated_at;
            $message                            = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' update booking_room_id = '.$paramObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode']   = ReturnMessage::OK;
            $returnedObj['object']              = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' updated a booking room and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }
}