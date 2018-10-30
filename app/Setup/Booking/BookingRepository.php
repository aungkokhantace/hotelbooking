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
use App\Setup\Room\Room;
use App\Setup\RoomAvailablePeriod\RoomAvailablePeriod;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Mail;

class BookingRepository implements BookingRepositoryInterface
{
    public function getBookingByCustomerId($id){
        $bookings   = Booking::where('user_id','=',$id)
                              ->whereNull('deleted_at')
                              ->orderBy('updated_at','desc')
                              ->get();
        return $bookings;
    }

    public function getBookingRoomByCustomerId($id){
        $statusAry = array(2,5);
        $booking_room   = BookingRoom::whereIn('status',$statusAry)->where('user_id','=',$id)->get();
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

    // if $cron_flag is set, function is called by cron job
    public function update($paramObj,$cron_flag = null)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $userSession            = session('customer');
            $loginUserId            = $userSession['id'];
            $paramObj->updated_by   = $loginUserId;
            $paramObj->save();

            //create info log
            // prepare info log content
            $date = $paramObj->updated_at;
            $message = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' updated booking_id = '.$paramObj->id . PHP_EOL;

            // check whether cron log or operation log
            if(isset($cron_flag) && $cron_flag !== null){
              // function is called by cron, and write cron log
              LogCustom::createCronLog($date,$message);
            }
            else{
              // function is called by frontend or backend operations, and write normal transaction log
              LogCustom::create($date,$message);
            }

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' updated a booking and got error -------'.
                        $e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            // check whether cron log or operation log
            if(isset($cron_flag) && $cron_flag !== null){
              // function is called by cron, and write cron log
              LogCustom::createCronLog($date,$message);
            }
            else{
              // function is called by frontend or backend operations, and write normal transaction log
              LogCustom::create($date,$message);
            }

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getBookingById($id){
        $result = Booking::find($id);

        return $result;
    }

    public function getConfirmBooking(){
//        $result = DB::select("SELECT *
//                              FROM bookings
//                              WHERE status = 2
//                              AND deleted_at IS NULL
//                            ");
        $result = DB::select("SELECT bookings.*,h_config.cancellation_days,core_users.email
                              FROM bookings
                              JOIN hotels
                              ON bookings.hotel_id = hotels.id
                              JOIN h_config
                              ON hotels.id = h_config.hotel_id
                              JOIN core_users
                              ON bookings.user_id = core_users.id
                              WHERE bookings.status = 2
                              AND bookings.deleted_at is NULL

                            ");

        return $result;
    }

    public function getObjs() {
        $objs       = Booking::all()->sortByDesc('id')->where('deleted_at',null);
        return $objs;
    }

    public function getUserObjs() {
        $id     = Auth::guard('User')->user()->id;
        $objs   = User::select('id','email','role_id')->where('id',$id)->whereNull('deleted_at')->first();
        return $objs;
    }

    public function getBookingByHotelId($hotel_id) {
        $objs   = Booking::where('hotel_id',$hotel_id)->whereNull('deleted_at')->get();
        return $objs;
    }

    public function checkHasPermission($id,$h_id)
    {
        $hasPermission = DB::select("SELECT count(id) as rowCount FROM bookings WHERE id = '$id' AND hotel_id = '$h_id' AND deleted_at IS  NULL");
        $count = $hasPermission[0]->rowCount;
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getBookingByBookIdAndUserId($b_id,$u_id){
        $result     = Booking::where('user_id',$u_id)
                             ->where('id',$b_id)
                             ->whereNull('deleted_at')
                             ->get();

        return $result;

    }

    public function changeBookingStatus($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try{
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            $returnedObj['aceplusStatusMessage']    = "Request Success";
            $returnedObj['aceplusStatusCode']       = ReturnMessage::OK;
            return $returnedObj;

        }
        catch(\Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getAvailableRoom($check_in,$check_out,$room_id_arr){
        $id             = implode("','",$room_id_arr);
        // $statusArr      = array(3,7,9);
        //check for blacked out rooms between check_in date and check_out date
        $blackout_query = DB::select("SELECT room_id
                                      FROM r_blackout_period
                                      WHERE (
                                      ('$check_in' BETWEEN r_blackout_period.from_date AND r_blackout_period.to_date)
                                      OR
                                      ('$check_out' BETWEEN r_blackout_period.from_date AND r_blackout_period.to_date))
                                      AND (r_blackout_period.deleted_at IS NULL)");

        //create blackout array
        $blackout_arr = array();
        if(isset($blackout_query) && count($blackout_query) > 0){
            foreach($blackout_query as $blackout){
                array_push($blackout_arr,$blackout->room_id);
            }
        }

        //check for booked rooms between check_in date and check_out date
        // $booking_query = DB::select("SELECT booking_room.room_id
	      //                             FROM booking_room
	      //                             WHERE (
	      //                               ('$check_in' BETWEEN booking_room.check_in_date AND booking_room.check_out_date)
	      //                             OR
	      //                               ('$check_out' BETWEEN booking_room.check_in_date AND booking_room.check_out_date)
	      //                               )
        //
        //                               AND status NOT IN (3,7,9)
	      //                             AND (booking_room.deleted_at IS NULL)
	      //                             AND  room_id NOT IN ('$id')");

        // booking filter query
        $booking_query = DB::select("SELECT booking_room.room_id,booking_room.id
	                                  FROM booking_room

                                    WHERE (
                                      ('$check_in' <= booking_room.check_in_date AND '$check_out' > booking_room.check_in_date AND '$check_out' <= booking_room.check_out_date) OR
                                      ('$check_in' <= booking_room.check_in_date AND '$check_out' = booking_room.check_out_date) OR
                                      ('$check_in' <= booking_room.check_in_date AND '$check_out' >= booking_room.check_out_date) OR
                                      ('$check_in' = booking_room.check_in_date AND '$check_out' >= booking_room.check_in_date AND '$check_out' <= booking_room.check_out_date) OR
                                      ('$check_in' = booking_room.check_in_date AND '$check_out' = booking_room.check_out_date) OR
                                      ('$check_in' = booking_room.check_in_date AND '$check_out' >= booking_room.check_out_date) OR
                                      ('$check_in' >= booking_room.check_in_date AND'$check_in' <= booking_room.check_out_date AND '$check_out' <= booking_room.check_out_date) OR
                                      ('$check_in' >= booking_room.check_in_date AND'$check_in' <= booking_room.check_out_date AND '$check_out' = booking_room.check_out_date) OR
                                      ('$check_in' >= booking_room.check_in_date AND'$check_in' < booking_room.check_out_date AND '$check_out' >= booking_room.check_out_date)
                                    )

	                                  AND (booking_room.status NOT IN (3,7,8,9))
	                                  AND (booking_room.deleted_at IS NULL)"); //"status = 3,7,8,9" is cancel

        //create booking array
        $booking_arr = array();
        if(isset($booking_query) && count($booking_query) > 0){
            foreach($booking_query as $booking){
                array_push($booking_arr,$booking->room_id);
            }
        }

        //check for room cutoff date
        $cutoff_query = DB::select("SELECT rooms.id as room_id,h_room_category.booking_cutoff_day as cutoff_day
                                    FROM rooms
                                    LEFT JOIN h_room_category ON rooms.h_room_category_id = h_room_category.id
                                    WHERE (rooms.apply_cutoff_date = 1)
                                    AND (rooms.deleted_at IS NULL) AND (h_room_category.deleted_at IS NULL)");

        //create cutoff array
        $cutoff_arr = array();
        $today = date("Y-m-d");
        if(isset($cutoff_query) && count($cutoff_query) > 0){
            foreach($cutoff_query as $cutoff){
                $cutoff_day = $cutoff->cutoff_day;
                $tempDate = strtotime(date("Y-m-d", strtotime($check_in)) . " -".$cutoff_day."days");
                $calculatedCutoffDate = date("Y-m-d",$tempDate);

                if(($today >= $calculatedCutoffDate)){
                    array_push($cutoff_arr,$cutoff->room_id);
                }
            }
        }

        //get rooms that are within available_period and not within black_out period and not booked and not in cutoff date
        $result = Room::whereNull('rooms.deleted_at')
                        ->leftJoin('r_available_period', 'r_available_period.room_id', '=', 'rooms.id')
                        ->where('r_available_period.from_date','<=',$check_in)
                        ->where('r_available_period.to_date','>=',$check_out)
                        ->whereNotIn('rooms.id', $blackout_arr)
                        ->whereNotIn('rooms.id', $booking_arr)
                        ->whereNotIn('rooms.id', $cutoff_arr)
                        ->whereIn('rooms.id',$room_id_arr)
                        ->select('rooms.*')
                        ->get();

        return $result;

    }

    public function checkBookingByHotelId($hotel_id){
      $booking_status_array = [1,2]; //pending and confirm

      //get bookings with $hotel_id and status is pending and confirm (not completed nor cancel)
      //if exists user is not allowed to disable this hotel
      $result = Booking::where('hotel_id','=',$hotel_id)
                    ->whereIn('status',$booking_status_array)
                    ->get();

      return $result;
    }
}
