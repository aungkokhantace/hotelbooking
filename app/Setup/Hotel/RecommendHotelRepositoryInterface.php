<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 2/15/2017
 * Time: 11:28 AM
 */

namespace App\Setup\Hotel;


interface RecommendHotelRepositoryInterface
{
    public function create($paramObj);
    public function getOrderByHotelId($hotel_id);
    public function getObjs();
}