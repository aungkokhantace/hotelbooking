<?php

namespace App\Setup\Landmark;

use Illuminate\Database\Eloquent\Model;

class Landmark extends Model
{
    protected $table = 'landmarks';

    protected $fillable = [
        'id',
        'name',
        'description',
        'township_id',
        'is_popular',
        'latitude',
        'longitude',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function township()
    {
        return $this->belongsTo('App\Setup\Township\Township','township_id','id');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }
}
