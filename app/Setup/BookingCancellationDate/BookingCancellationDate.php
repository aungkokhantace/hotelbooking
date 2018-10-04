<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-10-04
 * Time: 02:29 PM
 */
namespace App\Setup\BookingCancellationDate;

use Illuminate\Database\Eloquent\Model;

class BookingCancellationDate extends Model
{
    protected $table = "booking_cancellation_dates";

    protected $fillable = [
        'booking_id',
        'first_cancellation_day_count',
        'second_cancellation_day_count'
    ];
}
