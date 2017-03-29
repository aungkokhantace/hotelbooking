<?php

namespace App\Setup\FacilityGroup;

use Illuminate\Database\Eloquent\Model;

class FacilityGroup extends Model
{
    protected $table = 'facility_group';

    protected $fillable = [
        'id',
        'name',
        'icon',
        'remark',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];
}
