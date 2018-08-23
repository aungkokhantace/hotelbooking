<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/21/2016
 * Time: 3:51 PM
 */
namespace App\Setup\Autocomplete;

use App\Log\LogCustom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Setup\Amenities\Amenity;
use App\Core\Utility;
use App\Core\ReturnMessage;
class AutocompleteRepository implements AutocompleteRepositoryInterface
{
    public function getDestinations()
    {
        $term = Input::get('term');
        $results = array();
        // $hotels = DB::select("SELECT * FROM hotels WHERE name like  '$term%'");
        // $hotels = DB::select("SELECT * FROM hotels WHERE name like  '%$term%'");

        $hotels = DB::select("SELECT * FROM hotels WHERE (name like '%$term%' OR name_jp like '%$term%') AND status = 1");

        foreach($hotels as $hotel){
            array_push($results,$hotel->name.' ('.$hotel->name_jp.')');
        }

        // $countries = DB::select("SELECT * FROM countries WHERE name like  '%$term%'");
        // $countries = DB::select("SELECT * FROM countries WHERE (name like '%$term%' OR name_jp like  '%$term%')");
        // foreach($countries as $country){
        //     array_push($results,$country->name);
        // }

        // $cities = DB::select("SELECT * FROM cities WHERE name like  '%$term%'");
        $cities = DB::select("SELECT * FROM cities WHERE name like '%$term%' OR name_jp like '%$term%'");

        foreach($cities as $city){
            array_push($results,$city->name.' ('.$city->name_jp.')');
        }

        // $townships = DB::select("SELECT * FROM townships WHERE name like  '%$term%'");
        // // $townships = DB::select("SELECT * FROM townships WHERE name like  '$term%'");
        // foreach($townships as $township){
        //     array_push($results,$township->name);
        // }

        $nearbys = DB::select("SELECT * FROM nearby WHERE name like '%$term%' OR name_jp like '%$term%'");

        foreach($nearbys as $nearby){
            array_push($results,$nearby->name.' ('.$nearby->name_jp.')');
        }

        return $results;
    }
}
