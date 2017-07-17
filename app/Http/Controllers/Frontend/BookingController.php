<?php

namespace App\Http\Controllers\Frontend;

use App\Core\Check;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Setup\Amenities\AmenitiesRepository;
use App\Setup\Booking\BookingRepositoryInterface;
use App\Setup\BookingRequest\BookingRequestRepository;
use App\Setup\BookingRoom\BookingRoomRepository;
use App\Setup\Customer\CustomerRepository;
use App\Setup\Facilities\FacilitiesRepository;
use App\Setup\Hotel\HotelRepository;
use App\Setup\HotelConfig\HotelConfigRepository;
use App\Setup\HotelFacility\HotelFacilityRepository;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use PDF;

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
            $customer               = session('customer');
            $b_id                   = $id;
            $u_id                   = Auth::guard('Customer')->id();
            $status                 = Check::checkBookingByUserId($b_id,$u_id);
            if($status['aceplusStatusCode'] == ReturnMessage::OK){
                $hotelRepo          = new HotelRepository();
                $h_facilityRepo     = new HotelFacilityRepository();
                $bRoomRepo          = new BookingRoomRepository();
                $amenityRepo        = new AmenitiesRepository();
                $facilityRepo       = new FacilitiesRepository();

                $r_category_id      = array();
                $amenity_arr        = array();
                $facility_arr       = array();

                $booking            = $this->repo->getBookingById($b_id);
                $hotel              = $hotelRepo->getObjByID($booking->hotel_id);
                $h_facilities       = $h_facilityRepo->getHotelFacilitiesByHotelID($booking->hotel_id);
                $hotel->h_facilities= $h_facilities;

                $start              = Carbon::parse($booking->check_in_date);
                $end                = Carbon::parse($booking->check_out_date);
                $total_day          = $end->diffInDays($start);
                $booking->total_day = $total_day; //Add total booked days to booking

                $bRooms             = $bRoomRepo->getBookingRoomAndRoomByBookingId($b_id);
                $room_count         = count($bRooms);
                $booking->room_count= $room_count; //Add Number of Room to booking

                if(isset($bRooms) && count($bRooms) > 0){
                    foreach($bRooms as $bRoom){
                        array_push($r_category_id,$bRoom->h_room_category_id);
                    }
                }

                $amenities          = $amenityRepo->getAmenitiesByRoomCategoryId($r_category_id);
                $facilities         = $facilityRepo->getFacilitiesByRoomCategoryId($r_category_id);
                if(isset($bRooms) && count($bRooms) > 0){
                    foreach($bRooms as $bRoom){

                        //Add amenities array in booking room
                        foreach($amenities as $amenity){
                            if($bRoom->h_room_category_id == $amenity->room_category_id){
                                array_push($amenity_arr,$amenity);
                            }
                        }
                        $bRoom->amenities = $amenity_arr;
                        $amenity_arr = array();

                        //Add facilities array in booking room
                        foreach($facilities as $facility){
                            if($bRoom->h_room_category_id == $facility->h_room_category_id){
                                array_push($facility_arr,$facility);
                            }
                        }
                        $bRoom->facilities = $facility_arr;
                        $facility_arr = array();
                    }
                }
                $booking->rooms     = $bRooms; //Add Rooms Array to booking

                return view('frontend.manage_booking')->with('customer',$customer)
                                                      ->with('booking',$booking)
                                                      ->with('hotel',$hotel);
            }
            else{
                dd('unauthorized');
            }
        }
        return redirect('/');

    }

    public function say_congratulation($id){
        $hotel_id   = $id;
        $hotelRepo  = new HotelRepository();
        $hotel      = $hotelRepo->getObjByID($hotel_id);

        return view('frontend.congratulations')->with('hotel',$hotel);
    }

    public function print_congratulation($id){
        $b_id               = $id;
        $hotelRepo          = new HotelRepository();
        $h_facilityRepo     = new HotelFacilityRepository();
        $bRoomRepo          = new BookingRoomRepository();
        $amenityRepo        = new AmenitiesRepository();
        $facilityRepo       = new FacilitiesRepository();
        $h_configRepo       = new HotelConfigRepository();
        $b_requestRepo      = new BookingRequestRepository();

        $r_category_id      = array();
        $amenity_arr        = array();
        $facility_arr       = array();

        $booking            = $this->repo->getBookingById($b_id);
        $hotel              = $hotelRepo->getObjByID($booking->hotel_id);
        $h_facilities       = $h_facilityRepo->getHotelFacilitiesByHotelID($booking->hotel_id);
        $hotel->h_facilities= $h_facilities;

        $start              = Carbon::parse($booking->check_in_date);
        $end                = Carbon::parse($booking->check_out_date);
        $total_day          = $end->diffInDays($start);
        $booking->total_day = $total_day; //Add total booked days to booking

        $bRooms             = $bRoomRepo->getBookingRoomAndRoomByBookingId($b_id);
        $room_count         = count($bRooms);
        $booking->room_count= $room_count; //Add Number of Room to booking

        /* Calculate Cancellation Cost */
        $h_config                       = $h_configRepo->getObjByID($booking->hotel_id);
        $first_cancel_days              = $h_config->first_cancellation_day_count;
        $second_cancel_days             = $h_config->second_cancellation_day_count;
        $first_cancel_date              = Carbon::parse($booking->check_in_date)->subDays($first_cancel_days)->format('M d, Y');
        $second_cancel_date             = Carbon::parse($booking->check_in_date)->subDays($second_cancel_days)->format('M d, Y');
        $free_cancel_days               = Carbon::parse($first_cancel_date)->diffInDays(Carbon::now());
        $free_cancel_date               = Carbon::parse($first_cancel_date)->subDay()->format('M d, Y');

        $booking->free_cancel_date      = $free_cancel_date;
        $booking->first_cancel_date     = $first_cancel_date;
        $booking->second_cancel_date    = $second_cancel_date;

        if(isset($bRooms) && count($bRooms) > 0){
            foreach($bRooms as $bRoom){
                array_push($r_category_id,$bRoom->h_room_category_id);
            }
        }

        $amenities          = $amenityRepo->getAmenitiesByRoomCategoryId($r_category_id);
        $facilities         = $facilityRepo->getFacilitiesByRoomCategoryId($r_category_id);
        if(isset($bRooms) && count($bRooms) > 0){
            $total_room_price       = 0.00;
            $total_extra_bed_price  = 0.00;
            foreach($bRooms as $bRoom){
                $total_room_price       += $bRoom->room_price;
                $total_extra_bed_price  += $bRoom->extra_bed_price;
                //Add amenities array in booking room
                foreach($amenities as $amenity){
                    if($bRoom->h_room_category_id == $amenity->room_category_id){
                        array_push($amenity_arr,$amenity);
                    }
                }
                $bRoom->amenities = $amenity_arr;
                $amenity_arr = array();

                //Add facilities array in booking room
                foreach($facilities as $facility){
                    if($bRoom->h_room_category_id == $facility->h_room_category_id){
                        array_push($facility_arr,$facility);
                    }
                }
                $bRoom->facilities = $facility_arr;
                $facility_arr = array();
            }
        }
        $booking->total_room_price      = $total_room_price;
        $booking->total_extra_bed_price = $total_extra_bed_price;
        $booking->rooms                 = $bRooms; //Add Rooms Array to booking

        /* get booking request to know special request */
        $b_request                      = $b_requestRepo->getBookingRequestByBookingId($b_id);

        /* Start Print Function */
        $view = \View::make('frontend.print_confirmation',compact('booking','hotel','h_config','b_request'));
        $html = $view->render();

        $pdf = new TCPDF();
        $pdf::SetTitle('Booking Confirmation Preview');
        $pdf::AddPage();
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('pdf_booking_confirmation.pdf');

    }


}
