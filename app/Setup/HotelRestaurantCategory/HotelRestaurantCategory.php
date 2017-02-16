<?php

namespace App\Setup\Country;

use Illuminate\Database\Eloquent\Model;

class HotelRestaurantCategory extends Model
{
    protected $table = 'hotel_restaurant_categories';

    protected $fillable = [
        'id',
        'hotel_restaurant_category_name',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
        ,
    ];
}
