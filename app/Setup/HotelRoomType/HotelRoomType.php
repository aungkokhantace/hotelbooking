<?php

namespace App\Setup\HotelRoomType;

use Illuminate\Database\Eloquent\Model;

class HotelRoomType extends Model
{
    protected $table = 'h_room_type';

    protected $fillable = [
        'id',
        'name',
        'description',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }

    public function hotel_room_category()
    {
        return $this->hasMany('App\Setup\HotelRoomCategory\HotelRoomCategory');
    }
}
