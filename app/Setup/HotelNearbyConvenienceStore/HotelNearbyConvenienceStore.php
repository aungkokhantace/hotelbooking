<?php

namespace App\Setup\HotelNearbyConvenienceStore;

use Illuminate\Database\Eloquent\Model;

class HotelNearbyConvenienceStore extends Model
{
    protected $table = 'h_nearby_convenience_store';

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
