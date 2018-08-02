<?php

namespace App\Http\Controllers\Setup\TransportationInformation;

use App\Core\Utility;
use App\Setup\ServicePrice\ServicePriceRepositoryInterface;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;
use Stripe\Util\Util;

class TransportationInformationController extends Controller
{
    private $repo;

    public function __construct()
    {

    }

    public function edit(){
        if (Auth::guard('User')->check()) {
            // $tempTransportationInfo      = DB::select("SELECT * FROM `service_price` WHERE `type` = 'TRANSPORTATION' LIMIT 1");

            $tempTransportationInfo      = DB::select("SELECT * FROM `display_information` WHERE `type` = 'TRANSPORTATION' LIMIT 1");

            $transportationInformation = array();
            if (is_null($tempTransportationInfo) || count($tempTransportationInfo) == 0)
            {
                $transportationInformation['description_en']   = "";
                $transportationInformation['description_jp']   = "";
                return view('backend.transportationinformation.transportationinformation')->with('transportationInformation', $transportationInformation);
            }
            $transportationInformation["description_en"] = $tempTransportationInfo[0]->text_en;
            $transportationInformation["description_jp"] = $tempTransportationInfo[0]->text_jp;
            return view('backend.transportationinformation.transportationinformation')->with('transportationInformation', $transportationInformation);
        }
        return redirect('/');
    }

    public function update(){
        $currentUserID = Utility::getCurrentUserID();
        $date = date("Y-m-d H:i:s");

        $tempDescription_en    = (Input::has('description_en')) ? Input::get('description_en') : "";
        $tempDescription_jp    = (Input::has('description_jp')) ? Input::get('description_jp') : "";

        // DB::statement("DELETE FROM `service_price` WHERE `type` = 'TRANSPORTATION'");
        DB::statement("DELETE FROM `display_information` WHERE `type` = 'TRANSPORTATION'");

        // DB::table('service_price')->insert([
        //     ['type' => 'TRANSPORTATION', 'text' => $tempDescription, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        // ]);

        DB::table('display_information')->insert([
            ['type' => 'TRANSPORTATION', 'text_en' => $tempDescription_en, 'text_jp' => $tempDescription_jp, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        ]);

        return redirect()->action('Setup\TransportationInformation\TransportationInformationController@edit');
    }
}
