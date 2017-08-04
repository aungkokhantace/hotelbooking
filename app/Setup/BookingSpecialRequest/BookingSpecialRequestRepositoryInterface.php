<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/1/2017
 * Time: 4:43 PM
 */

namespace App\Setup\BookingSpecialRequest;


interface BookingSpecialRequestRepositoryInterface
{
    public function getMaxOrder($booking_id);
}