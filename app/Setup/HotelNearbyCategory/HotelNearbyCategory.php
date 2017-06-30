<?php

namespace App\Setup\HotelNearbyCategory;

use Illuminate\Database\Eloquent\Model;

class HotelNearbyCategory extends Model
{
    protected $table = 'h_nearby_category';

    protected $fillable = [
        'id',
        'name',
        'description',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function nearby()
    {
        return $this->hasMany('App\Setup\HotelNearby\HotelNearby');
    }
}
