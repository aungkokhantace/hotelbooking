<?php

namespace App\Setup\Facilities;

use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    protected $table = 'facilities';

    protected $fillable = [
        'id',
        'facilities_name',
        'facilities_icon',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
        ,
    ];
}
