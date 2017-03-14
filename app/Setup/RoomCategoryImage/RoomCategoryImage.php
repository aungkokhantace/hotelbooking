<?php

namespace App\Setup\RoomCategoryImage;

use Illuminate\Database\Eloquent\Model;

class RoomCategoryImage extends Model
{
    protected $table = 'r_category_image';

    protected $fillable = [
        'id',
        'h_room_category_id',
        'img_path',
        'description',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];
}
