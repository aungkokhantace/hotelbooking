<?php

namespace App\Http\Controllers\Setup\Landmark;

use App\Backend\Infrastructure\Forms\LandMarkEditRequest;
use App\Backend\Infrastructure\Forms\LandMarkEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Landmark\Landmark;
use App\Setup\Landmark\LandmarkRepositoryInterface;
use App\Setup\Township\TownshipRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class LandmarkController extends Controller
{
    private $repo;

    public function __construct(LandmarkRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $landmarks = $this->repo->getObjs();
            return view('backend.landmark.index')->with('landmarks',$landmarks);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $townshipRepo       = new TownshipRepository();
            $townships          = $townshipRepo->getObjs();
            return view('backend.landmark.landmark')->with('townships',$townships);
        }
        return redirect('/');
    }

    public function store(LandMarkEntryRequest $request)
    {
        $request->validate();
        $name                       = Input::get('name');
        $township                   = Input::get('township');
        $latitude                   = Input::get('latitude');
        $longitude                  = Input::get('longitude');
        $is_popular                 = Input::get('popular') == "true"? 1: 0;
        $description                = Input::get('description');

        $paramObj                   = new Landmark();
        $paramObj->name             = $name;
        $paramObj->township_id      = $township;
        $paramObj->latitude         = $latitude;
        $paramObj->longitude        = $longitude;
        $paramObj->is_popular       = $is_popular;
        $paramObj->description      = $description;

        $result                     = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\Landmark\LandmarkController@index')
                ->withMessage(FormatGenerator::message('Success', 'Landmark created ...'));
        }
        else{
            return redirect()->action('Setup\Landmark\LandmarkController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Landmark did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $townshipRepo       = new TownshipRepository();
            $townships          = $townshipRepo->getObjs();
            $landmark           = $this->repo->getObjByID($id);
            return view('backend.landmark.landmark')->with('landmark', $landmark)
                                                    ->with('townships',$townships);
        }
        return redirect('/backend/login');
    }

    public function update(LandMarkEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $name                       = Input::get('name');
        $township                   = Input::get('township');
        $latitude                   = Input::get('latitude');
        $longitude                  = Input::get('longitude');
        $is_popular                 = Input::get('popular') == "true"? 1: 0;
        $description                = Input::get('description');

        $paramObj                   = $this->repo->getObjByID($id);
        $paramObj->name             = $name;
        $paramObj->township_id      = $township;
        $paramObj->latitude         = $latitude;
        $paramObj->longitude        = $longitude;
        $paramObj->is_popular       = $is_popular;
        $paramObj->description      = $description;
        $result                     = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\Landmark\LandmarkController@index')
                ->withMessage(FormatGenerator::message('Success', 'Landmark updated ...'));
        }
        else{
            return redirect()->action('Setup\Landmark\LandmarkController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Landmark did not update ...'));
        }

    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\Landmark\LandmarkController@index'); //to redirect listing page
    }
}
