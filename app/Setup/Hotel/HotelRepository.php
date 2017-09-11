<?php
/**
 * Created by PhpStorm.
 * Author: Aung Ko Khant
 * Date: 2017-03-06
 * Time: 02:00 PM
 */
namespace App\Setup\Hotel;

use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Setup\Hotel\Hotel;
use App\Setup\Hnearby\Hnearby;
use App\Core\Utility;
use App\Core\ReturnMessage;
class HotelRepository implements HotelRepositoryInterface
{
    public function getObjs()
    {
        $objs = Hotel::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new Hotel())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    public function create($paramObj,$input)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            //create info log
            $date = $tempObj->created_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created hotel_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            //Update h_nearby table
            $id                 = $paramObj->id;
            $nearby_count       = $input['nearby_count'] + 1;
            for($i=0; $i<$nearby_count; $i++) {
                //Check If user add empty value
                if($input['nearby_place'][$i] > 0 && $input['nearby_distance'][$i] >= 0) {
                    $paramObj                       = new Hnearby();
                    $paramObj->hotel_id             = $id;
                    $paramObj->nearby_id            = $input['nearby_place'][$i];
                    $paramObj->km                   = $input['nearby_distance'][$i];
//                    dd($paramObj);
                    $tempPlace                      = Utility::addCreatedBy($paramObj);
                    $tempPlace->save();
                }
            }

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a hotel and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function update($paramObj,$input)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            //update info log
            $date = $tempObj->updated_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' updated hotel_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);

            //Remove h_nearby id and insert
            $id                  = $tempObj->id;
            $nearby_places       = Hnearby::where('hotel_id',$id)->get();
            foreach ($nearby_places as $nearby_place)
            {
                $n_id         = $nearby_place->id;
                Hnearby::where('id',$n_id)->delete();
            }

            $nearby_count       = $input['nearby_count'] + 1;
            for($i=0; $i<$nearby_count; $i++) {
                if ($input['nearby_place'][$i] > 0 AND $input['nearby_distance'][$i] >= 0) {
                    $paramObj                       = new Hnearby();
                    $paramObj->hotel_id             = $id;
                    $paramObj->nearby_id            = $input['nearby_place'][$i];
                    $paramObj->km                   = $input['nearby_distance'][$i];
                    $tempPlace                      = Utility::addCreatedBy($paramObj);
                    $tempPlace->save();
                }
            }

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //update error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' updated hotel_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function delete($id)
    {
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try{
            $tempObj = Hotel::find($id);
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();

            //delete info log
            $date = $tempObj->deleted_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted hotel_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  hotel_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function getObjByID($id){
        $role = Hotel::find($id);
        return $role;
    }

    public function getHotelsByDestination($name){
//        $objs = Hotel::whereNull('deleted_at')->where('name', 'LIKE', "%$name%")->get();

         $objs  = Hotel::whereHas('country', function($query) use($name) {
                        $query->where('countries.name', 'LIKE', '%'.$name.'%');
                    })
                    ->orWhereHas('city', function($query) use($name) {
                        $query->where('cities.name', 'LIKE', '%'.$name.'%');
                    })
                    ->orWhereHas('township', function($query) use($name) {
                         $query->where('townships.name', 'LIKE', '%'.$name.'%');
                    })
                    ->orWhere('name','LIKE','%'.$name.'%')
                    ->get();

        return $objs;
    }

    public function getHotelsByFilters($destination,$price_filter = null,$star_filter = null,$facility_filter = null,$landmark_filter = null){
        $query = Hotel::query();
        //start condition group for destination_name
        $query = $query->where(function ($query) use($destination) {
            $query = $query->whereHas('country', function($query) use($destination) {
                $query->where('countries.name', 'LIKE', '%'.$destination.'%');
            });
            $query = $query->orWhereHas('city', function($query) use($destination) {
                $query->where('cities.name', 'LIKE', '%'.$destination.'%');
            });
            $query = $query->orWhereHas('township', function($query) use($destination) {
                $query->where('townships.name', 'LIKE', '%'.$destination.'%');
            });
            $query = $query->orWhere('name','LIKE','%'.$destination.'%');
        });
        //end condition group for destination_name

        //start condition group for price_filter
        if(isset($price_filter) && count($price_filter)>0 && $price_filter != ""){
            //get price filter from price_filter table by id
            $filter_id      = $price_filter[0];
            $filter         = Utility::getPriceFilterById($filter_id);
            $type           = $filter->type;
            $from_price     = $filter->from;
            $to_price       = $filter->to;
            if($type == 'under'){
                $query->whereHas('h_room_category', function($query) use($to_price) {
                    $query->where('h_room_category.price', '<' , $to_price);
                });
            }
            elseif($type == 'above'){
                $query->whereHas('h_room_category', function($query) use($from_price) {
                    $query->where('h_room_category.price', '>' , $from_price);
                });
            }
            else{
                $query->whereHas('h_room_category', function($query) use($from_price,$to_price) {
                    $query->whereBetween('h_room_category.price', [$from_price, $to_price]);
                });
            }
            /*
            if($price_filter[0] == "0-50000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->whereBetween('h_room_category.price', [0, 50000]);
                });
            }
            elseif($price_filter[0] == "50000-100000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->whereBetween('h_room_category.price', [50000, 100000]);
                });
            }
            elseif($price_filter[0] == "100000-150000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->whereBetween('h_room_category.price', [100000, 150000]);
                });
            }
            elseif($price_filter[0] == "150000-200000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->whereBetween('h_room_category.price', [150000, 200000]);
                });
            }
            elseif($price_filter[0] == "200000-250000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->whereBetween('h_room_category.price', [200000, 250000]);
                });
            }
            elseif($price_filter[0] == "250000-300000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->whereBetween('h_room_category.price', [250000, 300000]);
                });
            }
            elseif($price_filter[0] == "300000-350000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->whereBetween('h_room_category.price', [300000, 350000]);
                });
            }
            elseif($price_filter[0] == "350000-400000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->whereBetween('h_room_category.price', [350000, 400000]);
                });
            }
            elseif($price_filter[0] == "400000-450000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->whereBetween('h_room_category.price', [400000, 450000]);
                });
            }
            elseif($price_filter[0] == "450000-500000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->whereBetween('h_room_category.price', [450000, 500000]);
                });
            }
            elseif($price_filter[0] == "above500000"){
                $query->whereHas('h_room_category', function($query) use($price_filter) {
                    $query->where('h_room_category.price', '>' , 500000);
                });
            }*/
        }
        //end condition group for price_filter

        //start condition group for star_filter
        if(isset($star_filter) && count($star_filter)>0 && $star_filter != ""){
            if($star_filter[0] == "1"){
                $query->where('hotels.star', "=" ,1);
            }
            elseif($star_filter[0] == "2"){
                $query->where('hotels.star', "=" ,2);
            }
            elseif($star_filter[0] == "3"){
                $query->where('hotels.star', "=" ,3);
            }
            elseif($star_filter[0] == "4"){
                $query->where('hotels.star', "=" ,4);
            }
            elseif($star_filter[0] == "5"){
                $query->where('hotels.star', "=" ,5);
            }
            elseif($star_filter[0] == "6"){
                $query->where('hotels.star', "=" ,6);
            }
            elseif($star_filter[0] == "7"){
                $query->where('hotels.star', "=" ,7);
            }
        }
        //end condition group for star_filter

        //start condition group for facility_filter
        if(isset($facility_filter) && count($facility_filter)>0 && $facility_filter != ""){
            foreach($facility_filter as $facility){
                $query->whereHas('hotel_facility', function($query) use($facility) {
                    $query->where('h_facility.facility_id', "=" , $facility);
                });
            }
        }
        //end condition group for facility_filter

        //start condition group for landmark_filter
        if(isset($landmark_filter) && count($landmark_filter)>0 && $landmark_filter != ""){
            foreach($landmark_filter as $landmark){
                $query->whereHas('hotel_landmark', function($query) use($landmark) {
                    $query->where('h_landmark.landmark_id', "=" , $landmark);
                });
            }
        }
        //end condition group for landmark_filter

        $result = $query->get();

        return $result;
    }

    public function getSuggestedHotelsByDestination($hotelIdArr,$countryIdArr,$cityIdArr,$townshipIdArr){

        $objs  = Hotel::whereHas('country', function($query) use($hotelIdArr,$countryIdArr) {
                        $query->whereIn('countries.id', $countryIdArr);
                        $query->whereNotIn('hotels.id', $hotelIdArr);
                    })
                    ->orWhereHas('city', function($query) use($hotelIdArr,$cityIdArr) {
                        $query->whereIn('cities.id', $cityIdArr);
                        $query->whereNotIn('hotels.id', $hotelIdArr);
                    })
                    ->orWhereHas('township', function($query) use($hotelIdArr,$townshipIdArr) {
                        $query->whereIn('townships.id', $townshipIdArr);
                        $query->whereNotIn('hotels.id', $hotelIdArr);
                    })
                    ->get();

        return $objs;
    }

    public function getObjsNotInConfig($hotel_config_array)
    {
        $objs = Hotel::whereNull('deleted_at')->whereNotIn('id', $hotel_config_array)->get();
        return $objs;
    }

    public function getHotelByUserEmail($email) {
        $objs   = Hotel::whereNull('deleted_at')->where('email',$email)->first();
        return $objs;
    }
}