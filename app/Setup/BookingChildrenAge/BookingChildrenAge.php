<?php

namespace App\Setup\BookingChildrenAge;

use Illuminate\Database\Eloquent\Model;

class BookingChildrenAge extends Model
{
    protected $table = "booking_children_ages";

    protected $fillable = [
        'booking_id',
        'child_age'
    ];
}
