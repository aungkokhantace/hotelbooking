<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/29/2017
 * Time: 1:53 PM
 */

namespace App\Setup\HotelRestaurant;


interface HotelRestaurantRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($paramObj);
}