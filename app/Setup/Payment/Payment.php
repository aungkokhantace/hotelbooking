<?php

namespace App\Setup\Payment;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payments";

    protected $fillable = [
        'id',
        'name',
        'type',
        'description',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'

    ];
}
