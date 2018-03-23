<?php namespace App\Core;
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 7/12/2016
 * Time: 3:27 PM
 */

use App\Core\Config\ConfigRepository;
use App\Log\LogCustom;
use App\Setup\HotelConfig\HotelConfigRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Validator;
use Auth;
//use DB;
use App\Http\Requests;
//use App\Session;
use App\Core\User\UserRepository;
use App\Core\SyncsTable\SyncsTable;
use InterventionImage;
use File;

class Utility
{

    public static function addCreatedBy($newObj)
    {
        $sessionObj = session('user');
        if(isset($sessionObj)){
            $userSession = session('user');
            $loginUserId = $userSession['id'];
            $newObj->updated_by = $loginUserId;
            $newObj->created_by = $loginUserId;
        }
        Utility::updateSyncsTable($newObj);
        return $newObj;
    }

    public static function addUpdatedBy($newObj)
    {
        $sessionObj = session('user');
        if(isset($sessionObj)){
            $userSession = session('user');
            $loginUserId = $userSession['id'];
            $newObj->updated_by = $loginUserId;
        }
        Utility::updateSyncsTable($newObj);
        return $newObj;
    }

    public static function addDeletedBy($newObj)
    {
        $sessionObj = session('user');
        if(isset($sessionObj)){
            $userSession = session('user');
            $loginUserId = $userSession['id'];
            $newObj->deleted_by = $loginUserId;
        }
        Utility::updateSyncsTable($newObj);
        return $newObj;
    }

    public static function updateSyncsTable($newObj)
    {
        $table_name = $newObj->getTable();
        $tempSyncTable = new SyncsTable();
        $syncTableName = $tempSyncTable->getTable();

        $syncTableObj = DB::table($syncTableName)
            ->select('*')
            ->where('table_name' , '=' , $table_name)
            ->first();

        if(isset($syncTableObj) && count($syncTableObj)>0) {
            $id = $syncTableObj->id;
            $version = $syncTableObj->version + 1;
            $syncTable = SyncsTable::find($id);

            $sessionObj = session('user');
            if (isset($sessionObj)) {
                $userSession = session('user');
                $loginUserId = $userSession['id'];
                $syncTable->updated_by = $loginUserId;
            }

            $syncTable->version = $version++;
            $syncTable->save();

        }
    }

    public static function getCurrentUserID(){
        $id = Auth::guard('User')->user()->id;
        return $id;
    }

    public static function saveImage($photo,$path){
        if ( ! file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        //setting photo name
        $photo_name  = $photo->getClientOriginalName();

        // moving image into image folder
        $photo->move($path, $photo_name);

        $rWidth = 1.0;
        $rHeight =  1.0;

        // getting image width and height
        $imgData = getimagesize($path . $photo_name);
        $width = $imgData[0];
        $imgWidth = $width * $rWidth;
        $height = $imgData[1];
        $imgHeight = $height * $rHeight;

        // generate unique id for the image name
        $photo_unique_name = uniqid();

        // resizing image
        $image = InterventionImage::make(sprintf($path .'/%s', $photo_name))
            ->resize($imgWidth, $imgHeight)->save();

        return $photo_name;
    }

    public static function getImage($photo){
        $photo_name = $photo->getClientOriginalName();
        return $photo_name;
    }

    public static function getImageExt($photo){
        $photo_ext = $photo->getClientOriginalExtension();

        return $photo_ext;
    }

    public static function resizeImage($photo,$photo_name,$path){

        if(! file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        $photo->move($path,$photo_name);

        $rWidth     = 1.0;
        $rHeight    = 1.0;

        $imgData    = getimagesize($path . $photo_name);
        $width      = $imgData[0];
        $imgWidth   = $width * $rWidth;
        $height     = $imgData[1];
        $imgHeight  = $height * $rHeight;

        //to avoid "allowed memory size of 134217728 bytes exhausted" issue
        ini_set('memory_limit','256M');

        $image      = InterventionImage::make(sprintf($path . '/%s', $photo_name))
                      ->resize($imgWidth,$imgHeight)->save();

        return $image;

    }

    public static function resizeImageWithDefaultWidthHeight($photo,$photo_name,$path,$width,$height){

        if(! file_exists($path))
        {
            mkdir($path, 0777, true);
        }

        $photo->move($path,$photo_name);

        $rWidth     = 1.0;
        $rHeight    = 1.0;

        $imgWidth   = $width * $rWidth;
        $imgHeight  = $height * $rHeight;

        $image      = InterventionImage::make(sprintf($path . '/%s', $photo_name))
                      ->resize($imgWidth,$imgHeight)->save();

        return $image;

    }

    public static function getCurrentCustomerID(){
        try {
            $id = Auth::guard('Customer')->user()->id;
            return $id;
        }
        catch(\Exception $e){
            $id = 0;
            return $id;
        }
    }

    public static function getServiceTax($hotel_id){

        $hotelConfigRepo = new HotelConfigRepository();
        $hotel_config = $hotelConfigRepo->getConfigByHotel($hotel_id);
        if(isset($hotel_config) && count($hotel_config) > 0){
            $service_tax = $hotel_config->tax;
        }
        else{
            $config_service_tax = DB::select("SELECT * FROM core_configs WHERE `code` = 'SERVICE_TAX'");
            $service_tax = $config_service_tax[0]->value;
        }

        return $service_tax;
    }

    public static function generateBookingNumber() {
        $booking_number = uniqid();
        return $booking_number;
    }

    public static function getSystemAdminMail(){
        $mail_arr   = array('testingsystem2017@gmail.com');

        return $mail_arr;

    }

    public static function sendMail($template,$emails,$subject,$logMessage){
        $returnedObj                        = array();
        $returnedObj['aceplusStatusCode']   = ReturnMessage::OK;

        try{
            Mail::send($template, [], function($message) use($emails,$subject)
            {
                $message->to($emails)
                    ->subject($subject);
            });

            //create mail success log
            $currentUser                        = Utility::getCurrentCustomerID();
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'info: ' . 'Mail is sent to Customer - '.$currentUser.
                ' ----- Log Message: '.$logMessage. PHP_EOL;

            LogCustom::create($date,$message);

            return $returnedObj;
        }
        catch(\Exception $e){
            //create mail error log
            $currentUser                        = Utility::getCurrentCustomerID();
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Mail is not sent when Customer - '.$currentUser.
                ' '.$logMessage.' got error -------'.$e->getMessage(). ' ----- line ' .
                $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::create($date,$message);
            $returnedObj['aceplusStatusCode']   = ReturnMessage::SERVICE_UNAVAILABLE;

            return $returnedObj;
        }
    }

    public static function getPriceFilter(){
        $result     = DB::table('price_filter')->get();

        return $result;
    }

    public static function getPriceFilterById($id){
        $result     = DB::table('price_filter')->find($id);

        return $result;
    }

    public static function createSession($key,$value){
        Session::put($key,$value);
    }

    public static function deleteSession($key){
        Session::forget($key);
    }

    public static function sendVerificationMail($email,$name,$activation_code){
        $returnedObj                        = array();
        $returnedObj['aceplusStatusCode']   = ReturnMessage::OK;

        try{

            Mail::send('frontend.mail.verify', ['activation_code'=>$activation_code,'email'=>$email], function($message) use($email,$name) {
                $message->to($email,$name)
                    ->subject('Verify your email address');
            });


            return $returnedObj;
        }
        catch(\Exception $e){
            $date                               = date("Y-m-d H:i:s");
            $message                            = '['. $date .'] '. 'error: ' . 'Verification Mail is not sent and got error -------'.
                                                  $e->getMessage(). ' ----- line ' .
                                                  $e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;

            LogCustom::create($date,$message);
            $returnedObj['aceplusStatusCode']   = ReturnMessage::SERVICE_UNAVAILABLE;

            return $returnedObj;
        }
    }

    public static function delete_file_in_upload_folder($filename){
        if(PHP_OS == "WINNT"){
            $image_path = public_path().'\images\upload\\'.$filename;
        }else{
            $image_path = public_path().'/images/upload/'.$filename;
        }

            if(File::exists($image_path)){
                File::delete($image_path);
            }
    }

    public static function getCurrentUserRole(){
        $role_id = Auth::guard('User')->user()->role_id;
        return $role_id;
    }
}
