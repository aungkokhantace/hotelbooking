<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/26/2017
 * Time: 11:49 AM
 */

namespace App\Setup\HotelNearbyStation;


interface HotelNearbyStationRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($id);
}