<?php

namespace App\Setup\BookingRequest;

use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    protected $table = 'booking_request';

    protected $fillable = [
        'id',
        'booking_id',
        'non_smoking_room',
        'late_check_in',
        'early_check_in',
        'high_floor_room',
        'large_bed',
        'twin_bed',
        'quiet_room',
        'baby_cot',
        'airport_transfer',
        'private_parking',
        'special_request',
        'booking_taxi',
        'booking_tour_guide',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];
    public function booking()
    {
        return $this->belongsTo('App\Setup\Booking\Booking');
    }
}
