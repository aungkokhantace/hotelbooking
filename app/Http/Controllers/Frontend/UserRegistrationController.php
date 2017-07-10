<?php

namespace App\Http\Controllers\Frontend;

use App\Setup\Customer\CustomerRepositoryInterface;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

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
            $f_name                         = trim(Input::get('first_name'));
            $l_name                         = trim(Input::get('last_name'));
            $display_name                   = $f_name.' '.$l_name;
            $email                          = trim(Input::get('email'));
            $pwd                            = bcrypt(trim(Input::get('password')));

            $paramObj                       = new User();
            $paramObj->first_name           = $f_name;
            $paramObj->last_name            = $l_name;
            $paramObj->display_name         = $display_name;
            $paramObj->email                = $email;
            $paramObj->password             = $pwd;
            $paramObj->role_id              = 4;

            $res                            = $this->repo->create($paramObj);

            $response['aceplusStatusCode']  = '200';

        }
        else{
            $response['aceplusStatusCode']  = '202';
        }
        return \Response::json($response);


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
