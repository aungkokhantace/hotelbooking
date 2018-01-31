<?php

namespace App\Http\Controllers\Setup\VisaInformation;

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

class VisaInformationController extends Controller
{
    
       private $repo;

    public function __construct()
    {

    }

    public function edit(){
        if (Auth::guard('User')->check()) {
            $VisaInfo     = DB::select("SELECT * FROM `service_price` WHERE `type` = 'VISA' LIMIT 1");

            $visaInformation = array();
            if (is_null($VisaInfo) || count($VisaInfo) == 0)
            {
                $visaInformation['description']   = "";
                return view('backend.visainformation.visainformation')->with('visaInformation', $visaInformation);
            }
            $visaInformation["description"] = $VisaInfo[0]->text;
            return view('backend.visainformation.visainformation')->with('visaInformation', $visaInformation);
        }
        return redirect('/');
    }

    public function update(){
        $currentUserID = Utility::getCurrentUserID();
        $date = date("Y-m-d H:i:s");

        $tempDescription    = (Input::has('description')) ? Input::get('description') : "";

        DB::statement("DELETE FROM `service_price` WHERE `type` = 'VISA'");

        DB::table('service_price')->insert([
            ['type' => 'VISA', 'text' => $tempDescription, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        ]);

        return redirect()->action('Setup\VisaInformation\VisaInformationController@edit');
    }
}
