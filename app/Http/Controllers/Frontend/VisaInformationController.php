<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Setup\Page\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Redirect;

class VisaInformationController extends Controller
{
   public function __construct()
    {
    }

    public function index(Request $request)
    {
        $temp_data = DB::select("SELECT * FROM `service_price` WHERE `type` = 'VISA' LIMIT 1");
       
        if(isset($temp_data) && count($temp_data)>0){
            $page_data = $temp_data[0]->text;
        }
        else{
            $page_data = "";
        }

        return view('frontend.visainformation')->with('page_data',$page_data);
    }
}
