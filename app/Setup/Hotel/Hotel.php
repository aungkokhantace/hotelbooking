<?php

namespace App\Setup\Hotel;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotels';

    protected $fillable = [
        'id',
        'name',
        'address',
        'phone',
        'fax',
        'latitude',
        'longitude',
        'logo',
        'star',
        'email',
        'country_id',
        'city_id',
        'township_id',
        'description',
        'number_of_floors',
        'class',
        'website',
        'check_in_time',
        'check_out_time',
        'breakfast_start_time',
        'breakfast_end_time',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function country()
    {
        return $this->belongsTo('App\Setup\Country\Country','country_id','id');
    }

    public function city()
    {
        return $this->belongsTo('App\Setup\City\City','city_id','id');
    }

    public function township()
    {
        return $this->belongsTo('App\Setup\Township\Township','township_id','id');
    }

    public function h_room_category()
    {
        return $this->hasMany('App\Setup\HotelRoomCategory\HotelRoomCategory');
    }

    public function hotel_facility()
    {
        return $this->hasMany('App\Setup\HotelFacility\HotelFacility');
    }

    public function hotel_landmark()
    {
        return $this->hasMany('App\Setup\HotelLandmark\HotelLandmark');
    }

    public function hotel_gallery()
    {
        return $this->hasMany('App\Setup\HotelGallery\HotelGallery');
    }

    public function h_nearby()
    {
        return $this->hasMany('App\Setup\Hnearby\Hnearby');
    }
}
