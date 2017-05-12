<?php

namespace App\Setup\Booking;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'id',
        'booking_no',
        'user_id',
        'status',
        'check_in_date',
        'check_out_date',
        'check_in_time',
        'check_out_time',
        'for_other',
        'price_wo_tax',
        'price_w_tax',
        'total_tax_amt',
        'total_tax_percentage',
        'total_payable_amt',
        'room_discount',
        'total_discount_amt',
        'total_discount_percentage',
        'guest_count',
        'room_id',
        'hotel_id',
        'h_room_type_id',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel');
    }

    public function h_room_type()
    {
        return $this->belongsTo('App\Setup\HotelRoomType\HotelRoomType');
    }
}
