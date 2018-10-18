<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/12/2017
 * Time: 10:23 AM
 */

namespace App\Setup\BookingPaymentStripe;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;

class BookingPaymentStripeRepository implements BookingPaymentStripeRepositoryInterface
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
            $message = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' created booking_payment_stripe_id = '.$paramObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' created a booking payment stripe and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    // if $cron_flag is set, function is called by cron job
    public function update($paramObj,$cron_flag = null){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $userSession            = session('customer');
            $loginUserId            = $userSession['id'];
            $paramObj->updated_by   = $loginUserId;
            $paramObj->save();

            //create info log
            $date = $paramObj->updated_at;
            $message = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' updated booking_payment_stripe_id = '.$paramObj->id . PHP_EOL;
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

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' created a booking payment stripe and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
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

    public function getStripePaymentId($id){
        $result = BookingPaymentStripe::where('booking_id',$id)->where('status',2)->first();

        return $result;
    }

    public function getStripePaymentIdWithStatusOne($id){
        $result = BookingPaymentStripe::where('booking_id',$id)->where('status',1)->first();

        return $result;
    }

    public function getStripePaymentIdByBookingId($booking_id){
        $result = BookingPaymentStripe::where('booking_id',$booking_id)->first();

        return $result;
    }

    public function createBookingPaymentStripe($paramObj){
        $returnedObj                            = array();
        $returnedObj['aceplusStatusCode']       = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {

            $currentUser                        = Utility::getCurrentUserID(); //get currently logged in user
            $paramObj->save();

            //create info log
            $date                               = $paramObj->created_at;
            $message                            = '['. $date .'] '. 'info: ' . 'Hotel admin '.$currentUser.' created booking_payment_stripe_id = '.$paramObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode']   = ReturnMessage::OK;
            $returnedObj['object']              = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date                   = date("Y-m-d H:i:s");
            $message                = '['. $date .'] '. 'error: ' . 'Hotel admin '.$currentUser.' created a booking_payment_stripe and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getAllBookingPaymentStripeByBookingId($booking_id){
        $result = BookingPaymentStripe::where('booking_id',$booking_id)->get();

        return $result;
    }
}
