<?php

namespace App\Setup\RoomDiscount;

use Illuminate\Database\Eloquent\Model;

class RoomDiscount extends Model
{
    protected $table = 'room_discount';

    protected $fillable = [
        'id',
        'name',
        'hotel_id',
        'h_room_type_id',
        'h_room_category_id',
        'type',
        'discount_percent',
        'discount_amount',
        'from_date',
        'to_date',
        'remark',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }

    public function hotel_room_type()
    {
        return $this->belongsTo('App\Setup\HotelRoomType\HotelRoomType','h_room_type_id','id');
    }

    public function hotel_room_category()
    {
        return $this->belongsTo('App\Setup\HotelRoomCategory\HotelRoomCategory','h_room_category_id','id');
    }
}
