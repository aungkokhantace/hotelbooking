<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-10-04
 * Time: 02:29 PM
 */

namespace App\Setup\BookingCancellationDate;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;

class BookingCancellationDateRepository implements BookingCancellationDateRepositoryInterface
{
    public function create($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $userSession = session('customer');
            $loginUserId = $userSession['id'];

            $booking_id                        = $paramObj->booking_id;
            $first_cancellation_day_count      = $paramObj->first_cancellation_day_count;
            $second_cancellation_day_count     = $paramObj->second_cancellation_day_count;

            DB::table('booking_cancellation_dates')->insert([
                'booking_id'      => $booking_id,
                'first_cancellation_day_count'  => $first_cancellation_day_count,
                'second_cancellation_day_count' => $second_cancellation_day_count
            ]);

            //create info log
            $date = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' created a booking_cancellation_date with booking_id = '.$booking_id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' created a booking_cancellation_date and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getObjsByBookingId($b_id){
        $result = BookingCancellationDate::whereNull('deleted_at')
                                ->where('booking_id',$b_id)
                                ->first();
        return $result;
    }
}
