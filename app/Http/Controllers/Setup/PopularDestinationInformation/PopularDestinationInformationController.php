<?php

namespace App\Http\Controllers\Setup\PopularDestinationInformation;

use App\Core\Utility;
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

class PopularDestinationInformationController extends Controller
{
    private $repo;

    public function __construct()
    {

    }

    public function edit(){
        if (Auth::guard('User')->check()) {
            // $tempPopularDestinationInfo      = DB::select("SELECT * FROM `service_price` WHERE `type` = 'POPULARDESTINATION' LIMIT 1");

            $tempPopularDestinationInfo      = DB::select("SELECT * FROM `display_information` WHERE `type` = 'POPULARDESTINATION' LIMIT 1");

            $popularDestinationInformation = array();
            if (is_null($tempPopularDestinationInfo) || count($tempPopularDestinationInfo) == 0)
            {
                $popularDestinationInformation['description_en']   = "";
                $popularDestinationInformation['description_jp']   = "";
                return view('backend.populardestinationinformation.populardestinationinformation')->with('popularDestinationInformation', $popularDestinationInformation);
            }
            $popularDestinationInformation["description_en"] = $tempPopularDestinationInfo[0]->text_en;
            $popularDestinationInformation["description_jp"] = $tempPopularDestinationInfo[0]->text_jp;
            return view('backend.populardestinationinformation.populardestinationinformation')->with('popularDestinationInformation', $popularDestinationInformation);
        }
        return redirect('/');
    }

    public function update(){
        $currentUserID = Utility::getCurrentUserID();
        $date = date("Y-m-d H:i:s");

        $tempDescription_en    = (Input::has('description_en')) ? Input::get('description_en') : "";
        $tempDescription_jp    = (Input::has('description_jp')) ? Input::get('description_jp') : "";

        // DB::statement("DELETE FROM `service_price` WHERE `type` = 'POPULARDESTINATION'");
        DB::statement("DELETE FROM `display_information` WHERE `type` = 'POPULARDESTINATION'");

        // DB::table('service_price')->insert([
        //     ['type' => 'POPULARDESTINATION', 'text' => $tempDescription, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        // ]);
        DB::table('display_information')->insert([
            ['type' => 'POPULARDESTINATION', 'text_en' => $tempDescription_en,'text_jp' => $tempDescription_jp, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        ]);

        return redirect()->action('Setup\PopularDestinationInformation\PopularDestinationInformationController@edit');
    }
}
