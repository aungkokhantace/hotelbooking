<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/12/2017
 * Time: 10:23 AM
 */

namespace App\Setup\BookingPerson;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;

class BookingPersonRepository implements BookingPersonRepositoryInterface
{

    public function create($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $userSession = session('customer');
            $loginUserId = $userSession['id'];

            $booking_id     = $paramObj->booking_id;
            $adult_count    = $paramObj->adult_count;
            $children_count = $paramObj->children_count;
            $room_count     = $paramObj->room_count;

            DB::table('booking_person')->insert([
                'booking_id'      => $booking_id,
                'adult_count'     => $adult_count,
                'children_count'  => $children_count,
                'room_count'      => $room_count
            ]);

            //create info log
            $date = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'info: ' . 'Customer '.$loginUserId.' created a booking_person with booking_id = '.$booking_id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['object'] = $paramObj;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Customer '.$loginUserId.' created a booking_person and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getObjsByBookingId($b_id){
        $result = BookingPerson::whereNull('deleted_at')
                                ->where('booking_id',$b_id)
                                ->first();
        return $result;
    }
}
