<?php

namespace App\Http\Controllers\Setup\Facilities;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\FacilitiesEntryRequest;
use App\Backend\Infrastructure\Forms\FacilitiesEditRequest;
use App\Setup\Facilities\FacilitiesRepositoryInterface;
use App\Setup\Facilities\Facilities;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use InterventionImage;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;

class FacilitiesController extends Controller
{
    private $facilitiesRepository;

    public function __construct(FacilitiesRepositoryInterface $facilitiesRepository)
    {
        $this->facilitiesRepository = $facilitiesRepository;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $facilities = Facilities::all();
            return view('backend.facilities.index')->with('facilities',$facilities);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){

            return view('backend.facilities.facilities');
        }
        return redirect('/');
    }

    public function store(FacilitiesEntryRequest $request)
    {

        $request->validate();
        $facilities_name    = Input::get('facilities_name');

        $facilities_icon    = Input::file('facilities_icon');

        $file_name     = uniqid().'.'.$facilities_icon->getClientOriginalExtension();
        $path           = base_path().'/public/images/upload/';
        $facilities_icon->move($path, $file_name);

        $image1 = InterventionImage::make(sprintf($path .'/%s', $file_name))->resize(300, 300)->save();

        $paramObj = new Facilities();
        $paramObj->facilities_name = $facilities_name;
        $paramObj->facilities_icon = $file_name;

        $result = $this->facilitiesRepository->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Success', 'Facilities created ...'));
        }
        else{

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Facilities did not create ...'));
        }

    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $facilities  = Facilities::find($id);

            return view('backend.facilities.facilities')->with('facilities', $facilities);
        }
        return redirect('/backend/login');
    }

    public function update(FacilitiesEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $facilities_name            = Input::get('facilities_name');

        if(Input::hasFile('facilities_icon')){
            $facilities_icon = Input::file('facilities_icon');
            $file_name       = uniqid().'.'.$facilities_icon->getClientOriginalExtension();
            $path            = base_path().'/public/images/upload/';
            $facilities_icon->move($path, $file_name);

            $image1 = InterventionImage::make(sprintf($path .'/%s', $file_name))->resize(300, 300)->save();

            $paramObj                   = Facilities::find($id);
            $paramObj->facilities_name  = $facilities_name;
            $paramObj->facilities_icon  = $facilities_icon;

            $result = $this->facilitiesRepository->update($paramObj);
        }else{
            $paramObj                   = Facilities::find($id);
            $paramObj->facilities_name  = $facilities_name;

            $result = $this->facilitiesRepository->update($paramObj);

        }

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Success', 'Facilities updated ...'));
        }
        else{

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Facilities did not update ...'));
        }
    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->facilitiesRepository->delete($id);
        }
        return redirect()->action('Setup\Facilities\FacilitiesController@index'); //to redirect listing page
    }



}

