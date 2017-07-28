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
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Mail;

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

    public function sendMail($template,$emails,$subject,$logMessage){
        $returnedObj                        = array();
        $returnedObj['aceplusStatusCode']   = ReturnMessage::OK;

        try{
            Mail::send($template, [], function($message) use($emails,$subject)
            {
                $message->to($emails)
                        ->subject($subject);
            });

            return $returnedObj;
        }
        catch(\Exception $e){

            $currentUser                        = Utility::getCurrentCustomerID();
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Mail is not sent when Customer - '.$currentUser.
                                                  ' '.$logMessage.' got error -------'.$e->getMessage(). ' ----- line ' .
                                                  $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::create($date,$message);
            $returnedObj['aceplusStatusCode']   = ReturnMessage::SERVICE_UNAVAILABLE;

            return $returnedObj;
        }
    }
}