<?php

namespace App\Setup\Amendities;

use Illuminate\Database\Eloquent\Model;

class Amendities extends Model
{
    protected $table = 'amendities';

    protected $fillable = [
        'id',
        'amendities_name',
        'amendities_icon',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
        ,
    ];
}
