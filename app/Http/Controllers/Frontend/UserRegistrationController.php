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

    public function store(){
        $f_name                 = trim(Input::get('first_name'));
        $l_name                 = trim(Input::get('last_name'));
        $email                  = trim(Input::get('email'));
        $pwd                    = bcrypt(trim(Input::get('password')));

        $paramObj               = new User();
        $paramObj->first_name   = $f_name;
        $paramObj->last_name    = $l_name;
        $paramObj->email        = $email;
        $paramObj->password     = $pwd;
        $paramObj->role_id      = 4;

        $this->repo->create($paramObj);

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