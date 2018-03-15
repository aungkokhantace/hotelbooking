<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::guard('User')->check()) {
            // $users = DB::select("SELECT count(id) as userCount FROM core_users WHERE deleted_at IS  NULL");
            // $user_count = 0;

            $hotels = DB::select("SELECT count(id) as hotelCount FROM hotels WHERE deleted_at IS  NULL");
            $hotel_count = 0;

            // if (isset($users) && count($users) > 0) {
            //     $user_count = $users[0]->userCount;
            // }
            if (isset($hotels) && count($hotels) > 0) {
                $hotel_count = $hotels[0]->hotelCount;
            }
            return view('core.dashboard.dashboard')
                // ->with('userCount', $user_count)
                ->with('hotelCount', $hotel_count);
        }
        return redirect('/backend_mps/login');
    }
}
