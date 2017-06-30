<?php

namespace App\Setup\EventEmail;

use Illuminate\Database\Eloquent\Model;

class EventEmail extends Model
{
    protected $table = 'event_email';

    protected $fillable = [
        'id',
        'email',
        'description',
        'type',
        'status',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];
}
