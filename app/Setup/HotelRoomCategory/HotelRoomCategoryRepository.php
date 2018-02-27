<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/8/2017
 * Time: 5:28 PM
 */

namespace App\Setup\HotelRoomCategory;


use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use App\Setup\HotelRoomCategory\HotelRoomCategory;
use App\Setup\RoomCategoryAmenity\RoomCategoryAmenity;
use App\Setup\RoomCategoryFacility\RoomCategoryFacility;
use App\Setup\RoomDiscount\RoomDiscount;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use App\Setup\Hotel\Hotel;
use App\Setup\BedType\BedTypeRepository;

class HotelRoomCategoryRepository implements HotelRoomCategoryRepositoryInterface
{
    public function getObjs()
    {
        $objs = HotelRoomCategory::whereNull('deleted_at')->get();
        return $objs;
    }

    public function getArrays()
    {
        $tbName = (new HotelRoomCategory())->getTable();
        $arr = DB::select("SELECT * FROM $tbName WHERE deleted_at IS NULL");
        return $arr;
    }

    // public function getObjByID($id)
    // {
    //     $obj = HotelRoomCategory::find($id);
    //     return $obj;
    // }

    public function getObjByID($id)
    {
        $obj = HotelRoomCategory::find($id);
        $childArray = DB::select("SELECT bed_type_id FROM r_category_bed_type WHERE room_category_id = $id");

        $bedTypeRepo = new BedTypeRepository();
        $bedTypes      = $bedTypeRepo->getArrays();

        if(isset($childArray) && count($childArray)>0){

            $tempArray = array();
            foreach($childArray as $bed_type){
                $bedTypeId = $bed_type->bed_type_id;
                array_push($tempArray,$bedTypeId);
            }

            if(isset($bedTypes) && count($bedTypes)>0){
                foreach($bedTypes as $key => $value){
                    if (in_array($value->id, $tempArray)) {
                        $bedTypes[$key]->selected = 1;
                    }
                }

                foreach($bedTypes as $key2 => $value2){

                    if (!array_key_exists('selected', $value2)) {
                        $bedTypes[$key2]->selected = 0;
                    }
                }
            }
            $obj['bedTypes'] = $bedTypes;
        }
        else{
            foreach($bedTypes as $key3 => $value3){
                $bedTypes[$key3]->selected = 0;
            }
            $obj['bedTypes'] = $bedTypes;
        }
        return $obj;
    }

    public function create($paramObj,$childArray)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            DB::beginTransaction();
            $tempObj = Utility::addCreatedBy($paramObj);
            // $tempObj->save();

            if($tempObj->save()){
                $room_category_id = $tempObj->id;
                if(isset($childArray) && count($childArray)>0){
                    foreach($childArray as $bed_type_id){
                        DB::table('r_category_bed_type')->insert([
                            ['room_category_id' => $room_category_id, 'bed_type_id' => $bed_type_id]
                        ]);
                    }
                }
                DB::commit();
                //create info log
                $date = $tempObj->created_at;
                $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created hotel_room_category_id = '.$tempObj->id . PHP_EOL;
                LogCustom::create($date,$message);

                $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
                $returnedObj['lastId']            = $tempObj->id;
                return $returnedObj;
            }
        }
        catch(\Exception $e){
            DB::rollBack();
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created a hotel_room_category and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function update($paramObj,$childArray)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            DB::beginTransaction();
            $tempObj = Utility::addUpdatedBy($paramObj);
            // $tempObj->save();
            if($tempObj->save()){
                $room_category_id = $tempObj->id;

                //clear old detail data
                DB::table('r_category_bed_type')->where('room_category_id', '=', $room_category_id)->delete();

                if(isset($childArray) && count($childArray)>0){
                    foreach($childArray as $bed_type_id){
                        DB::table('r_category_bed_type')->insert([
                            ['room_category_id' => $room_category_id, 'bed_type_id' => $bed_type_id]
                        ]);
                    }
                }
                DB::commit();

                //update info log
                $date = $tempObj->updated_at;
                $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' updated hotel_room_category_id = '.$tempObj->id . PHP_EOL;
                LogCustom::create($date,$message);

                $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
                return $returnedObj;
            }
        }
        catch(\Exception $e){
          dd('except',$e);
            DB::rollBack();
            //update error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' updated hotel_room_category_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function delete($id)
    {
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try{
            $tempObj = HotelRoomCategory::find($id);
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();

            //delete info log
            $date = $tempObj->deleted_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' deleted hotel_room_category_id = '.$tempObj->id . PHP_EOL;
            LogCustom::create($date,$message);
        }
        catch(\Exception $e){
            //delete error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' deleted  hotel_room_category_id = ' .$tempObj->id. ' and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);
        }
    }

    public function getHotelRoomCategoryWithRoomTypeId($h_room_type_id){
        $objs   = HotelRoomCategory::select('id','h_room_type_id','name')
                                     ->where('h_room_type_id','=',$h_room_type_id)
                                     ->get();

        return $objs;
    }

    public function getHotelRoomCategoryWithHotelId($hotel_id){
        // $objs   = HotelRoomCategory::where('hotel_id','=',$hotel_id)
        //                              ->get();
        $objs   = HotelRoomCategory::where('hotel_id','=',$hotel_id)->whereNull('deleted_at')
                                     ->get();

        return $objs;
    }

    public function getMinPriceByHotelId($hotel_id){
        $price = HotelRoomCategory::whereNull('deleted_at')->where('hotel_id','=',$hotel_id)->min('price');
        return $price;
    }

    public function getRoomTypeByHotelIdAndPrice($hotel_id,$price){
        $room_type = HotelRoomCategory::whereNull('deleted_at')
                    ->where('hotel_id','=',$hotel_id)
                    ->where('price','=',$price)
                    ->first();
        $room_type_name = $room_type->h_room_type->name;
        return $room_type_name;
    }

    public function getRoomCategoriesByHotelId($hotel_id){
        $result = HotelRoomCategory::whereNull('deleted_at')
//                    ->select('id')
                    ->where('hotel_id','=',$hotel_id)
                    ->get();

        return $result;
    }
    public function getRoomCategories($hotel_id = null){
        $query = HotelRoomCategory::query();
        if(isset($hotel_id) && $hotel_id!=null  && $hotel_id <> 'All'){
            $query = $query->where('hotel_id',$hotel_id);
        }
        $query = $query->whereNull('h_room_category.deleted_at');
        $result = $query->get();
        return $result;
    }

    public function getUserObjs() {
        $id     = Auth::guard('User')->user()->id;
        $objs   = User::select('id','email','role_id')->where('id',$id)->whereNull('deleted_at')->first();
        return $objs;
    }

    public function getRoomCategoriesByUserId($id) {
        $objs   = HotelRoomCategory::whereNull('deleted_at')->where('hotel_id',$id)->get();
        return $objs;
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

    public function getObjsByIdArr($id_arr){
        $id     = implode("','",$id_arr);
        $result = DB::select("SELECT id,h_room_category.name,hotel_id,capacity
                              FROM h_room_category
                              WHERE id IN ('$id')
                              AND deleted_at IS NULL");

        return $result;

    }

    public function getRoomCategoryAmenityByID($id){
//        $hotel_config  =  DB::select("SELECT * FROM h_config WHERE hotel_id = '$id'");
        $r_amenity = RoomCategoryAmenity::where('room_category_id',$id)->get();
        return $r_amenity;
    }
    public function getRoomCategoryFacilityByID($id){
//        $hotel_config  =  DB::select("SELECT * FROM h_config WHERE hotel_id = '$id'");
        $r_facility = RoomCategoryFacility::where('h_room_category_id',$id)->get();
        return $r_facility;
    }

    public function getBedTypesByRoomCategoryId($room_category_id){
        $result = DB::table('r_category_bed_type')->where('room_category_id','=',$room_category_id)->get();
        return $result;
    }
}
