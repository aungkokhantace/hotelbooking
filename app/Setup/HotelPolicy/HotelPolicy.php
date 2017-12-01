<?php

namespace App\Setup\HotelPolicy;

use Illuminate\Database\Eloquent\Model;

class HotelPolicy extends Model
{
    protected $table = 'h_policy';

    protected $fillable = [
        'id',
        'hotel_id',
        'policy',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel(){
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }
}
