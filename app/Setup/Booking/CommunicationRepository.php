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
use App\Setup\BookingSpecialRequest\BookingSpecialRequest;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class CommunicationRepository implements CommunicationRepositoryInterface
{

    public function create($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser = Utility::getCurrentUserID();

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            //create info log
            $date = $paramObj->created_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created communication_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a communication_id and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getObjs() {
        $objs       = Communication::all()->sortByDesc('id')->where('deleted_at',null);
        return $objs;
    }

    public function getCommunicationBooking($id_arr) {
        $objs       = Booking::whereNull('deleted_at')->whereIn('id',$id_arr)->get();
        return $objs;
    }

    public function getCommunicationCount($id) {
        $bookingCount = DB::select("SELECT count(id) as rowCount FROM booking_special_request WHERE booking_id = '$id' AND deleted_at IS  NULL");
        $count = $bookingCount[0]->rowCount;
        return $count;
    }

    public function getUserObjs() {
        $id     = Auth::guard('User')->user()->id;
        $objs   = User::select('id','email','role_id')->where('id',$id)->whereNull('deleted_at')->first();
        return $objs;
    }

    public function getCommunicationByHotelId($hotel_id,$id_arr) {
        $objs   = Booking::where('hotel_id',$hotel_id)->whereNull('deleted_at')->whereIn('id',$id_arr)->get();
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

    public function createForFrontend($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser = Utility::getCurrentCustomerID();

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            //create info log
            $date = $paramObj->created_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created communication_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a communication_id and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getCommunicationByBookingId($booking_id){
        $result = BookingSpecialRequest::where('booking_id',$booking_id)
                                        ->whereNull('deleted_at')
                                        ->orderBy('order', 'asc')
                                        ->get();

        return $result;
    }
}