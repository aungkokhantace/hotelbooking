<?php

namespace App\Setup\RoomAvailablePeriod;

use Illuminate\Database\Eloquent\Model;

class RoomAvailablePeriod extends Model
{
    protected $table = 'r_available_period';

    protected $fillable = [
        'id',
        'hotel_id',
        'room_id',
        'from_date',
        'to_date',
        'remark',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }

    public function room()
    {
        return $this->belongsTo('App\Setup\Room\Room','room_id','id');
    }
}
