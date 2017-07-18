<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/11/2017
 * Time: 3:39 PM
 */

namespace App\Setup\Booking;


interface CommunicationRepositoryInterface
{
    public function create($paramObj);
    public function getObjs();
    public function getCommunicationBooking($id_arr);
    public function getCommunicationCount($id);
    public function getCommunicationByHotelId($hotel_id,$id_arr);


    public function getUserObjs();
    public function checkHasPermission($id,$h_id);

}