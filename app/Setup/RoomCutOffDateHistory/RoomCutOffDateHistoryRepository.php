<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/10/2017
 * Time: 3:15 PM
 */

namespace App\Setup\RoomCutOffDateHistory;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;

class RoomCutOffDateHistoryRepository implements RoomCutOffDateHistoryRepositoryInterface
{
    public function getObjs()
    {
        $objs = RoomCutOffDateHistory::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new RoomCutOffDateHistory())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    public function getObjByID($id)
    {
        $obj = RoomCutOffDateHistory::find($id);
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
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created r_cutoff_date_history_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);


            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a r_cutoff_date_history and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }
}