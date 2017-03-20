<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/19/2017
 * Time: 10:27 PM
 */

namespace App\Setup\HotelFeature;


interface HotelFeatureRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
}