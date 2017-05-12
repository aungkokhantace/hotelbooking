<?php

namespace App\Setup\BookingRoom;

use Illuminate\Database\Eloquent\Model;

class BookingRoom extends Model
{
    protected $table = 'booking_room';

    protected $fillable = [
        'id',
        'booking_id',
        'user_id',
        'room_id',
        'hotel_id',
        'status',
        'check_in_date',
        'check_out_date',
        'check_in_time',
        'check_out_time',
        'remark',
        'room_price',
        'added_extra_bed',
        'extra_bed_price',
        'user_first_name',
        'user_last_name',
        'user_email',
        'guest_count',
        'smoking',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

}
