<?php

namespace App\Setup\HotelNearbyAirport;

use Illuminate\Database\Eloquent\Model;

class HotelNearbyAirport extends Model
{
    protected $table = 'h_nearby_airport';

    protected $fillable = [
        'id',
        'hotel_id',
        'name',
        'distance',
        'remark',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }
}
