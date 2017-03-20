<?php
namespace App\Setup\RoomCategoryFacility;
/**
 * Created by PhpStorm.
 * Author: Khin Zar Ni Wint
 * Date: 3/19/2017
 * Time: 8:49 PM
 */
interface RoomCategoryFacilityRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
}