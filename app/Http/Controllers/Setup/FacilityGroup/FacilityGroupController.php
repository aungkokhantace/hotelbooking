<?php

namespace App\Http\Controllers\Setup\FacilityGroup;

use App\Backend\Infrastructure\Forms\FacilityGroupEditRequest;
use App\Backend\Infrastructure\Forms\FacilityGroupEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Setup\FacilityGroup\FacilityGroup;
use App\Setup\FacilityGroup\FacilityGroupRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class FacilityGroupController extends Controller
{
    private $repo;

    public function __construct(FacilityGroupRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $facility_group = $this->repo->getObjs();
            return view('backend.facility_group.index')->with('facility_group',$facility_group);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            return view('backend.facility_group.facility_group');
        }
        return redirect('/');
    }

    public function store(FacilityGroupEntryRequest $request)
    {
        $request->validate();
        $name       = Input::get('name');
        $remark     = Input::get('remark');

        //Start Saving Image
        $removeImageFlag            = (Input::has('removeImageFlag')) ? Input::get('removeImageFlag') : 0;
        $path                       = base_path().'/public/images/upload/';

        if(Input::hasFile('photo'))
        {
            $photo                  = Input::file('photo');

            $photo_name_original    = Utility::getImage($photo);
            $photo_ext              = Utility::getImageExt($photo);
            $photo_name             = uniqid() . "." . $photo_ext;
            $image                  = Utility::resizeImage($photo,$photo_name,$path);
        }
        else{
            $photo_name = "";
        }

        if($removeImageFlag == 1){
            $photo_name = "";
        }
        //End Saving Image

        $paramObj           = new FacilityGroup();
        $paramObj->name     = $name;
        $paramObj->remark   = $remark;
        $paramObj->icon     = $photo_name;

        $result = $this->repo->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\FacilityGroup\FacilityGroupController@index')
                ->withMessage(FormatGenerator::message('Success', 'Facility Group is created ...'));
        }
        else{

            return redirect()->action('Setup\FacilityGroup\FacilityGroupController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Facility Group is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $facility_group  = $this->repo->getObjByID($id);

            return view('backend.facility_group.facility_group')->with('facility_group', $facility_group);
        }
        return redirect('/backend_mps/login');
    }

    public function update(FacilityGroupEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $name                       = Input::get('name');
        $remark                     = Input::get('remark');

        $removeImageFlag            = (Input::has('removeImageFlag')) ? Input::get('removeImageFlag') : 0;
        $path                       = base_path().'/public/images/upload/';

        if(Input::hasFile('photo')){
            $photo        = Input::file('photo');

            $photo_name_original    = Utility::getImage($photo);
            $photo_ext              = Utility::getImageExt($photo);
            $photo_name             = uniqid() . "." . $photo_ext;
            $image                  = Utility::resizeImage($photo,$photo_name,$path);

            $paramObj           = FacilityGroup::find($id);
            $paramObj->name     = $name;
            $paramObj->remark   = $remark;
            $paramObj->icon     = $photo_name;

            $result = $this->repo->update($paramObj);
        }else{
            $paramObj               = FacilityGroup::find($id);
            $paramObj->name         = $name;
            $paramObj->remark       = $remark;

            //without this condition, when image is removed in update, it won't be removed in DB
            if($removeImageFlag == 1){
                $paramObj->icon     = "";
            }

            $result = $this->repo->update($paramObj);
        }
//         dd($result);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\FacilityGroup\FacilityGroupController@index')
                ->withMessage(FormatGenerator::message('Success', 'Facility Group is updated ...'));
        }
        else{

            return redirect()->action('Setup\FacilityGroup\FacilityGroupController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Facility Group is not updated ...'));
        }
    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\FacilityGroup\FacilityGroupController@index'); //to redirect listing page
    }
}
