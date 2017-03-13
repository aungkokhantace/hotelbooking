<?php

namespace App\Setup\HotelRoomCategory;

use Illuminate\Database\Eloquent\Model;

class HotelRoomCategory extends Model
{
    protected $table = 'h_room_category';

    protected $fillable = [
        'id',
        'name',
        'hotel_id',
        'square_metre',
        'capacity',
        'booking_cutoff_day',
        'extra_bed_allowed',
        'extra_bed_price',
        'h_room_type_id',
        'bed_type',
        'description',
        'price',
        'remark',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }

    public function h_room_type()
    {
        return $this->belongsTo('App\Setup\HotelRoomType\HotelRoomType','h_room_type_id','id');
    }
}
