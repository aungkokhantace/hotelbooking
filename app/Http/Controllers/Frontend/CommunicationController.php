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

class CommunicationController extends Controller
{
    private $repo;
    public function __construct(BookingRepositoryInterface $repo){
        $this->repo = $repo;
    }

    public function showForm(){
        if (Auth::guard('Customer')->check()) {
            $id                 = Utility::getCurrentCustomerID();
            $customerRepo       = new CustomerRepository();
            $customer           = $customerRepo->getObjByID($id);

            return view('frontend.communication');
        }
        return redirect('/');
    }
}
