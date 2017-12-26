<?php

namespace App\Setup\BedType;

use Illuminate\Database\Eloquent\Model;

class BedType extends Model
{
    protected $table = 'bed_types';

    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function room_category(){
        return $this->hasMany('App\Setup\HotelRoomCategory\HotelRoomCategory');
    }
}
