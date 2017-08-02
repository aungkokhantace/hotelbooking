<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/11/2017
 * Time: 3:40 PM
 */

namespace App\Setup\CsvImport;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use Carbon\Carbon;
use App\Setup\Country\Country;
use App\Setup\City\City;
use App\Setup\Township\Township;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class CsvImportRepository implements CsvImportRepositoryInterface
{
    public function createAmenities($insert_val) {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');

        try {
            $insert_val         = "'" . $insert_val . 
                                  "'," . "'" . $currentUser . 
                                  "','" . $currentUser . 
                                  "','" . $today . 
                                  "','" . $today . "'";
            DB::insert("INSERT INTO amenities (name,icon,description,created_by,updated_by,created_at,updated_at) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a import csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function createFeatures($insert_val) {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');

        try {
            $insert_val         = "'" . $insert_val . 
                                  "'," . "'" . $currentUser . 
                                  "','" . $currentUser . 
                                  "','" . $today . 
                                  "','" . $today . "'";
            DB::insert("INSERT INTO features (name,icon,description,created_by,updated_by,created_at,updated_at) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a import csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function createFacilityGroup($insert_val) {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');
        
        try {
            $insert_val         = "'" . $insert_val . 
                                  "'," . "'" . $currentUser . 
                                  "','" . $currentUser . 
                                  "','" . $today . 
                                  "','" . $today . "'";
            DB::insert("INSERT INTO facility_group (name,icon,remark,created_by,updated_by,created_at,updated_at) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a import csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function createFacility($insert_val) {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');
        
        try {
            $insert_val         = "'" . $insert_val . 
                                  "'," . "'" . $currentUser . 
                                  "','" . $currentUser . 
                                  "','" . $today . 
                                  "','" . $today . "'";
            DB::insert("INSERT INTO facilities (name,facility_group_id,icon,description,type,created_by,updated_by,created_at,updated_at) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a import csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function createLandmarks($insert_val) {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');
        
        try {
            $insert_val         = "'" . $insert_val . 
                                  "'," . "'" . $currentUser . 
                                  "','" . $currentUser . 
                                  "','" . $today . 
                                  "','" . $today . "'";
            DB::insert("INSERT INTO landmarks (name,description,township_id,is_popular,latitude,longitude,created_by,updated_by,created_at,updated_at) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created an import Landmark csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function createAdmin($insert_val) {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');
        $role_id        = 3;
        
        try {
            $insert_val         = "'" . $insert_val . 
                                  "'," . "'" . $role_id . 
                                  "'," . "'" . $currentUser . 
                                  "','" . $currentUser . 
                                  "','" . $today . 
                                  "','" . $today . "'";
            DB::insert("INSERT INTO core_users (user_name,display_name,email,password,address,role_id,created_by,updated_by,created_at,updated_at) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created an import Admin csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function createHotels($insert_val) {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $currentUser    = Utility::getCurrentUserID(); //get currently logged in user
        $today          = Carbon::now()->format('Y-m-d H:i:s');
        
        try {
            $insert_val         = "'" . $insert_val .  
                                  "'," . "'" . $currentUser . 
                                  "','" . $currentUser . 
                                  "','" . $today . 
                                  "','" . $today . "'";

            DB::insert("INSERT INTO hotels (name,address,phone,fax,latitude,longitude,logo,star,email,country_id,city_id,township_id,description,number_of_floors,class,website,check_in_time,check_out_time,breakfast_start_time,breakfast_end_time,h_type_id,admin_id,created_by,updated_by,created_at,updated_at) VALUES ($insert_val) ");

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } 
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created an import Admin csv and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getCountryIdByName($country_name) {
        $countryObjs    = Country::select('id')->where('name',$country_name)->first();
        return $countryObjs;
    }

    public function getCityIdByName($city_name) {
        $cityObjs    = City::select('id')->where('name',$city_name)->first();
        return $cityObjs;
    }

    public function getTownshipIdByName($township_name) {
        $townshipObjs    = Township::select('id')->where('name',$township_name)->first();
        return $townshipObjs;
    }
}