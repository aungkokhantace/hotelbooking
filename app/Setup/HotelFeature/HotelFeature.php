<?php

namespace App\Setup\HotelFeature;

use Illuminate\Database\Eloquent\Model;

class HotelFeature extends Model
{
    protected $table = 'h_feature';

    protected $fillable = [
        'id',
        'hotel_id',
        'feature_id',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }

    public function feature()
    {
        return $this->belongsTo('App\Setup\Feature\Feature','feature_id','id');
    }
}
