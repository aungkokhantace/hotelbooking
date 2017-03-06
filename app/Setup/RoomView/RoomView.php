<?php

namespace App\Setup\RoomView;

use Illuminate\Database\Eloquent\Model;

class RoomView extends Model
{
    protected $table = 'room_views';

    protected $fillable = [
        'id',
        'name',
        'description',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];
}
