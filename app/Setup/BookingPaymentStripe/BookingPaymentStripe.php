<?php

namespace App\Setup\BookingPaymentStripe;

use Illuminate\Database\Eloquent\Model;

class BookingPaymentStripe extends Model
{
    protected $table = "booking_payment_stripe";

    protected $fillable = [
        'id',
        'stripe_user_id',
        'email',
        'status',
        'booking_id',
        'booking_payment_id',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'

    ];
}
