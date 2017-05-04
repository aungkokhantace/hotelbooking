<?php

namespace App\Http\Controllers\Frontend;

use App\Core\Check;
use App\Frontend\Infrastructure\Forms\LoginRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;
use Session;

class LoginController extends Controller
{
    public function validSession()
    {
        $sessionObj = session('customer');
        if(isset($sessionObj)){
            return true;
        }
        return false;
    }

    public function showLogin(){
        $url = URL::previous();
        Session::put('prev_url',$url);

        if(!$this->validSession()){
            return view('frontend.login');
        }
        return redirect('/');
    }

    public function doLogin(Request $request){
        if($request->ajax()){
            $input = Input::all();
//            print_r($input);die();
            if(count($input) > 0 ){
                $auth = auth()->guard('Customer');

                $credentials = [
                    'email' => $input['email'],
                    'password'=>$input['password'],
                    'role_id'   => 4
                ];

                if($auth->attempt($credentials)){
                    $id = Auth::guard('Customer')->id();
                    Check::createSessionCustomer($id);
                    $result = ['Status 200'];
                }
                else{
                    $result = ['Status 401'];
                    session(['auth-error' => 'The email address or password is incorrect!']);
                }
                return \Response::json($result);

            }else{
                $result = ['Status 401'];
                return \Response::json($result);
//                return view('frontend.login.index');
            }
        }
    }

    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? Lang::get('auth.failed')
            : 'The email address or password is incorrect.';
    }

    public function logout(){
        if(Session::has('customer')){
            Session::flush();
        }
        return redirect('/');
    }
}
