<?php

namespace App\Http\Controllers\Frontend;

use App\Core\Check;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Setup\Customer\CustomerRepositoryInterface;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Session;

class UserRegistrationController extends Controller
{
    private $repo;
    public function __construct(CustomerRepositoryInterface $repo){
        $this->repo = $repo;
    }

    public function create(){
        return view('frontend.registration');
    }

    public function store(Request $request){
        $response                           = array();
        if($request->ajax()) {
            try{
                $f_name                         = trim(Input::get('first_name'));
                $l_name                         = trim(Input::get('last_name'));
                $display_name                   = $f_name.' '.$l_name;
                $email                          = trim(Input::get('email'));
                $pwd_txt                        = base64_encode(trim(Input::get('password')));
                $pwd                            = bcrypt(trim(Input::get('password')));
                $activation_code                = str_random(20);
                $name                           = $f_name.' '.$l_name;
                $activation_str                 = $activation_code.'_'.$pwd_txt;

                DB::beginTransaction();
                $paramObj                       = new User();
                $paramObj->first_name           = $f_name;
                $paramObj->last_name            = $l_name;
                $paramObj->display_name         = $display_name;
                $paramObj->email                = $email;
                $paramObj->password             = $pwd;
                $paramObj->role_id              = 4;
                $paramObj->activation_code      = $activation_code;

                $res                            = $this->repo->create($paramObj);
                if($res['aceplusStatusCode'] == ReturnMessage::OK){
                    //Confirmation Mail Send
                    $sendMailResult             = Utility::sendVerificationMail($email,$name,$activation_str);
                    if($sendMailResult['aceplusStatusCode'] == ReturnMessage::OK){
                        $response['aceplusStatusCode']  = '200';
                        DB::commit();
                    }
                    else{
                        $response['aceplusStatusCode']  = '201';
                        DB::rollback();
                    }
                }
                else{
                    $response['aceplusStatusCode']  = '500';
                    DB::rollback();
                }

            }
            catch(\Exception $e){
                $response['aceplusStatusCode']  = '500';
            }
        }
        else{
            $response['aceplusStatusCode']  = '202';
        }
        return \Response::json($response);
    }

    public function verify($confirmation_code)
    {
//        $last_pos           = strripos($confirmation_code,'_')+1;
        $password           = base64_decode(substr($confirmation_code,21));
        $activation_code    = substr($confirmation_code,0,20);

        $customer           = User::where('activation_code',$activation_code)->whereNull('deleted_at')->first();
        $customer->confirm  = 1;
        $customer->save();

        $email              = $customer->email;

        $auth = auth()->guard('Customer');
        $credentials = [
            'email'     => $email,
            'password'  => $password
        ];
        if($auth->attempt($credentials)){
            $auth_id = auth()->guard('Customer')->id();
            Check::createSessionCustomer($auth_id);
            return redirect('bookingList');
        }
        return redirect('/');

    }

    public function check_email(){
        $email      = Input::get('email');
        $customer   = User::where('email','=',$email)->whereNull('deleted_at')->get();
        $result     = false;
        if(count($customer) == 0 ){
            $result = true;
        }

        return \Response::json($result);
    }
}
