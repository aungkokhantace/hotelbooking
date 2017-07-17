<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/12/2017
 * Time: 10:23 AM
 */

namespace App\Setup\BookingRequest;


use App\Core\ReturnMessage;
use App\Log\LogCustom;

class BookingRequestRepository implements BookingRequestRepositoryInterface
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
            $message = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' created booking_request_id = '.$paramObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' created a booking request and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getBookingRequestByBookingId($id){
        $result = BookingRequest::where('booking_id',$id)->first();

        return $result;
    }
}