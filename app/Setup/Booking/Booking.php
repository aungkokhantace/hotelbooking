<?php

namespace App\Setup\Booking;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'id',
        'user_id',
        'status',
        'check_in_date',
        'check_out_date',
        'check_in_time',
        'check_out_time',
        'price_wo_tax',
        'price_w_tax',
        'total_tax_amt',
        'total_tax_percentage',
        'total_payable_amt',
        'total_discount_amt',
        'total_discount_percentage',
        'hotel_id',
        'booking_no',
        'travel_for_work',
        'for_other',
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

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function booking_stripe() 
    {
        return $this->hasOne('App\Setup\BookingPaymentStripe\BookingPaymentStripe', 'booking_id','id');
    }
    public function booking_special_request()
    {
        return $this->hasMany('App\Setup\Booking\Communication', 'booking_id','id');
    }

    public function booking_room()
    {
        return $this->hasMany('App\Setup\BookingRoom\BookingRoom', 'booking_id','id');
    }

    public function booking_request()
    {
        return $this->hasOne('App\Setup\BookingRequest\BookingRequest', 'booking_id','id');
    }
}
