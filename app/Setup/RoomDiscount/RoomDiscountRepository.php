<?php
namespace App\Setup\RoomDiscount;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * Author: Khin Zar Ni Wint
 * Date: 3/20/2017
 * Time: 4:51 PM
 */
class RoomDiscountRepository implements RoomDiscountRepositoryInterface
{
    public function getObjs()
    {
        $objs = RoomDiscount::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new RoomDiscount())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    public function getObjByID($id)
    {
        $obj = RoomDiscount::find($id);
        return $obj;
    }

    public function create($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            //create info log
            $date = $tempObj->created_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created r_category_facility_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);


            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a room_category_facility and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function update($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            //update info log
            $date = $tempObj->updated_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' updated room_category_facility_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //update error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' updated room_category_facility_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function delete($id)
    {
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try{
            $tempObj = RoomDiscount::find($id);
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();

            //delete info log
            $date = $tempObj->deleted_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted room_category_facility_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  room_category_facility_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function getDiscountPercentByUniqueHotel()
    {
        //get current date to check between from_date and to_date
        $today = Carbon::today()->toDateString();
        $objs = DB::table('room_discount')
            ->select(DB::raw('hotel_id, max(discount_percent) as discount_percent'))
            ->whereNull('deleted_at')
            ->where('from_date','<=', $today)
            ->where('to_date','>=', $today)
            ->where('type','=','%')
            ->where('discount_percent','!=',0)
            ->groupBy('hotel_id')
            ->orderBy('discount_percent','desc')
            ->get();
        return $objs;
    }

    public function getDiscountAmountByUniqueHotel($percentHotelIDs)
    {
        //get current date to check between from_date and to_date
        $today = Carbon::today()->toDateString();
        $objs = DB::table('room_discount')
            ->select(DB::raw('hotel_id, max(discount_amount) as discount_amount'))
            ->whereNull('deleted_at')
            ->where('from_date','<=', $today)
            ->where('to_date','>=', $today)
            ->where('type','=','amount')
            ->where('discount_amount','!=',0.00)
            ->whereNotIn('hotel_id', $percentHotelIDs) //for assurance that selected hotels are not already included in percentage_promotion
            ->groupBy('hotel_id')
            ->orderBy('discount_amount','desc')
            ->get();
        return $objs;
    }

    public function getMaximumDiscountPercentByHotelID($hotel_id)
    {
        //get current date to check between from_date and to_date
        $today = Carbon::today()->toDateString();
        $result = DB::table('room_discount')
            ->select(DB::raw('max(discount_percent) as discount_percent'))
            ->whereNull('deleted_at')
            ->where('from_date','<=', $today)
            ->where('to_date','>=', $today)
            ->where('type','=','%')
            ->where('discount_percent','!=',0)
            ->where('hotel_id','=',$hotel_id)
            ->groupBy('hotel_id')
            ->orderBy('discount_percent','desc')
            ->first();

        return $result;
    }

    public function getMaximumDiscountAmountByHotelID($hotel_id)
    {
        //get current date to check between from_date and to_date
        $today = Carbon::today()->toDateString();
        $result = DB::table('room_discount')
            ->select(DB::raw('max(discount_amount) as discount_amount'))
            ->whereNull('deleted_at')
            ->where('from_date','<=', $today)
            ->where('to_date','>=', $today)
            ->where('type','=','amount')
            ->where('discount_amount','!=',0.00)
            ->where('hotel_id','=',$hotel_id)
            ->groupBy('hotel_id')
            ->orderBy('discount_percent','desc')
            ->first();

        return $result;
    }

    public function getDiscountByRoomCategory($room_category_id)
    {
        $result = RoomDiscount::whereNull('deleted_at')
                    ->where('h_room_category_id','=',$room_category_id)
                    ->first();
        return $result;
    }
}