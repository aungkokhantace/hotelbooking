<?php

namespace App\Http\Controllers\Setup\Hotel;

use App\Core\Utility;
use App\Setup\Hotel\HotelRepository;
use App\Setup\Hotel\RecommendHotelRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;
class RecommendHotelController extends Controller
{
    private $repo;

    public function __construct(RecommendHotelRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $hotelRepo = new HotelRepository();
            $hotels = $hotelRepo->getObjs();
            $hotel_count = $hotelRepo->getObjs()->count();


            foreach($hotels as $hotel){
                //set hotel order label to use as name and id of form elements
                $hotel->order_label = preg_replace('/\s/', '', strtolower($hotel->name))."_order";

                //check whether this hotel_id is already in recommend_hotels table
                $check_hotel_order = $this->repo->getOrderByHotelId($hotel->id);

                if(isset($check_hotel_order) && count($check_hotel_order)>0){
                    //if already in recommend_hotels table send that order to view
                    $hotel->order = $check_hotel_order->order;
                }
                else{
                    //else, set order to null
                    $hotel->order = null;
                }
            }

            return view('backend.hotel.recommendhotel')->with('hotels',$hotels)->with('hotel_count',$hotel_count);
        }
        return redirect('/');
    }

    public function store()
    {
        //get hotels
        $hotelRepo = new HotelRepository();
        $hotels = $hotelRepo->getObjs();
        $hotel_count = $hotelRepo->getObjs()->count();

        //set hotel order label to use as name and id of form elements
        foreach($hotels as $hotelOrder){
            $hotelOrder->order_label = preg_replace('/\s/', '', strtolower($hotelOrder->name))."_order";
        }

        $hotelArray = array();
        foreach($hotels as $hotelInput){
//            $hotel_input_data = Input::get($hotelInput->order_label);
            $hotel_input_data = (Input::has($hotelInput->order_label)) ? Input::get($hotelInput->order_label) : "";
            $hotelArray[$hotelInput->id] = $hotel_input_data;
        }

        $result = $this->repo->create($hotelArray);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Hotel\RecommendHotelController@create')
                ->withMessage(FormatGenerator::message('Success', 'Recommended Hotel set ...'));
        }
        else{
            return redirect()->action('Setup\Hotel\RecommendHotelController@create')
                ->withMessage(FormatGenerator::message('Fail', 'Recommended Hotel did not set ...'));
        }

    }
}
