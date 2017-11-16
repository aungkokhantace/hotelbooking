<?php

namespace App\Setup\HotelGallery;

use Illuminate\Database\Eloquent\Model;

class HotelGallery extends Model
{
    protected $table = 'hotel_gallery';

    protected $fillable = [
        'id',
        'hotel_id',
        'image',
        'status',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel(){
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }
}
