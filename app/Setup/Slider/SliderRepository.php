<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/19/2017
 * Time: 10:27 PM
 */

namespace App\Setup\Slider;

use App\Setup\Slider\Slider;
use App\Setup\Template\Template;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;
use File;

class SliderRepository implements SliderRepositoryInterface
{
    public function getObjs()
    {
        $objs       = Slider::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new Template())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    public function getObjByID($id)
    {
        $obj = Slider::find($id);
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
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created slider_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);


            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a slider and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function delete($id)
    {
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try{
            $tempObj = Slider::find($id);
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();

            $deleted_img        = $tempObj->image_url;
//            File::delete('/assets/shared/images/' . $deleted_img);
            unlink(public_path('/assets/shared/images/' . $deleted_img));
            //delete info log
            $date = $tempObj->deleted_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted gallery_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  gallery_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

}