<?php

namespace App\Http\Controllers\Frontend;

use App\Core\Check;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Setup\Booking\BookingRepositoryInterface;
use App\Setup\BookingRoom\BookingRoomRepository;
use App\Setup\Customer\CustomerRepository;
use App\Setup\Hotel\HotelRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class BookingController extends Controller
{
    private $repo;
    public function __construct(BookingRepositoryInterface $repo){
        $this->repo = $repo;
    }

    public function booking_list(){
        if (Auth::guard('Customer')->check()) {
            $id                 = Utility::getCurrentCustomerID();
            $customerRepo       = new CustomerRepository();
            $customer           = $customerRepo->getObjByID($id);
            $bookings           = $this->repo->getBookingByCustomerId($id);
            $booking_room       = $this->repo->getBookingRoomByCustomerId($id);
            $booking_cancel     = array();

            foreach($bookings as $b){
                $count = 0;

                foreach($booking_room as $b_room){
                    if($b->id == $b_room->booking_id){
                        $count = $count+1;
                    }
                }
                $b->number_of_room = $count;
                /*
                 * status 1 is no use
                if($b->status == 1){
                    $b->status_txt      = "Pending";
                    $b->button_status   = "BOOKING PAYMENT";
                }*/
                if($b->status == 2){
                    $b->status_txt      = "Confirm";
                    $b->button_status   = "MANAGE BOOKING";
                }
                if($b->status == 3){
                    $b->status_txt      = "Cancel";
                    $b->button_status   = "BOOKING AGAIN";
                    array_push($booking_cancel,$b);
                }

            }

            return view('frontend.bookinglist')->with('customer',$customer)
                                               ->with('bookings',$bookings)
                                               ->with('booking_cancel',$booking_cancel);
        }
        return redirect('/');
    }

    public function manage($id){
        if (Auth::guard('Customer')->check()) {
            $customer           = session('customer');
            $b_id               = $id;
            $u_id               = Auth::guard('Customer')->id();
            $status             = Check::checkBookingByUserId($b_id,$u_id);
            if($status['aceplusStatusCode'] == ReturnMessage::OK){
                $booking        = $this->repo->getBookingById($b_id);
                $hotelRepo      = new HotelRepository();
                $hotel          = $hotelRepo->getObjByID($booking->hotel_id);
                $bRoomRepo      = new BookingRoomRepository();
                $bRooms         = $bRoomRepo->getBookingRoomAndRoomByBookingId($b_id);
                $booking->booking_rooms = $bRooms;
                dd($booking);

                return view('frontend.manage_booking')->with('customer',$customer);
            }
            else{
                dd('unauthorized');
            }
        }
        return redirect('/');

    }
}
