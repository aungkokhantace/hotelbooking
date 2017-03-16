<?php

namespace App\Setup\Room;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'id',
        'name',
        'hotel_id',
        'h_room_type_id',
        'h_room_category_id',
        'description',
        'status',
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

    public function room_view()
    {
        return $this->belongsTo('App\Setup\RoomView\RoomView','room_view_id','id');
    }
}
