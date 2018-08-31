<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/13/2017
 * Time: 5:03 PM
 */

namespace App\Setup\HotelGallery;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem;
use Storage;

class HotelGalleryRepository implements HotelGalleryRepositoryInterface
{
    public function getObjs()
    {
        $objs = HotelGallery::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new HotelGallery())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    public function getObjByID($id)
    {
        $obj = HotelGallery::find($id);
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
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created hotel_gallery_image_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);


            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a hotel_gallery_image and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
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

            //create info log
            $date = $tempObj->created_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' updated hotel_gallery_image_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);


            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' updated a hotel_gallery_image and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getObjsByHotelID($hotel_id){
        $objs   = HotelGallery::where('hotel_id','=',$hotel_id)->get();
        return $objs;
    }

    public function deleteHotelGalleryImageByHotelId($hotel_id,$hotel_gallery_image_id_array){
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        $date    = date("Y-m-d H:i:s");

        try{
            $images = HotelGallery::find($hotel_gallery_image_id_array);
            foreach ($images as $value) {
                Utility::delete_file_in_upload_folder($value->image);
            }
            $result = DB::table('hotel_gallery')
                            ->where('hotel_id','=',$hotel_id)
                            ->whereIn('id',$hotel_gallery_image_id_array)
                            ->delete();

            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted hotel_gallery_image of hotel_id = '.$hotel_id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  hotel_gallery_image of hotel_id = ' .$hotel_id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function delete($id) {
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user
        $date    = date("Y-m-d H:i:s");

        $imageObj = HotelGallery::find($id);
        Utility::delete_file_in_upload_folder($imageObj->image);
        $image_name = $imageObj->image;

        try{
            $result = DB::table('hotel_gallery')
                            ->where('id','=',$id)
                            ->delete();

            //actually deleting image
            // $image_path = "/images/upload/".$image_name;  // Value is not URL but directory file path

            // if(Storage::exists($image_path)) {
                // Storage::delete($image_path);
            // }

            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted hotel_gallery_image id = '.$id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  hotel_gallery_image id = ' .$id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
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
