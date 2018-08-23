<?php

namespace App\Setup\Hnearby;

use Illuminate\Database\Eloquent\Model;

class Hnearby extends Model
{
    protected $table = 'h_nearby';

    protected $fillable = [
        'id',
        'hotel_id',
        'nearby_id',
        'km',
        'status',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel(){
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }

    public function nearby(){
        return $this->belongsTo('App\Setup\HotelNearby\HotelNearby','nearby_id','id');
    }
}
