<?php

namespace App\Http\Controllers\Report;

use App\Setup\Booking\BookingRepository;
use App\Setup\BookingRoom\BookingRoom;
use App\Setup\BookingRoom\BookingRoomRepository;
use App\Setup\Report\ReportRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class BookingReportController extends Controller
{
    private $repo;

    public function __construct(ReportRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(){
        if (Auth::guard('User')->check()) {
            $type               = null;
            $from_date          = null;
            $to_date            = null;
            $grandTotal         = 0.00;

            $bookings           = $this->repo->bookingReport($type,$from_date,$to_date);
            $bookingRoomRepo    = new BookingRoomRepository();
            $booking_room       = $bookingRoomRepo->getAllBookingRoom();

            if(isset($bookings) && count($bookings) > 0){
                foreach($bookings as $booking){
                    $room_count     = 0;
                    foreach($booking_room as $b_room){
                        if($booking->id == $b_room->booking_id){
                            $room_count++;
                        }
                    }
                    $booking->total_room    = $room_count;
                    $grandTotal            += $booking->total_payable_amt;
                }
            }

            return view('report.booking_report')->with('bookings',$bookings)
                                                ->with('grandTotal',$grandTotal);
        }
        return redirect('/');

    }

    public function search($type = null, $from = null, $to = null,$status = null){
        if(Auth::guard('User')->check()){
            $from_year      = null;
            $to_year        = null;
            $from_month     = null;
            $to_month       = null;
            $from_date      = null;
            $to_date        = null;
            $grandTotal     = 0.00;

            if($type == "yearly"){
                $from_year  = $from;
                $to_year    = $to;
            }
            if($type == "monthly"){
                $from_month = $from;
                $to_month   = $to;
            }
            if($type == "daily"){
                $from_date  = $from;
                $to_date    = $to;
            }

            $bookings           = $this->repo->bookingReport($type, $from, $to,$status);
            $bookingRoomRepo    = new BookingRoomRepository();
            $booking_room       = $bookingRoomRepo->getAllBookingRoom();

            if(isset($bookings) && count($bookings) > 0){
                foreach($bookings as $booking){
                    $room_count     = 0;
                    foreach($booking_room as $b_room){
                        if($booking->id == $b_room->booking_id){
                            $room_count++;
                        }
                    }
                    $booking->total_room    = $room_count;
                    $grandTotal            += $booking->total_payable_amt;
                }
            }

            return view('report.booking_report')->with('bookings',$bookings)
                ->with('from_year',$from_year)
                ->with('from_month',$from_month)
                ->with('from_date',$from_date)
                ->with('to_year',$to_year)
                ->with('to_month',$to_month)
                ->with('to_date',$to_date)
                ->with('grandTotal',$grandTotal)
                ->with('type',$type)
                ->with('status',$status);
        }
        return redirect('/');
    }

    public function excel($type = null, $from = null, $to = null, $status = null){
        if(Auth::guard('User')->check()){
            ob_end_clean();
            ob_start();

            $bookings           = $this->repo->bookingReport($type, $from, $to, $status);
            $bookingRoomRepo    = new BookingRoomRepository();
            $booking_room       = $bookingRoomRepo->getAllBookingRoom();
            $grandTotal         = 0.00;

            if(isset($bookings) && count($bookings) > 0){
                foreach($bookings as $booking){
                    $room_count     = 0;
                    foreach($booking_room as $b_room){
                        if($booking->id == $b_room->booking_id){
                            $room_count++;
                        }
                        //Change integer status to text status
                        // if($booking->status == 1) $booking->b_status_text = 'Pending';
                        // elseif($booking->status == 2) $booking->b_status_text = 'Confirm';
                        // elseif($booking->status == 3) $booking->b_status_text = 'Cancel';
                        // else $booking->b_status_text = 'Void';
                        if($booking->status == 1) $booking->b_status_text = 'Pending';
                        elseif($booking->status == 2) $booking->b_status_text = 'Confirm';
                        elseif($booking->status == 3) $booking->b_status_text = 'Cancel(Cancel By User)';
                        elseif($booking->status == 4) $booking->b_status_text = 'Void (Cancel By System Admin)';
                        elseif($booking->status == 5) $booking->b_status_text = 'Complete';
                        elseif($booking->status == 6) $booking->b_status_text = 'Transaction Fail';
                        elseif($booking->status == 7) $booking->b_status_text = 'Refund by Customer(Cancel within first cancellation days)';
                        elseif($booking->status == 8) $booking->b_status_text = 'Refund by Admin';
                        else $booking->b_status_text = 'Cancel within second cancellation days';
                    }
                    $booking->total_room    = $room_count;
                    $grandTotal            += $booking->total_payable_amt;
                }
            }

            Excel::create('BookingReport', function($excel)use($bookings,$grandTotal) {
                $excel->sheet('BookingReport', function($sheet)use($bookings,$grandTotal) {

                    $displayArray   = array();
                    $count          = 0;
                    if(isset($bookings) && count($bookings) > 0){
                        foreach($bookings as $value){
                            $count++;
                            $displayArray[$value->id]['Date']           = $value->date;
                            $displayArray[$value->id]['Booking Number'] = $value->booking_no;
                            $displayArray[$value->id]['Customer Name']  = $value->first_name.' '.$value->last_name;
                            $displayArray[$value->id]['Status']         = $value->b_status_text;
                            $displayArray[$value->id]['Total Room']     = $value->total_room;
                            $displayArray[$value->id]['Total Amount']   = number_format($value->total_payable_amt,2);
                        }
                    }
                    $count          = $count +2;
                    $sheet->fromArray($displayArray);
                    $sheet->appendRow(array('Grand Total','','','','',number_format($grandTotal,2)));
                    $sheet->row(1,function($row){
                        $row->setBackground('#D63090');
                        $row->setFontSize(13);
                    });
                    $sheet->cells('A'.$count.':F'.$count, function($cells) {
                        $cells->setBackground('#D63090');
                    });
                });
            })->download('xls');

            ob_flush();
            return Redirect();
        }
        return redirect('/');
    }

    public function booking_room_detail($id){
        if(Auth::guard('User')->check()){
            $bookingRoomRepo    = new BookingRoomRepository();
            $booking_room       = $bookingRoomRepo->getBookingRoomByBookingId($id);
            $bookingRepo        = new BookingRepository();
            $booking            = $bookingRepo->getBookingById($id);
            $booking_no         = $booking->booking_no;
            $customer_name      = $booking->user->first_name.' '.$booking->user->last_name;

            foreach($booking_room as $b_room){
                /* Change date format for created_at and add date field to BookingRoom Obj */
                $formatted_date = date_format($b_room->created_at,"d-m-Y");
                $b_room->date   = $formatted_date;

                /* Add string status to BookingRoom Obj */
                // if($b_room->status == 1) $b_room->status_text = 'Pending';
                // elseif($b_room->status == 2) $b_room->status_text = 'Confirm';
                // elseif($b_room->status == 3) $b_room->status_text = 'Cancel';
                // else $b_room->status_text = 'Void';
                if($b_room->status == 1) $b_room->status_text = 'Pending';
                elseif($b_room->status == 2) $b_room->status_text = 'Confirm';
                elseif($b_room->status == 3) $b_room->status_text = 'Cancel(Cancel By User)';
                elseif($b_room->status == 4) $b_room->status_text = 'Void (Cancel By System Admin)';
                elseif($b_room->status == 5) $b_room->status_text = 'Complete';
                elseif($b_room->status == 6) $b_room->status_text = 'Transaction Fail';
                elseif($b_room->status == 7) $b_room->status_text = 'Refund by Customer(Cancel within first cancellation days)';
                elseif($b_room->status == 8) $b_room->status_text = 'Refund by Admin';
                else $b_room->status_text = 'Cancel within second cancellation days';

                /* Add added extra bed string status to BookingRoom Obj */
                if($b_room->added_extra_bed == 1) $b_room->added_extra_bed_status = 'Yes';
                else $b_room->added_extra_bed_status = 'No';

                /* Add smoking string status to BookingRoom Obj */
                if($b_room->smoking == 1) $b_room->smoking_status = 'Yes';
                else $b_room->smoking_status = 'No';
            }

            return view('report.booking_room_detail')->with('booking_room',$booking_room)
                                                     ->with('booking_no',$booking_no)
                                                     ->with('customer_name',$customer_name);
        }
    }
}
