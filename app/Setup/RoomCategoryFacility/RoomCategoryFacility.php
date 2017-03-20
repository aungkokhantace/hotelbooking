<?php

namespace App\Setup\RoomCategoryFacility;

use Illuminate\Database\Eloquent\Model;

class RoomCategoryFacility extends Model
{
    protected $table = 'r_category_facilities';

    protected $fillable = [
        'id',
        'value',
        'hotel_id',
        'h_room_type_id',
        'h_room_category_id',
        'description',
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

    public function facility()
    {
        return $this->belongsTo('App\Setup\Facilities\Facilities','facility_id','id');
    }
}
