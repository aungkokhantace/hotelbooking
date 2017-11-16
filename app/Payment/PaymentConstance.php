<?php namespace App\Payment;

/**
 * Created by PhpStorm.
 * User: william
 * Date: 7/13/2017
 * Time: 1:11 PM
 */
class PaymentConstance
{
    const STRIPE_SECRET_KEY         = "sk_test_wecHEoFknZ5MOpIgq0fqrx0R";
    const STIRPE_PUBLISHABLE_KEY    = "pk_test_NTCDoN2guwqkNlVXBhWoTwbh";
    const STIRPE_CURRENCY           = "usd";
    const STIRPE_FEE_PERCENT        = 0.029; // 2.9%
    const STRIPE_FEE_FIXED          = 0.3; // 30 cents 

}