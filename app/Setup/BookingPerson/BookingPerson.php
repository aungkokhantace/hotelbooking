<?php

namespace App\Setup\BookingPerson;

use Illuminate\Database\Eloquent\Model;

class BookingPerson extends Model
{
    protected $table = "booking_person";

    protected $fillable = [
        'booking_id',
        'adult_count',
        'children_count',
        'room_count'
    ];
}
