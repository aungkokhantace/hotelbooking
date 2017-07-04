<?php

namespace App\Http\Controllers\Setup\HotelBooking;

use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;

use App\Setup\Booking\BookingRepositoryInterface;
use Illuminate\Http\Request;
use App\Setup\Booking\Booking;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class HotelBookingController extends Controller
{
    private $repo;

    public function __construct(BookingRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            //Get Loggin User Info
            $user               = $this->repo->getUserObjs();
            $id                 = $user->id;
            $role               = $user->role_id;
            $email              = $user->email;

            if ($role == 3) {
                //Get Hotel ID
                $hotelRepo      = new HotelRepository();
                $hotels         = $hotelRepo->getHotelByUserEmail($email);
                $hotel_id       = $hotels->id;
                $bookings       = $this->repo->getBookingByHotelId($hotel_id);
            } else {
                $bookings       = $this->repo->getObjs();
            }
            return view('backend.booking.index')->with('bookings',$bookings);
        }
        return redirect('/');
    }

    public function detail($id)
    {
        if(Auth::guard('User')->check()){
            //Get Loggin User Info
            $user               = $this->repo->getUserObjs();
            $email              = $user->email;
            $role               = $user->role_id;
            $uid                = $user->id;
            $hotelRepo          = new HotelRepository();

            if ($role == 3) {
                //Check User has permission to edit
                //Get Hotel ID
                $hotels             = $hotelRepo->getHotelByUserEmail($email);
                $h_id               = $hotels->id;
                $checkPermission    = $this->repo->checkHasPermission($id,$h_id);
                if ($checkPermission == false) {
                    return redirect('unauthorize');
                    exit();
                }
            }
            $booking            = $this->repo->getBookingById($id);
            return view('backend.booking.booking')->with('booking',$booking);
        }
        return redirect('/');
    }
}
