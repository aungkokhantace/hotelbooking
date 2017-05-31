<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/12/2017
 * Time: 10:23 AM
 */

namespace App\Setup\BookingPaymentStripe;


interface BookingPaymentStripeRepositoryInterface
{
    public function create($paramObj);
}