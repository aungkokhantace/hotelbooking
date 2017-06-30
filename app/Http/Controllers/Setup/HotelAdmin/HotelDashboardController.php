<?php

namespace App\Http\Controllers\Setup\HotelAdmin;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class HotelDashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::guard('User')->check()) {
            $hotels      = DB::select("SELECT count(id) as hotelCount FROM hotels WHERE deleted_at IS  NULL");
            $hotel_count = 0;
            if (isset($hotels) && count($hotels) > 0) {
                $hotel_count = $hotels[0]->hotelCount;
            }
            return view('core.dashboard.hotel_dashboard')
                ->with('hotel_count', $hotel_count);
        }
        return redirect('/backend/login');
    }
}
