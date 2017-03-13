<?php

namespace App\Setup\RoomCutOffDateHistory;

use Illuminate\Database\Eloquent\Model;

class RoomCutOffDateHistory extends Model
{
    protected $table = 'r_cutoff_date_history';

    protected $fillable = [
        'id',
        'hotel_id',
        'h_room_category_id',
        'remark',
        'cutoff_date_count',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];
}
