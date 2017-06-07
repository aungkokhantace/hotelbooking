<?php
namespace App\Setup\Report;
/**
 * Created by PhpStorm.
 * Author: Khin Zar Ni Wint
 * Date: 5/25/2017
 * Time: 9:45 AM
 */
interface ReportRepositoryInterface
{
    public function saleSummaryReport($type=null, $from_date=null, $to_date=null);
    public function bookingReport($type=null, $from_date=null, $to_date=null, $status=null);
}