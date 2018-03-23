<?php

namespace App\Http\Controllers\Setup\EventEmail;

use App\Backend\Infrastructure\Forms\EventEmailEditRequest;
use App\Backend\Infrastructure\Forms\EventEmailEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\EventEmail\EventEmailRepositoryInterface;
use App\Setup\EventEmail\EventEmailRepository;
use App\Setup\EventEmail\EventEmail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;

class EventEmailController extends Controller
{
    private $repo;

    public function __construct(EventEmailRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
         if (Auth::guard('User')->check()) {
             $events          = $this->repo->getObjs();
             return view('backend.event_email.index')->with('events',$events);
         }
         return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){

            return view('backend.event_email.event');
        }
        return redirect('/');
    }

    public function store(EventEmailEntryRequest $request)
    {
        $request->validate();
        $email              = Input::get('email');
        $description        = Input::get('description');
        $type               = Input::get('type');
        $status             = 1;

        $paramObj                           = new EventEmail();
        $paramObj->email                    = $email;
        $paramObj->description              = $description;
        $paramObj->type                     = $type;
        $paramObj->status                   = $status;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\EventEmail\EventEmailController@index')
                ->withMessage(FormatGenerator::message('Success', 'Event is created ...'));
        }
        else{
            return redirect()->action('Setup\EventEmail\EventEmailController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Event is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $event       = $this->repo->getObjByID($id);

            return view('backend.event_email.event')
                ->with('event',$event);
        }
        return redirect('/backend_mps/login');
    }

    public function update(EventEmailEditRequest $request)
    {
        $request->validate();
        $id                       = Input::get('id');
        $email                    = Input::get('email');
        $description              = Input::get('description');
        $type                     = Input::get('type');
        $status                   = 1;

        $paramObj                 = EventEmail::find($id);
        $paramObj->email          = $email;
        $paramObj->description    = $description;
        $paramObj->type           = $type;
        $paramObj->status         = $status;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\EventEmail\EventEmailController@index')
                ->withMessage(FormatGenerator::message('Success', 'Event is updated ...'));
        }
        else{
            return redirect()->action('Setup\EventEmail\EventEmailController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Event is not updatedd ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\EventEmail\EventEmailController@index'); //to redirect listing page
    }
}
