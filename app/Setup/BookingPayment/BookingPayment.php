<?php

namespace App\Setup\BookingPayment;

use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    protected $table = "booking_payment";

    protected $fillable = [
        'id',
        'payment_amount_wo_tax',
        'payment_amount_w_tax',
        'description',
        'booking_id',
        'payment_id',
        'payment_gateway_tax_amt',
        'status',
        'payment_tax_percentage',
        'payment_tax_amt',
        'total_payable_amt',
        'payment_reference_no',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'

    ];
}
