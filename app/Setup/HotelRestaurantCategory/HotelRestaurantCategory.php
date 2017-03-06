<?php

namespace App\Setup\HotelRestaurantCategory;

use Illuminate\Database\Eloquent\Model;

class HotelRestaurantCategory extends Model
{
    protected $table = 'h_restaurant_categories';

    protected $fillable = [
        'id',
        'name',
        'description',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];
}
