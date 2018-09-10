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
            // $users = DB::select("SELECT count(id) as userCount FROM core_users WHERE deleted_at IS  NULL AND id != 1");
            // $user_count = 0;

            // if (isset($users) && count($users) > 0) {
            //     $user_count = $users[0]->userCount;
            // }

            $hotels = DB::select("SELECT count(id) as hotelCount FROM hotels WHERE deleted_at IS  NULL");
            $hotel_count = 0;

            if (isset($hotels) && count($hotels) > 0) {
                $hotel_count = $hotels[0]->hotelCount;
            }

            return view('core.dashboard.system_dashboard')
                        // ->with('userCount', $user_count);
                        ->with('hotelCount', $hotel_count);

        }
        return redirect('/backend_mps/login');
    }
}
