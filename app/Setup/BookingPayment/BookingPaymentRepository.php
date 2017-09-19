<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/12/2017
 * Time: 10:23 AM
 */

namespace App\Setup\BookingPayment;


use App\Core\ReturnMessage;
use App\Log\LogCustom;

class BookingPaymentRepository implements BookingPaymentRepositoryInterface
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
            $message = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' created booking_payment_id = '.$paramObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' created a booking payment and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function update($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $userSession = session('customer');
            $loginUserId = $userSession['id'];
            $paramObj->updated_by = $loginUserId;
//            $paramObj->created_by = $loginUserId;
            $paramObj->save();

            //create info log
            $date = $paramObj->created_at;
            $message = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' updated booking_payment_id = '.$paramObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' updated a booking payment and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getObjsByBookingId($b_id){
        $result = BookingPayment::whereNull('deleted_at')
                                ->where('booking_id',$b_id)
                                ->first();
        return $result;
    }
}