<?php

namespace App\Http\Controllers\Frontend;

use App\Core\Utility;
use App\Setup\Booking\BookingRepositoryInterface;
use App\Setup\Customer\CustomerRepository;
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
                if($b->status == 1){
                    $b->status_txt      = "Pending";
                    $b->button_status   = "BOOKING PAYMENT";
                }
                elseif($b->status == 2){
                    $b->status_txt      = "Confirm";
                    $b->button_status   = "MANAGE BOOKING";
                }
                else{
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
}
