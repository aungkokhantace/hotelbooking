<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-10-04
 * Time: 02:29 PM
 */

namespace App\Setup\BookingCancellationDate;

interface BookingCancellationDateRepositoryInterface
{
    public function create($paramObj);
    public function getObjsByBookingId($b_id);
}
