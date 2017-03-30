<?php

namespace App\Setup\HotelRestaurant;

use Illuminate\Database\Eloquent\Model;

class HotelRestaurant extends Model
{
    protected $table = 'h_restaurant';

    protected $fillable = [
        'id',
        'name',
        'opening_hours',
        'opening_days',
        'capacity',
        'area',
        'floor',
        'private_room',
        'hotel_id',
        'h_restaurant_category_id',
        'description',
        'remark',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }

    public function h_restaurant_category()
    {
        return $this->belongsTo('App\Setup\HotelRestaurantCategory\HotelRestaurantCategory','h_restaurant_category_id','id');
    }
}
