<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/13/2017
 * Time: 5:03 PM
 */

namespace App\Setup\RoomCategoryImage;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;

class RoomCategoryImageRepository implements RoomCategoryImageRepositoryInterface
{
    public function getObjs()
    {
        $objs = RoomCategoryImage::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new RoomCategoryImage())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    public function getObjByID($id)
    {
        $obj = RoomCategoryImage::find($id);
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
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created room_category_image_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);


            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a room_category_image and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getRoomCategoryImageByHotelRoomCategoryId($h_room_category_id){
        $objs   = RoomCategoryImage::where('h_room_category_id','=',$h_room_category_id)->get();
        return $objs;
    }

    public function deleteRoomCategoryImageByHotelRoomCateogryId($h_room_category_id,$r_category_image_id){

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        $date    = date("Y-m-d H:i:s");

        try{
            $images = RoomCategoryImage::find($r_category_image_id);
            foreach ($images as $value) {
                Utility::delete_file_in_upload_folder($value->img_path);
            }
            $result = DB::table('r_category_image')
                          ->where('h_room_category_id','=',$h_room_category_id)
                          ->whereIn('id',$r_category_image_id)
                          ->delete();

            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted r_category_image by h_room_category_id = '.$h_room_category_id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  r_category_image by h_room_category_id = ' .$h_room_category_id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function getRoomCategoryImageByHotelRoomCategoryIdArray($h_room_category_id_array){
        $result   = RoomCategoryImage::whereIn('h_room_category_id', $h_room_category_id_array)->get();
        return $result;
    }
}