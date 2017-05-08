<?php
namespace App\Setup\RoomDiscount;
/**
 * Created by PhpStorm.
 * Author: Khin Zar Ni Wint
 * Date: 3/20/2017
 * Time: 4:51 PM
 */
interface RoomDiscountRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($paramObj);
    public function getDiscountPercentByUniqueHotel();
    public function getDiscountAmountByUniqueHotel($percentHotelIDs);
    public function getMaximumDiscountPercentByHotelID($hotel_id);
    public function getMaximumDiscountAmountByHotelID($hotel_id);
}