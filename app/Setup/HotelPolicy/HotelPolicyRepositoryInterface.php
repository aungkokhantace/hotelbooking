<?php
/**
 * Author: Aung Ko Khant
 * Date: 2017-11-30
 * Time: 03:55 PM
 */

namespace App\Setup\HotelPolicy;


interface HotelPolicyRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function getObjsByHotelID($hotel_id);
}
