<?php

namespace App\Setup\HotelNearby;

use Illuminate\Database\Eloquent\Model;

class HotelNearby extends Model
{
    protected $table = 'nearby';

    protected $fillable = [
        'id',
        'name',
        'description',
        'h_nearby_category_id',
        'status',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function nearby_category(){
        return $this->belongsTo('App\Setup\HotelNearbyCategory\HotelNearbyCategory','h_nearby_category_id','id');
    }

   
}
