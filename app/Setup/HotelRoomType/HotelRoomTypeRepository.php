<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/8/2017
 * Time: 5:28 PM
 */

namespace App\Setup\HotelRoomType;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;

class HotelRoomTypeRepository implements HotelRoomTypeRepositoryInterface
{
    public function getObjs()
    {
        $objs = HotelRoomType::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new HotelRoomType())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    public function getObjByID($id)
    {
        $obj = HotelRoomType::find($id);
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
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created hotel_room_type_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);


            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a hotel_room_type and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
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
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' updated hotel_room_type_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //update error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' updated hotel_room_type_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function delete($id)
    {
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try{
            $tempObj = HotelRoomType::find($id);
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();

            //delete info log
            $date = $tempObj->deleted_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted hotel_room_type_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  hotel_room_type_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function getHotelRoomTypeWithHotelId($hotel_id){
        $objs   = HotelRoomType::select('id','hotel_id','name','description')
                                ->where('hotel_id','=',$hotel_id)
                                ->get();

        return $objs;
    }

    public function getUserObjs() {
        $id     = Auth::guard('User')->user()->id;
        $objs   = User::select('id','email','role_id')->where('id',$id)->whereNull('deleted_at')->first();
        return $objs;
    }

    public function getHotelRoomTypeByUserId($id) {
        $objs   = HotelRoomType::whereNull('deleted_at')->where('hotel_id',$id)->get();
        return $objs;
    }

    public function checkHasPermission($id,$h_id) {
        $hasPermission      = DB::select("SELECT count(id) as rowCount FROM h_room_type WHERE id = '$id' AND hotel_id = '$h_id' AND deleted_at IS  NULL");
        $count              = $hasPermission[0]->rowCount;
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteHotelRoomTypeByHotelId($h_id){
        $returnedObj                        = array();
        $returnedObj['aceplusStatusCode']   = ReturnMessage::INTERNAL_SERVER_ERROR;
        try{
            $result                             = DB::delete("delete from h_room_type where hotel_id = ?",[$h_id]);
            
            $returnedObj['aceplusStatusCode']   = ReturnMessage::OK;
            return $returnedObj;            
        }
        catch(\Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
        
    }
}