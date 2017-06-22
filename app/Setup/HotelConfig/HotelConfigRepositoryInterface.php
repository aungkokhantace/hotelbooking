<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/4/2017
 * Time: 3:40 PM
 */

namespace App\Setup\HotelConfig;


interface HotelConfigRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($paramObj);
    public function getObjsByHotelID($hotel_id);
    public function getCancellationDayFromHotelConfig($id_arr);
}