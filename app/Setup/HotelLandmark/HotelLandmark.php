<?php

namespace App\Setup\HotelLandmark;

use Illuminate\Database\Eloquent\Model;

class HotelLandmark extends Model
{
    protected $table = 'h_landmark';

    protected $fillable = [
        'id',
        'hotel_id',
        'landmark_id',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }

    public function landmark()
    {
        return $this->belongsTo('App\Setup\Landmark\Landmark','landmark_id','id');
    }
}
