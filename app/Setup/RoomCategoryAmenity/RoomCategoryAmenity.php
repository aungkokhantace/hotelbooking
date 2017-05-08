<?php

namespace App\Setup\RoomCategoryAmenity;

use Illuminate\Database\Eloquent\Model;

class RoomCategoryAmenity extends Model
{
    protected $table = 'r_category_amenities';

    protected $fillable = [
        'id',
        'room_category_id',
        'amenity_id',
        'value',
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
        return $this->belongsTo('App\Setup\HotelRoomCategory\HotelRoomCategory','room_category_id','id');
    }

    public function amenity()
    {
        return $this->belongsTo('App\Setup\Amenities\Amenity','amenity_id','id');
    }
}
