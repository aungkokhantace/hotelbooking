<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/1/2017
 * Time: 4:44 PM
 */

namespace App\Setup\BookingSpecialRequest;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;

class BookingSpecialRequestRepository implements BookingSpecialRequestRepositoryInterface
{
    public function getMaxOrder($booking_id){
        $result = BookingSpecialRequest::whereNull('deleted_at')->where('booking_id',$booking_id)->max('order');

        return $result;
    }

    public function create($paramObj)
    {
        $returnedObj                            = array();
        $returnedObj['aceplusStatusCode']       = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser                            = Utility::getCurrentCustomerID();

        try {
            $tempObj                            = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            //create info log
            $date                               = $paramObj->created_at;
            $message                            = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created communication_id = '.
                                                    $tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode']   = ReturnMessage::OK;
            $returnedObj['object']              = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'User '.$currentUser.
                                                  ' created a communication_id and got error -------'.$e->getMessage(). ' ----- line ' .
                                                  $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }
}