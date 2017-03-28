<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/27/2017
 * Time: 9:01 PM
 */

namespace App\Setup\HotelNearbyDrugStore;


interface HotelNearbyDrugStoreRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($id);
}