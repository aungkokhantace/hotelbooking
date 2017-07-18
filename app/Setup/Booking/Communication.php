<?php

namespace App\Setup\Booking;

use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    protected $table = 'booking_special_request';

    protected $fillable = [
        'id',
        'booking_id',
        'order',
        'special_request',
        'type',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function booking()
    {
        return $this->belongsTo('App\Setup\Booking\Booking');
    }
}
