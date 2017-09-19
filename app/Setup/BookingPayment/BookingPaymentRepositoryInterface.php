<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/12/2017
 * Time: 10:23 AM
 */

namespace App\Setup\BookingPayment;


interface BookingPaymentRepositoryInterface
{
    public function create($paramObj);
    public function getObjsByBookingId($b_id);
}