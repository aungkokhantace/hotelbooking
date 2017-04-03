<?php

namespace App\Setup\HotelFacility;

use Illuminate\Database\Eloquent\Model;

class HotelFacility extends Model
{
    protected $table = 'h_facility';

    protected $fillable = [
        'id',
        'hotel_id',
        'facility_group_id',
        'facility_id',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Setup\Hotel\Hotel','hotel_id','id');
    }

    public function facility_group()
    {
        return $this->belongsTo('App\Setup\FacilityGroup\FacilityGroup','facility_group_id','id');
    }

    public function facility()
    {
        return $this->belongsTo('App\Setup\Facilities\Facilities','facility_id','id');
    }

}
