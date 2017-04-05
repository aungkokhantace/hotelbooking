<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/21/2016
 * Time: 3:51 PM
 */
namespace App\Setup\Hotel;

use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Setup\Hotel\Hotel;
use App\Core\Utility;
use App\Core\ReturnMessage;
class RecommendHotelRepository implements RecommendHotelRepositoryInterface
{

    public function create($hotelArray)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {

            foreach($hotelArray as $hotel_id=>$order){
                //check whether the record with this hotel_id already exists in recommend_hotels table or not
                $checkPopular = DB::table('recommend_hotels')->where('hotel_id','=',$hotel_id)->get();

                if(isset($checkPopular) && count($checkPopular)>0){
                    //find hotel_id and update order
                    DB::table('recommend_hotels')
                        ->where('hotel_id', $hotel_id)
                        ->update(['order' => $order]);

                }
                else{
                    if($order != "" || null){
                        //insert
                        DB::table('recommend_hotels')->insert(
                            ['order' => $order, 'hotel_id' => $hotel_id]
                        );
                    }
                }
            }

            //create info log
            $date = date('Y-m-d H:i:s'); //get current date for log
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' set recommended_hotels.' . PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date = date('Y-m-d H:i:s'); //get current date for log
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' set recommended_hotels and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getOrderByHotelId($hotel_id){
        $result = DB::table('recommend_hotels')->where('hotel_id','=',$hotel_id)->first();
        return $result;
    }
}