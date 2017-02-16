<?php

namespace App\Setup\Feature;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'features';

    protected $fillable = [
        'id',
        'feature_name',
        'feature_icon',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
        ,
    ];

}
