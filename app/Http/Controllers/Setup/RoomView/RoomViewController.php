<?php

namespace App\Http\Controllers\Setup\RoomView;

use App\Setup\RoomView\RoomView;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\RoomViewEntryRequest;
use App\Backend\Infrastructure\Forms\RoomViewEditRequest;
use App\Setup\RoomView\RoomViewRepositoryInterface;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;

class RoomViewController extends Controller
{
    private $repo;

    public function __construct(RoomViewRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $room_views = $this->repo->getObjs();
            return view('backend.room_view.index')->with('room_views',$room_views);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            return view('backend.room_view.room_view');
        }
        return redirect('/');
    }

    public function store(RoomViewEntryRequest $request)
    {
        $request->validate();
        $name               = Input::get('name');
        $description        = Input::get('description');

        $paramObj           = new RoomView();
        $paramObj->name     = $name;
        $paramObj->description     = $description;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomView\RoomViewController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room View is created ...'));
        }
        else{
            return redirect()->action('Setup\RoomView\RoomViewController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room View is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $room_view = $this->repo->getObjByID($id);
            return view('backend.room_view.room_view')->with('room_view', $room_view);
        }
        return redirect('/');
    }

    public function update(RoomViewEditRequest $request){

        $request->validate();
        $id                                         = Input::get('id');
        $name                                       = Input::get('name');
        $description                                = Input::get('description');

        $paramObj                                   = $this->repo->getObjByID($id);
        $paramObj->name                             = $name;
        $paramObj->description                      = $description;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\RoomView\RoomViewController@index')
                ->withMessage(FormatGenerator::message('Success', 'Room View is updated ...'));
        }
        else{
            return redirect()->action('Setup\RoomView\RoomViewController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Room View is not updated ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\RoomView\RoomViewController@index'); //to redirect listing page
    }
}
