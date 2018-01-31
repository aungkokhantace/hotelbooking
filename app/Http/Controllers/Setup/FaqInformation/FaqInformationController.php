<?php

namespace App\Http\Controllers\Setup\FaqInformation;

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

class FaqInformationController extends Controller
{
     private $repo;

    public function __construct()
    {

    }

    public function edit(){
        if (Auth::guard('User')->check()) {
            $FaqInfo     = DB::select("SELECT * FROM `service_price` WHERE `type` = 'FAQ' LIMIT 1");

            $faqInformation = array();
            if (is_null($FaqInfo) || count($FaqInfo) == 0)
            {
                $faqInformation['description']   = "";
                return view('backend.faqinformation.faqinformation')->with('faqInformation', $faqInformation);
            }
            $faqInformation["description"] = $FaqInfo[0]->text;
            return view('backend.faqinformation.faqinformation')->with('faqInformation', $faqInformation);
        }
        return redirect('/');
    }

    public function update(){
        $currentUserID = Utility::getCurrentUserID();
        $date = date("Y-m-d H:i:s");

        $tempDescription    = (Input::has('description')) ? Input::get('description') : "";

        DB::statement("DELETE FROM `service_price` WHERE `type` = 'FAQ'");

        DB::table('service_price')->insert([
            ['type' => 'FAQ', 'text' => $tempDescription, 'created_by' => $currentUserID, 'updated_by' => $currentUserID, 'created_at' => $date, 'updated_at' => $date]
        ]);

        return redirect()->action('Setup\FaqInformation\FaqInformationController@edit');
    }
}
