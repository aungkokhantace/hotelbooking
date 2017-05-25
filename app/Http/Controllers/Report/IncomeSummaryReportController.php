<?php

namespace App\Http\Controllers\Report;

use App\Setup\Report\ReportRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IncomeSummaryReportController extends Controller
{
    private $repo;

    public function __construct(ReportRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(){
//        dd('sssssssssssssssssssss');
        $b_payments = $this->repo->allCompletedBookingPayment();
        return view('report.income_summary_report');
    }
}
