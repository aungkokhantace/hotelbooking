<?php

namespace App\Http\Controllers\Language;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Redirect;

class LanguageController extends Controller
{
    public function test(){
        return view('test.test_multi_language');
    }

    public function changeLanguage(){
        if(Session::has('locale')){
            Session::put('locale',Input::get('locale'));
        }
        else{
            Session::set('locale',Input::get('locale'));
        }

        return Redirect::back();
    }
}
