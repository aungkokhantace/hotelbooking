<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/8/2017
 * Time: 5:28 PM
 */

namespace App\Setup\HotelRoomCategory;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use App\Setup\HotelRoomCategory\HotelRoomCategory;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use App\Setup\Hotel\Hotel;

class HotelRoomCategoryRepository implements HotelRoomCategoryRepositoryInterface
{
    public function getObjs()
    {
        $objs = HotelRoomCategory::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new HotelRoomCategory())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    public function getObjByID($id)
    {
        $obj = HotelRoomCategory::find($id);
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
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created hotel_room_category_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);


            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['lastId']            = $tempObj->id;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a hotel_room_category and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
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
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' updated hotel_room_category_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //update error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' updated hotel_room_category_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function delete($id)
    {
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try{
            $tempObj = HotelRoomCategory::find($id);
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();

            //delete info log
            $date = $tempObj->deleted_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted hotel_room_category_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  hotel_room_category_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function getHotelRoomCategoryWithRoomTypeId($h_room_type_id){
        $objs   = HotelRoomCategory::select('id','h_room_type_id','name')
                                     ->where('h_room_type_id','=',$h_room_type_id)
                                     ->get();

        return $objs;
    }

    public function getMinPriceByHotelId($hotel_id){
        $price = HotelRoomCategory::whereNull('deleted_at')->where('hotel_id','=',$hotel_id)->min('price');
        return $price;
    }

    public function getRoomTypeByHotelIdAndPrice($hotel_id,$price){
        $room_type = HotelRoomCategory::whereNull('deleted_at')
                    ->where('hotel_id','=',$hotel_id)
                    ->where('price','=',$price)
                    ->first();
        $room_type_name = $room_type->h_room_type->name;
        return $room_type_name;
    }

    public function getRoomCategoriesByHotelId($hotel_id){
        $result = HotelRoomCategory::whereNull('deleted_at')
//                    ->select('id')
                    ->where('hotel_id','=',$hotel_id)
                    ->get();

        return $result;
    }

    public function getUserObjs() {
        $id     = Auth::guard('User')->user()->id;
        $objs   = User::select('id','email','role_id')->where('id',$id)->whereNull('deleted_at')->first();
        return $objs;
    }

    public function getRoomCategoriesByUserId($id) {
        $objs   = HotelRoomCategory::whereNull('deleted_at')->where('hotel_id',$id)->get();
        return $objs;
    }

    public function checkHasPermission($id,$h_id) {
        $hasPermission      = DB::select("SELECT count(id) as rowCount FROM h_room_category WHERE id = '$id' AND hotel_id = '$h_id' AND deleted_at IS  NULL");
        $count              = $hasPermission[0]->rowCount;
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getObjsByIdArr($id_arr){
        $id     = implode("','",$id_arr);
        $result = DB::select("SELECT id,h_room_category.name,hotel_id,capacity
                              FROM h_room_category
                              WHERE id IN ('$id')
                              AND deleted_at IS NULL");

        return $result;

    }
}