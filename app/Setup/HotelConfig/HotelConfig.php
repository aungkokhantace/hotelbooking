<?php

namespace App\Setup\HotelConfig;

use Illuminate\Database\Eloquent\Model;

class HotelConfig extends Model
{
    protected $table = 'h_config';

    protected $fillable = [
        'id',
        'hotel_id',
        'cancellation_days',
        'breakfast_fees',
        'extrabed_fees',
        'tax',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }
}
