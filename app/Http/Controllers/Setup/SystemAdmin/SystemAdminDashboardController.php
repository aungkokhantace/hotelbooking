<?php

namespace App\Http\Controllers\Setup\SystemAdmin;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class SystemAdminDashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::guard('User')->check()) {
           
            return view('core.dashboard.system_dashboard');
              
        }
        return redirect('/backend_mps/login');
    }
}
