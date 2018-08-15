<?php

namespace App\Http\Controllers\Setup\GuideInformation;

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

class GuideInformationController extends Controller
{
    private $repo;

    public function __construct()
    {

    }

    public function edit(){
        if (Auth::guard('User')->check()) {
            // $tempGuideInfo      = DB::select("SELECT * FROM `service_price` WHERE `type` = 'GUIDE' LIMIT 1");

            $tempGuideInfo      = DB::select("SELECT * FROM `display_information` WHERE `type` = 'GUIDE' LIMIT 1");

            $guideInformation = array();
            if (is_null($tempGuideInfo) || count($tempGuideInfo) == 0)
            {
                $guideInformation['description_en']   = "";
                $guideInformation['description_jp']   = "";
                return view('backend.guideinformation.guideinformation')->with('guideInformation', $guideInformation);
            }
            $guideInformation["description_en"] = $tempGuideInfo[0]->text_en;
            $guideInformation["description_jp"] = $tempGuideInfo[0]->text_jp;
            return view('backend.guideinformation.guideinformation')->with('guideInformation', $guideInformation);
        }
        return redirect('/');
    }

    public function update(){
        $currentUserID = Utility::getCurrentUserID();
        $date = date("Y-m-d H:i:s");

        $tempDescription_en    = (Input::has('description_en')) ? Input::get('description_en') : "";
        $tempDescription_jp    = (Input::has('description_jp')) ? Input::get('description_jp') : "";

        // DB::statement("DELETE FROM `service_price` WHERE `type` = 'GUIDE'");
        DB::statement("DELETE FROM `display_information` WHERE `type` = 'GUIDE'");

        // DB::table('service_price')->insert([
        //     ['type' => 'GUIDE', 'text' => $tempDescription, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        // ]);
        DB::table('display_information')->insert([
            ['type' => 'GUIDE', 'text_en' => $tempDescription_en,'text_jp' => $tempDescription_jp, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        ]);

        return redirect()->action('Setup\GuideInformation\GuideInformationController@edit');
    }
}
