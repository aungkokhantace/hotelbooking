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
use Auth;
use App\User;
use App\Setup\Hotel\Hotel;

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
        $rooms = Room::select('id','hotel_id','name','h_room_type_id','h_room_category_id','room_view_id','description','status','remark')
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
                                      WHERE (('$newCheckIn' BETWEEN r_blackout_period.from_date AND r_blackout_period.to_date) OR ('$newCheckOut' BETWEEN r_blackout_period.from_date AND r_blackout_period.to_date))
                                      AND (r_blackout_period.deleted_at IS NULL)");

        //push to array
        $blackout_arr = array();
        foreach($blackout_query as $blackout){
            array_push($blackout_arr,$blackout->room_id);
        }

        //check for booked rooms between check_in date and check_out date
        /*$booking_query = DB::select("SELECT bookings.room_id,
	                                  FROM bookings
	                                  WHERE (bookings.check_in_date BETWEEN '$newCheckIn' AND '$newCheckOut') OR (bookings.check_out_date BETWEEN '$newCheckIn' AND '$newCheckOut')"); */

        //before modifying check-in and check-out dates as exclusive
        /*$booking_query = DB::select("SELECT booking_room.room_id
	                                  FROM booking_room
	                                  WHERE (('$newCheckIn' BETWEEN booking_room.check_in_date AND booking_room.check_out_date) OR (('$newCheckOut' BETWEEN booking_room.check_in_date AND booking_room.check_out_date)))
	                                  AND (booking_room.status <> 3)
                                      AND (booking_room.deleted_at IS NULL)"); //"status = 3" is cancel */

        $booking_query = DB::select("SELECT booking_room.room_id
	                                  FROM booking_room
	                                --   WHERE (('$newCheckIn' > booking_room.check_in_date AND '$newCheckIn' < booking_room.check_out_date) OR ('$newCheckOut' > booking_room.check_in_date AND '$newCheckOut' < booking_room.check_out_date) OR ('$newCheckOut' > booking_room.check_in_date AND '$newCheckOut' < booking_room.check_out_date) OR ('$newCheckIn' < booking_room.check_in_date AND '$newCheckOut' > booking_room.check_out_date))
	                                  WHERE (('$newCheckIn' > booking_room.check_in_date AND '$newCheckIn' < booking_room.check_out_date) OR ('$newCheckOut' > booking_room.check_in_date AND '$newCheckOut' < booking_room.check_out_date) OR ('$newCheckOut' > booking_room.check_in_date AND '$newCheckOut' < booking_room.check_out_date) OR ('$newCheckIn' < booking_room.check_in_date AND '$newCheckOut' > booking_room.check_out_date) OR ('$newCheckIn' = booking_room.check_in_date AND '$newCheckOut' = booking_room.check_out_date))
	                                  AND (booking_room.status NOT IN (3,7,8,9))
	                                  AND (booking_room.deleted_at IS NULL)"); //"status = 3,7,8,9" is cancel

        //push to array
        $booking_arr = array();
        foreach($booking_query as $booking){
            array_push($booking_arr,$booking->room_id);
        }

        //check for room cutoff date
        $cutoff_query = DB::select("SELECT rooms.id as room_id,h_room_category.booking_cutoff_day as cutoff_day
                                      FROM rooms
                                      LEFT JOIN h_room_category ON rooms.h_room_category_id = h_room_category.id
                                      WHERE (rooms.apply_cutoff_date = 1)
                                      AND (rooms.deleted_at IS NULL) AND (h_room_category.deleted_at IS NULL)");

        //push to array
        $cutoff_arr = array();
        $today = date("Y-m-d");
        foreach($cutoff_query as $cutoff){
            $cutoff_day = $cutoff->cutoff_day;
            $tempDate = strtotime(date("Y-m-d", strtotime($newCheckIn)) . " -".$cutoff_day."days");
            $calculatedCutoffDate = date("Y-m-d",$tempDate);

            if(($today >= $calculatedCutoffDate)){
                array_push($cutoff_arr,$cutoff->room_id);
            }
        }

        //get rooms that are within available_period and not within black_out period and not booked and not in cutoff date
        $result = Room::whereNull('rooms.deleted_at')
                    ->leftjoin('r_available_period', 'r_available_period.room_id', '=', 'rooms.id')
                    ->where('h_room_category_id',$r_category_id)
                    ->where('r_available_period.from_date','<=',$newCheckIn)
                    ->where('r_available_period.to_date','>=',$newCheckOut)
                    ->whereNotIn('rooms.id', $blackout_arr)
                    ->whereNotIn('rooms.id', $booking_arr)
                    ->whereNotIn('rooms.id', $cutoff_arr)
                    ->select('rooms.*')
                    ->get();

        return $result;
    }

    //for getting array to use in PaymentController
    //Room Search Query
    public function getRoomArrayByRoomCategoryId($r_category_id,$check_in,$check_out) {
        //change date formats of check_in and check_out
        $newCheckIn  = date("Y-m-d", strtotime($check_in));
        $newCheckOut = date("Y-m-d", strtotime($check_out));

        //check for blacked out rooms between check_in date and check_out date
        $blackout_query = DB::select("SELECT room_id
                                      FROM r_blackout_period
                                      WHERE (('$newCheckIn' BETWEEN r_blackout_period.from_date AND r_blackout_period.to_date) OR ('$newCheckOut' BETWEEN r_blackout_period.from_date AND r_blackout_period.to_date))
                                      AND (r_blackout_period.deleted_at IS NULL)");

        //push to array
        $blackout_arr = array();
        foreach($blackout_query as $blackout){
            array_push($blackout_arr,$blackout->room_id);
        }

        //check for booked rooms between check_in date and check_out date
        /*
        $booking_query = DB::select("SELECT booking_room.room_id
	                                  FROM booking_room
	                                  WHERE (('$newCheckIn' BETWEEN booking_room.check_in_date AND booking_room.check_out_date) OR (('$newCheckOut' BETWEEN booking_room.check_in_date AND booking_room.check_out_date)))
	                                  AND (booking_room.status <> 3)
                                      AND (booking_room.deleted_at IS NULL)");*/

        $booking_query = DB::select("SELECT booking_room.room_id
	                                 FROM booking_room
	                                 WHERE (('$newCheckIn' > booking_room.check_in_date AND '$newCheckIn' < booking_room.check_out_date) OR
                                            ('$newCheckOut' > booking_room.check_in_date AND '$newCheckOut' < booking_room.check_out_date) OR
                                            ('$newCheckOut' > booking_room.check_in_date AND '$newCheckOut' < booking_room.check_out_date) OR
                                            ('$newCheckIn' < booking_room.check_in_date AND '$newCheckOut' > booking_room.check_out_date) OR
                                            ('$newCheckIn' = booking_room.check_in_date AND '$newCheckOut' = booking_room.check_out_date))
	                                 AND (booking_room.status NOT IN (3,7,8,9))
	                                 AND (booking_room.deleted_at IS NULL)"); //"status = 3,7,8,9" is cancel

        //push to array
        $booking_arr = array();
        foreach($booking_query as $booking){
            array_push($booking_arr,$booking->room_id);
        }

        //get rooms that are within available_period and not within black_out period and not booked
        $result = Room::whereNull('rooms.deleted_at')
            ->leftjoin('r_available_period', 'r_available_period.room_id', '=', 'rooms.id')
//            ->where('h_room_category_id',$r_category_id)
            ->whereIn('h_room_category_id',$r_category_id)
            ->where('r_available_period.from_date','<=',$newCheckIn)
            ->where('r_available_period.to_date','>=',$newCheckOut)
            ->whereNotIn('rooms.id', $blackout_arr)
            ->whereNotIn('rooms.id', $booking_arr)
            ->select('rooms.*')
            ->get()
            ->toArray();

        return $result;
    }

    public function getUserObjs() {
        $id     = Auth::guard('User')->user()->id;
        $objs   = User::select('id','email','role_id')->where('id',$id)->whereNull('deleted_at')->first();
        return $objs;
    }

    public function getRoomWithDiscount($category_arr,$r_available_arr){
        $result = Room::leftJoin('h_room_category','h_room_category.id','=','rooms.h_room_category_id')
                ->whereIn('h_room_category.id',$category_arr)
                ->leftJoin('room_discount','h_room_category.id','=','room_discount.h_room_category_id')
//                ->leftJoin('booking_room','booking_room.room_id','=','rooms.id')
                ->whereNull('rooms.deleted_at')
                ->whereNull('h_room_category.deleted_at')
                ->whereNull('room_discount.deleted_at')
                ->whereIn('rooms.id',$r_available_arr)
                ->select('rooms.*',
                         'h_room_category.extra_bed_price',
                         'h_room_category.price',
                         'room_discount.type as discount_type',
                         'room_discount.from_date as discount_start_date',
                         'room_discount.to_date as discount_end_date',
                         'room_discount.discount_percent',
                         'room_discount.discount_amount'
//                         'booking_room.added_extra_bed'
                        )
            ->get();
        return $result;
    }

    public function checkToDelete($id){
      // pending and confirm
        $not_to_delete_status_arr = [1,2];
        $result = DB::select("SELECT * FROM booking_room WHERE room_id = $id AND status IN ( '" . implode( "', '" , $not_to_delete_status_arr ) . "' ) AND deleted_at IS NULL");
        return $result;
    }

    // public function checkRoomName($name){
    //   $result = $objs = Room::whereNull('deleted_at')->where('name',$name)->get();
    //   return $result;
    // }
}
