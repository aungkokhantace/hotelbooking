<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/21/2016
 * Time: 3:51 PM
 */
namespace App\Setup\City;

use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Setup\City\City;
use App\Core\Utility;
use App\Core\ReturnMessage;
class PopularCityRepository implements PopularCityRepositoryInterface
{
    /*public function getObjs()
    {
        $objs = City::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new City())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    } */

    public function create($cityArray)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {

            foreach($cityArray as $city_id=>$order){
                //check whether the record with this city_id already exists in popular_cities table or not
                $checkPopular = DB::table('popular_cities')->where('city_id','=',$city_id)->get();

                if(isset($checkPopular) && count($checkPopular)>0){
                    //find city_id and update order
                    DB::table('popular_cities')
                        ->where('city_id', $city_id)
                        ->update(['order' => $order]);

                }
                else{
                    if($order != "" || null){
                        //insert
                        DB::table('popular_cities')->insert(
                            ['order' => $order, 'city_id' => $city_id]
                        );
                    }
                }
            }


//            //create info log
//            $date = $tempObj->created_at;
//            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created city_id = '.$tempObj->id . PHP_EOL;
//            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
//            //create error log
//            $date    = date("Y-m-d H:i:s");
//            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a city and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
//            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getOrderByCityId($city_id){
        $result = DB::table('popular_cities')->where('city_id','=',$city_id)->first();
        return $result;
    }

    /*public function update($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            //update info log
            $date = $tempObj->updated_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' updated city_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //update error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' updated city_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function delete($id)
    {
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try{
            $tempObj = City::find($id);
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();

            //delete info log
            $date = $tempObj->deleted_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted city_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  city_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function getObjByID($id){
        $role = City::find($id);
        return $role;
    }

    public function getCityByCountryId($country_id){
        $result = DB::table('cities')->where('country_id', $country_id)->whereNull('deleted_at')->get();
        return $result;
    }

    public function checkToDelete($id){
        $result = DB::select("SELECT * FROM townships WHERE city_id = $id AND deleted_at IS NULL");
        return $result;
    }
    */
}