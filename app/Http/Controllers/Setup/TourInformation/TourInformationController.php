<?php

namespace App\Http\Controllers\Setup\TourInformation;

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

class TourInformationController extends Controller
{
    private $repo;

    public function __construct()
    {

    }

    public function edit(){
        if (Auth::guard('User')->check()) {
            $tempTourInfo      = DB::select("SELECT * FROM `service_price` WHERE `type` = 'TOUR' LIMIT 1");

            $tourInformation = array();
            if (is_null($tempTourInfo) || count($tempTourInfo) == 0)
            {
                $tourInformation['description']   = "";
                return view('backend.tourinformation.tourinformation')->with('tourInformation', $tourInformation);
            }
            $tourInformation["description"] = $tempTourInfo[0]->text;
            return view('backend.tourinformation.tourinformation')->with('tourInformation', $tourInformation);
        }
        return redirect('/');
    }

    public function update(){
        $currentUserID = Utility::getCurrentUserID();
        $date = date("Y-m-d H:i:s");

        $tempDescription    = (Input::has('description')) ? Input::get('description') : "";

        DB::statement("DELETE FROM `service_price` WHERE `type` = 'TOUR'");

        DB::table('service_price')->insert([
            ['type' => 'TOUR', 'text' => $tempDescription, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        ]);

        return redirect()->action('Setup\TourInformation\TourInformationController@edit');
    }
}
