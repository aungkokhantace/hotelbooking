<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/13/2017
 * Time: 5:03 PM
 */

namespace App\Setup\HotelGallery;


interface HotelGalleryRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function getObjsByHotelID($hotel_id);
}