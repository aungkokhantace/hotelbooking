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
            $id             = Auth::guard('User')->user()->id;
            $user           = DB::table('core_users')->where('id',$id)->first();
            $role           = $user->role_id;
            $email          = $user->email;

            $hotels         = DB::select("SELECT count(id) as hotelCount FROM hotels WHERE email='" . 
                              $email . "' AND deleted_at IS  NULL");
            $hotel_obj      = DB::table('hotels')->select('id')->where('admin_id',$id)->first();
            $hotel_id       = $hotel_obj->id;

            $room_type      = DB::select("SELECT count(id) as roomTypeCount FROM h_room_type WHERE hotel_id = '"
                              . $hotel_id . "' AND deleted_at IS  NULL");
            $rooms          = DB::select("SELECT count(id) as roomsCount FROM rooms WHERE hotel_id = '"
                              . $hotel_id . "' AND deleted_at IS  NULL");
            $bookings       = DB::select("SELECT count(id) as bookingCount FROM bookings WHERE hotel_id = '"
                              . $hotel_id . "' AND deleted_at IS  NULL");

            $hotel_count        = 0;
            $room_type_count    = 0;
            $rooms_count        = 0;
            if (isset($hotels) && count($hotels) > 0) {
                $hotel_count = $hotels[0]->hotelCount;
            }
            if (isset($room_type) && count($room_type) > 0) {
                $room_type_count = $room_type[0]->roomTypeCount;
            }
            if (isset($rooms) && count($rooms) > 0) {
                $rooms_count = $rooms[0]->roomsCount;
            }
            if (isset($bookings) && count($bookings) > 0) {
                $bookings_count  = $bookings[0]->bookingCount;
            }
            return view('core.dashboard.hotel_dashboard')
                ->with('hotel_count', $hotel_count)
                ->with('room_type_count',$room_type_count)
                ->with('rooms_count',$rooms_count)
                ->with('bookings_count',$bookings_count);
        }
        return redirect('/backend_mps/login');
    }
}
