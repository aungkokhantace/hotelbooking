<?php

namespace App\Http\Controllers\Setup\Facilities;

use App\Core\Utility;
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
    private $repo;

    public function __construct(FacilitiesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $facilities = $this->repo->getObjs();
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
        $name    = Input::get('name');
        $description    = Input::get('description');

        //Start Saving Image
        $removeImageFlag          = (Input::has('removeImageFlag')) ? Input::get('removeImageFlag') : 0;
        $path         = base_path().'/public/images/upload/';

        if(Input::hasFile('photo'))
        {
            $photo        = Input::file('photo');

            $photo_name_original    = Utility::getImage($photo);
            $photo_ext      = Utility::getImageExt($photo);
            $photo_name     = uniqid() . "." . $photo_ext;
            $image          = Utility::resizeImage($photo,$photo_name,$path);
        }
        else{
            $photo_name = "";
        }

        if($removeImageFlag == 1){
            $photo_name = "";
        }
        //End Saving Image

        $paramObj = new Facilities();
        $paramObj->name = $name;
        $paramObj->description = $description;
        $paramObj->icon = $photo_name;

        $result = $this->repo->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Success', 'Facility created ...'));
        }
        else{

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Facility did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $facilities  = $this->repo->getObjByID($id);

            return view('backend.facilities.facilities')->with('facilities', $facilities);
        }
        return redirect('/backend/login');
    }

    public function update(FacilitiesEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $name                       = Input::get('name');
        $description                = Input::get('description');

        $removeImageFlag          = (Input::has('removeImageFlag')) ? Input::get('removeImageFlag') : 0;
        $path         = base_path().'/public/images/upload/';

        if(Input::hasFile('photo')){
            $photo        = Input::file('photo');

            $photo_name_original    = Utility::getImage($photo);
            $photo_ext      = Utility::getImageExt($photo);
            $photo_name     = uniqid() . "." . $photo_ext;
            $image          = Utility::resizeImage($photo,$photo_name,$path);

            $paramObj = Facilities::find($id);
            $paramObj->name = $name;
            $paramObj->description = $description;
            $paramObj->icon = $photo_name;

            $result = $this->repo->update($paramObj);
        }else{
            $paramObj = Facilities::find($id);
            $paramObj->name = $name;
            $paramObj->description = $description;

            //without this condition, when image is removed in update, it won't be removed in DB
            if($removeImageFlag == 1){
                $paramObj->icon     = "";
            }

            $result = $this->repo->update($paramObj);
        }


        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Success', 'Facility updated ...'));
        }
        else{

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Facility did not update ...'));
        }
    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\Facilities\FacilitiesController@index'); //to redirect listing page
    }



}

