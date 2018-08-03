<?php

namespace App\Http\Controllers\Setup\PromotionInformation;

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

class PromotionInformationController extends Controller
{
    private $repo;

    public function __construct()
    {

    }

    public function edit(){
        if (Auth::guard('User')->check()) {
            // $tempPromotionInfo      = DB::select("SELECT * FROM `service_price` WHERE `type` = 'PROMOTION' LIMIT 1");

            $tempPromotionInfo      = DB::select("SELECT * FROM `display_information` WHERE `type` = 'PROMOTION' LIMIT 1");

            $promotionInformation = array();
            if (is_null($tempPromotionInfo) || count($tempPromotionInfo) == 0)
            {
                $promotionInformation['description_en']   = "";
                $promotionInformation['description_jp']   = "";
                return view('backend.promotioninformation.promotioninformation')->with('promotionInformation', $promotionInformation);
            }
            $promotionInformation["description_en"] = $tempPromotionInfo[0]->text_en;
            $promotionInformation["description_jp"] = $tempPromotionInfo[0]->text_jp;
            return view('backend.promotioninformation.promotioninformation')->with('promotionInformation', $promotionInformation);
        }
        return redirect('/');
    }

    public function update(){
        $currentUserID = Utility::getCurrentUserID();
        $date = date("Y-m-d H:i:s");

        $tempDescription_en    = (Input::has('description_en')) ? Input::get('description_en') : "";
        $tempDescription_jp    = (Input::has('description_jp')) ? Input::get('description_jp') : "";

        // DB::statement("DELETE FROM `service_price` WHERE `type` = 'PROMOTION'");
        DB::statement("DELETE FROM `display_information` WHERE `type` = 'PROMOTION'");

        // DB::table('service_price')->insert([
        //     ['type' => 'PROMOTION', 'text' => $tempDescription, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        // ]);
        DB::table('display_information')->insert([
            ['type' => 'PROMOTION', 'text_en' => $tempDescription_en,'text_jp' => $tempDescription_jp, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        ]);

        return redirect()->action('Setup\PromotionInformation\PromotionInformationController@edit');
    }
}
