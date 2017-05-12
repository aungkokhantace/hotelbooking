<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/15/2017
 * Time: 9:57 PM
 */

namespace App\Setup\Room;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use App\Setup\RoomBlackoutPeriod\RoomBlackoutPeriod;
use Illuminate\Support\Facades\DB;

class RoomRepository implements RoomRepositoryInterface
{
    public function getObjs()
    {
        $objs = Room::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new Room())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    public function getObjByID($id)
    {
        $obj = Room::find($id);
        return $obj;
    }

    public function create($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            //create info log
            $date = $tempObj->created_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created room_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);


            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a room and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function update($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            //update info log
            $date = $tempObj->updated_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' updated room_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //update error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' updated room_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function delete($id)
    {
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try{
            $tempObj = Room::find($id);
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();

            //delete info log
            $date = $tempObj->deleted_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted room_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  room_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function getObjsByHotelId($hotel_id){
        $rooms = Room::select('id','hotel_id','name')
                                     ->where('hotel_id','=',$hotel_id)
                                     ->get();

        return $rooms;
    }

    public function getRoomCountByRoomCategoryId($r_category_id,$check_in,$check_out) {
        //change date formats of check_in and check_out
        $newCheckIn  = date("Y-m-d", strtotime($check_in));
        $newCheckOut = date("Y-m-d", strtotime($check_out));

        //check for blacked out rooms between check_in date and check_out date
        $blackout_query = DB::select("SELECT room_id
                                      FROM r_blackout_period
                                      WHERE (r_blackout_period.from_date BETWEEN '$newCheckIn' AND '$newCheckOut') OR (r_blackout_period.to_date BETWEEN '$newCheckIn' AND '$newCheckOut')");
        //push to array
        $blackout_arr = array();
        foreach($blackout_query as $blackout){
            array_push($blackout_arr,$blackout->room_id);
        }

        //check for booked rooms between check_in date and check_out date
        /*$booking_query = DB::select("SELECT bookings.room_id
	                                  FROM bookings
	                                  WHERE (bookings.check_in_date BETWEEN '$newCheckIn' AND '$newCheckOut') OR (bookings.check_out_date BETWEEN '$newCheckIn' AND '$newCheckOut')"); */

        $booking_query = DB::select("SELECT booking_room.room_id
	                                  FROM booking_room
	                                  WHERE ((booking_room.check_in_date BETWEEN '$newCheckIn' AND '$newCheckOut') OR (booking_room.check_out_date BETWEEN '$newCheckIn' AND '$newCheckOut')) AND (booking_room.status <> 3)");

        //push to array
        $booking_arr = array();
        foreach($booking_query as $booking){
            array_push($booking_arr,$booking->room_id);
        }

        //get rooms that are within available_period and not within black_out period and not booked
        $result = Room::whereNull('rooms.deleted_at')
                    ->leftjoin('r_available_period', 'r_available_period.room_id', '=', 'rooms.id')
                    ->where('h_room_category_id',$r_category_id)
                    ->where('r_available_period.from_date','<=',$newCheckIn)
                    ->where('r_available_period.to_date','>=',$newCheckOut)
                    ->whereNotIn('rooms.id', $blackout_arr)
                    ->whereNotIn('rooms.id', $booking_arr)
                    ->get();
        return $result;
    }
}