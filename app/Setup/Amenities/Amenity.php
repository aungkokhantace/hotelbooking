<?php

namespace App\Setup\Amenities;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $table = 'amenities';

    protected $fillable = [
        'id',
        'name',
        'icon',
        'description',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];
}
