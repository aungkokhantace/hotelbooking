<?php
/**
 *Author: Aung Ko Khant
 * Date: 2017-11-30
 * Time: 03:55 PM
 */

namespace App\Setup\HotelPolicy;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem;
use Storage;

class HotelPolicyRepository implements HotelPolicyRepositoryInterface
{
    public function getObjs()
    {
        $objs = HotelPolicy::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new HotelPolicy())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    public function getObjByID($id)
    {
        $obj = HotelPolicy::find($id);
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
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created hotel_policy_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);


            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a hotel_policy and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getObjsByHotelID($hotel_id){
        $objs   = HotelPolicy::where('hotel_id','=',$hotel_id)->get();
        return $objs;
    }

    public function deleteHotelPolicyImageByHotelId($hotel_id,$hotel_policy_id_array){
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        $date    = date("Y-m-d H:i:s");

        try{
            $result = DB::table('hotel_policy')
                            ->where('hotel_id','=',$hotel_id)
                            ->whereIn('id',$hotel_policy_id_array)
                            ->delete();

            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted hotel_policy of hotel_id = '.$hotel_id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  hotel_policy of hotel_id = ' .$hotel_id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function delete($id) {
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        $date    = date("Y-m-d H:i:s");

        try{
          $tempObj = HotelPolicy::find($id);
          $tempObj = Utility::addDeletedBy($tempObj);
          $tempObj->deleted_at = date('Y-m-d H:m:i');
          $tempObj->save();

          //delete info log
          $date = $tempObj->deleted_at;
          $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted hotel_policy id = '.$tempObj->id . PHP_EOL;
          LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  hotel_policy id = ' .$id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
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
}
