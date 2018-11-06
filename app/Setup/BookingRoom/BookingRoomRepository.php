<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/12/2017
 * Time: 10:23 AM
 */

namespace App\Setup\BookingRoom;


use App\Core\ReturnMessage;
use App\Core\Utility;
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

    public function getNotCancelledBookingRoomByBookingId($id){
        $cancel_status_array = [3,4,6,7,8,9];
        $result     = BookingRoom::whereNull('deleted_at')
                                    ->where('booking_id','=',$id)
                                    ->whereNotIn('status',$cancel_status_array)
                                    ->get();

        return $result;
    }

    public function getNotCancelledBookingRoomByBookingIdAndRoomId($booking_id,$room_id){
        $cancel_status_array = [3,4,6,7,8,9];
        $result     = BookingRoom::whereNull('deleted_at')
                                    ->where('booking_id','=',$booking_id)
                                    ->where('room_id','=',$room_id)
                                    ->whereNotIn('status',$cancel_status_array)
                                    ->first();

        return $result;
    }


    public function getBookingRoomAndRoomByBookingId($id){
        /*
        $result = DB::select("SELECT booking_room.*,
                                     h_room_type.name as room_type,
                                     h_room_category.name as room_category,
                                     rooms.h_room_category_id,
                                     r_category_image.img_path as category_image
                              FROM booking_room
                              LEFT JOIN rooms
                              ON booking_room.room_id = rooms.id
                              LEFT JOIN h_room_type
                              ON rooms.h_room_type_id = h_room_type.id
                              LEFT JOIN h_room_category
                              ON rooms.h_room_category_id = h_room_category.id
                              LEFT JOIN r_category_image
                              ON h_room_category.id = r_category_image.h_room_category_id
                              WHERE booking_room.booking_id = $id
                              AND r_category_image.default_image = 1
                            ");*/
        $statusArr  = array(2,5); //confirm and complete
        $result     = BookingRoom::where('booking_id',$id)
                                 ->leftJoin('rooms','rooms.id','=','booking_room.room_id')
                                 ->leftJoin('h_room_type','h_room_type.id','=','rooms.h_room_type_id')
                                 ->leftJoin('h_room_category','h_room_category.id','=','rooms.h_room_category_id')
                                 // ->leftJoin('r_category_image','r_category_image.h_room_category_id','=','h_room_category.id')
                                 ->select('booking_room.*',
                                          // 'rooms.h_room_category_id',
                                          'h_room_type.name as room_type',
                                          'h_room_category.name as room_category'
                                            // 'r_category_image.img_path as category_image',
                                            // 'r_category_image.default_image as default_image'
                                 )
                                 ->where('booking_id',$id)
                                 // ->where('r_category_image.default_image',1)
                                 // ->orwhereNull('r_category_image.default_image')
                                 ->whereIn('booking_room.status',$statusArr)
                                 ->get();

        return $result;
    }
    public function getObjectById($id){
        $result = BookingRoom::find($id);

        return $result;
    }

    // if $cron_flag is set, function is called by cron job
    public function update($paramObj,$cron_flag = null){
        $returnedObj                            = array();
        $returnedObj['aceplusStatusCode']       = ReturnMessage::INTERNAL_SERVER_ERROR;
        try {
            $userSession                        = session('customer');
            $loginUserId                        = $userSession['id'];
            $paramObj->updated_by               = $loginUserId;
            $paramObj->save();

            //create info log
            $date                               = $paramObj->updated_at;
            $message                            = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' updated booking_room_id = '.$paramObj->id . PHP_EOL;
            // LogCustom::create($date,$message);

            // check whether cron log or operation log
            if(isset($cron_flag) && $cron_flag !== null){
              // function is called by cron, and write cron log
              LogCustom::createCronLog($date,$message);
            }
            else{
              // function is called by frontend or backend operations, and write normal transaction log
              LogCustom::create($date,$message);
            }

            $returnedObj['aceplusStatusCode']   = ReturnMessage::OK;
            $returnedObj['object']              = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' updated a booking room and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            // LogCustom::create($date,$message);

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

    public function getActiveBookingRoom($booking_id){
        $statusArr  = array(2,5);
        $result     = BookingRoom::whereIn('status',$statusArr)->where('booking_id',$booking_id)->get();

        return $result;
    }

    public function getAllBookingRoomAndRoomByBookingId($id){

        $result     = BookingRoom::where('booking_id',$id)
                                 ->leftJoin('rooms','rooms.id','=','booking_room.room_id')
                                 ->leftJoin('h_room_type','h_room_type.id','=','rooms.h_room_type_id')
                                 ->leftJoin('h_room_category','h_room_category.id','=','rooms.h_room_category_id')
                                 ->leftJoin('r_category_image','r_category_image.h_room_category_id','=','h_room_category.id')
                                 ->select('booking_room.*',
                                          'rooms.h_room_category_id',
                                          'h_room_type.name as room_type',
                                          'h_room_category.name as room_category',
                                          'r_category_image.img_path as category_image'
                                 )
                                 // ->where('booking_id',$id)
                                 ->where('r_category_image.default_image',1)
                                 ->get();

        return $result;
    }

    public function updateBookingRoom($paramObj){
        $returnedObj                            = array();
        $returnedObj['aceplusStatusCode']       = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $currentUser                        = Utility::getCurrentUserID(); //get currently logged in user
            $paramObj->save();

            //create info log
            $date                               = $paramObj->updated_at;
            $message                            = '['. $date .'] '. 'info: ' . 'Hotel admin '.$currentUser.' update booking_room_id = '.$paramObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode']   = ReturnMessage::OK;
            $returnedObj['object']              = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Hotel admin '.$currentUser.' updated a booking room and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

}
