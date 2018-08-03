<?php

namespace App\Http\Controllers\Setup\RecommendedHotelInformation;

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

class RecommendedHotelInformationController extends Controller
{
    private $repo;

    public function __construct()
    {

    }

    public function edit(){
        if (Auth::guard('User')->check()) {
            // $tempRecommendedHotelInfo      = DB::select("SELECT * FROM `service_price` WHERE `type` = 'RECOMMENDEDHOTEL' LIMIT 1");

            $tempRecommendedHotelInfo      = DB::select("SELECT * FROM `display_information` WHERE `type` = 'RECOMMENDEDHOTEL' LIMIT 1");

            $recommendedHotelInformation = array();
            if (is_null($tempRecommendedHotelInfo) || count($tempRecommendedHotelInfo) == 0)
            {
                $recommendedHotelInformation['description_en']   = "";
                $recommendedHotelInformation['description_jp']   = "";
                return view('backend.recommendedhotelinformation.recommendedhotelinformation')->with('recommendedHotelInformation', $recommendedHotelInformation);
            }
            $recommendedHotelInformation["description_en"] = $tempRecommendedHotelInfo[0]->text_en;
            $recommendedHotelInformation["description_jp"] = $tempRecommendedHotelInfo[0]->text_jp;
            return view('backend.recommendedhotelinformation.recommendedhotelinformation')->with('recommendedHotelInformation', $recommendedHotelInformation);
        }
        return redirect('/');
    }

    public function update(){
        $currentUserID = Utility::getCurrentUserID();
        $date = date("Y-m-d H:i:s");

        $tempDescription_en    = (Input::has('description_en')) ? Input::get('description_en') : "";
        $tempDescription_jp    = (Input::has('description_jp')) ? Input::get('description_jp') : "";

        // DB::statement("DELETE FROM `service_price` WHERE `type` = 'RECOMMENDEDHOTEL'");
        DB::statement("DELETE FROM `display_information` WHERE `type` = 'RECOMMENDEDHOTEL'");

        // DB::table('service_price')->insert([
        //     ['type' => 'RECOMMENDEDHOTEL', 'text' => $tempDescription, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        // ]);
        DB::table('display_information')->insert([
            ['type' => 'RECOMMENDEDHOTEL', 'text_en' => $tempDescription_en,'text_jp' => $tempDescription_jp, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        ]);

        return redirect()->action('Setup\RecommendedHotelInformation\RecommendedHotelInformationController@edit');
    }
}
