<?php

namespace App\Http\Controllers\Setup\HotelBooking;

use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Hotel\HotelRepository;

use App\Setup\Booking\CommunicationRepositoryInterface;
use Illuminate\Http\Request;
use App\Setup\Booking\Booking;
use App\Setup\Booking\Communication;
use App\Setup\BookingSpecialRequest\BookingSpecialRequest;
use App\User;
use App\Http\Requests;
use App\Backend\Infrastructure\Forms\CommunicationEntryRequest;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class CommunicationController extends Controller
{
    private $repo;

    public function __construct(CommunicationRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            //Get Loggin User Info
            $user                  = $this->repo->getUserObjs();
            $id                    = $user->id;
            $role                  = $user->role_id;
            $email                 = $user->email;


            $communications        = $this->repo->getObjs();
            $id_arr                = array();
            foreach ($communications as $communication) {
                $id_arr[]          = $communication->booking_id;
            }

            if ($role == 3) {
                //Get Hotel ID
                $hotelRepo             = new HotelRepository();
                $hotels                = $hotelRepo->getHotelByUserEmail($email);
                foreach($hotels as $hotel){
                    $h_id = $hotel->id;
                }
                $bookings              = $this->repo->getCommunicationByHotelId($h_id,$id_arr);
            } else {
                $bookings              = $this->repo->getCommunicationBooking($id_arr);
            }

            $commuCount            = array();
            foreach($bookings as $booking) {
                $id                 = $booking->id;
                $commuCount[$id]    = $this->repo->getCommunicationCount($id);
            }

            return view('backend.communication.index')
                    ->with('bookings',$bookings)
                    ->with('commuCount',$commuCount);
        }
        return redirect('/');
    }

    public function show($id)
    {
        if (Auth::guard('User')->check()) {

            $booking             = Booking::find($id);
            $booking_rooms       = $booking->booking_room;
            $booking_request     = $booking->booking_request;
            $booking_spec_reqs   = BookingSpecialRequest::where('booking_id',$id)
                                   ->whereNull('deleted_at')
                                   ->orderBy('order', 'asc')
                                   ->get();

            foreach($booking_spec_reqs as $booking_spec_req) {
                $id_arr[]        = $booking_spec_req->created_by;
            }
            $getUserobjs         = User::whereIn('id', $id_arr)->whereNull('deleted_at')->get();

            return view('backend.communication.communication')
                    ->with('booking',$booking)
                    ->with('booking_rooms',$booking_rooms)
                    ->with('booking_request',$booking_request)
                    ->with('booking_spec_reqs',$booking_spec_reqs)
                    ->with('getUserobjs',$getUserobjs);
        }
        return redirect('/');
    }

    public function store(CommunicationEntryRequest $request) {
        $request->validate();
        $reply                      = Input::get('reply');
        $max_order                  = BookingSpecialRequest::whereNull('deleted_at')->max('order');
        $order                      = $max_order + 1;
        $type                       = 1;
        $booking_id                 = Input::get('id');

        $paraObjs                   = new BookingSpecialRequest();
        $paraObjs->special_request  = $reply;
        $paraObjs->order            = $order;
        $paraObjs->type             = $type;
        $paraObjs->booking_id       = $booking_id;
        $result     = $this->repo->create($paraObjs);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\HotelBooking\CommunicationController@index')
                ->withMessage(FormatGenerator::message('Success', 'Communication create ...'));
        }
        else{
            return redirect()->action('Setup\HotelBooking\CommunicationController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Communication did not create ...'));
        }
    }

}
