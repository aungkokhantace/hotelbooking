<?php
/**
 * Created by PhpStorm.
 * User: william
 * Author: Wai Yan Aung
 * Date: 1/14/2017
 * Time: 10:55 AM
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Setup\Page\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Redirect;

class TourInformationController extends Controller
{

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $temp_data = DB::select("SELECT * FROM `service_price` WHERE `type` = 'TOUR' LIMIT 1");
        if(isset($temp_data) && count($temp_data)>0){
        $page_data = $temp_data[0]->text;
    }
    else{
        $page_data = "";
    }

        return view('frontend.tourinformation')->with('page_data',$page_data);
    }

}
