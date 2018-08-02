<?php

namespace App\Http\Controllers\Setup\ContactUs;

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

class ContactUsController extends Controller
{
    private $repo;

    public function __construct()
    {

    }

    public function edit(){
        if (Auth::guard('User')->check()) {
            // $tempContactUs      = DB::select("SELECT * FROM `service_price` WHERE `type` = 'CONTACTUS' LIMIT 1");
            $tempContactUs      = DB::select("SELECT * FROM `display_information` WHERE `type` = 'CONTACTUS' LIMIT 1");

            $contactUs = array();
            if (is_null($tempContactUs) || count($tempContactUs) == 0)
            {
                $contactUs['description_en']   = "";
                $contactUs['description_jp']   = "";
                return view('backend.contactus.contactus')->with('contactUs', $contactUs);
            }
            $contactUs["description_en"] = $tempContactUs[0]->text_en;
            $contactUs["description_jp"] = $tempContactUs[0]->text_jp;

            return view('backend.contactus.contactus')->with('contactUs', $contactUs);
        }
        return redirect('/');
    }

    public function update(){
        $currentUserID = Utility::getCurrentUserID();
        $date = date("Y-m-d H:i:s");

        $tempDescription_en    = (Input::has('description_en')) ? Input::get('description_en') : "";
        $tempDescription_jp    = (Input::has('description_jp')) ? Input::get('description_jp') : "";

        // DB::statement("DELETE FROM `service_price` WHERE `type` = 'CONTACTUS'");
        DB::statement("DELETE FROM `display_information` WHERE `type` = 'CONTACTUS'");

        // DB::table('service_price')->insert([
        //     ['type' => 'CONTACTUS', 'text' => $tempDescription, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        // ]);

        DB::table('display_information')->insert([
            ['type' => 'CONTACTUS', 'text_en' => $tempDescription_en, 'text_jp' => $tempDescription_jp, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        ]);

        return redirect()->action('Setup\ContactUs\ContactUsController@edit');
    }
}
