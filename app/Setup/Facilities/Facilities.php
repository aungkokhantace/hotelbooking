<?php

namespace App\Setup\Facilities;

use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    protected $table = 'facilities';

    protected $fillable = [
        'id',
        'name',
        'facility_group_id',
        'icon',
        'description',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function facility_group()
    {
        return $this->belongsTo('App\Setup\FacilityGroup\FacilityGroup','facility_group_id','id');
    }
}
