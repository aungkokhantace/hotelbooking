<?php

namespace App\Http\Controllers\Setup\Facilities;

use App\Core\Utility;
use App\Setup\FacilityGroup\FacilityGroupRepository;
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
            $facilityGroupRepo  = new FacilityGroupRepository();
            $facility_group     = $facilityGroupRepo->getObjs();
            return view('backend.facilities.facilities')->with('facility_group',$facility_group);
        }
        return redirect('/');
    }

    public function store(FacilitiesEntryRequest $request)
    {
        $request->validate();
        $name               = Input::get('name');
        $facility_group_id  = Input::get('facility_group');
        $description        = Input::get('description');
        $type               = Input::get('type');
        $popular            = Input::has('popular')?Input::get('popular'):0;

        //Start Saving Image
        $removeImageFlag = (Input::has('removeImageFlag')) ? Input::get('removeImageFlag') : 0;
        $path            = base_path().'/public/images/upload/';

        if(Input::hasFile('photo'))
        {
            $photo        = Input::file('photo');

            $photo_name_original    = Utility::getImage($photo);
            $photo_ext      = Utility::getImageExt($photo);
            $photo_name     = uniqid() . "." . $photo_ext;
            // $image          = Utility::resizeImage($photo,$photo_name,$path);
            $imgWidth       = 24;
            $imgHeight      = 24;
            $image          = Utility::resizeImageWithDefaultWidthHeight($photo,$photo_name,$path,$imgWidth,$imgHeight);
        }
        else{
            $photo_name = "";
        }

        if($removeImageFlag == 1){
            $photo_name = "";
        }
        //End Saving Image

        $paramObj                       = new Facilities();
        $paramObj->name                 = $name;
        $paramObj->facility_group_id    = $facility_group_id;
        $paramObj->description          = $description;
        $paramObj->icon                 = $photo_name;
        $paramObj->type                 = $type;
        $paramObj->popular              = $popular;

        $result = $this->repo->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Success', 'Facility is created ...'));
        }
        else{

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Facility is not created ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $facilities  = $this->repo->getObjByID($id);
            $facilityGroupRepo  = new FacilityGroupRepository();
            $facility_group     = $facilityGroupRepo->getObjs();
            return view('backend.facilities.facilities')
                ->with('facilities', $facilities)
                ->with('facility_group', $facility_group);
        }
        return redirect('/backend_mps/login');
    }

    public function update(FacilitiesEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $name                       = Input::get('name');
        $facility_group_id          = Input::get('facility_group');
        $description                = Input::get('description');
        $type                       = Input::get('type');
        $popular                    = Input::has('popular')?Input::get('popular'):0;

        $removeImageFlag            = (Input::has('removeImageFlag')) ? Input::get('removeImageFlag') : 0;
        $path                       = base_path().'/public/images/upload/';

        if(Input::hasFile('photo')){
            $photo                  = Input::file('photo');

            $photo_name_original    = Utility::getImage($photo);
            $photo_ext              = Utility::getImageExt($photo);
            $photo_name             = uniqid() . "." . $photo_ext;
            // $image                  = Utility::resizeImage($photo,$photo_name,$path);
            $imgWidth               = 24;
            $imgHeight              = 24;
            $image                  = Utility::resizeImageWithDefaultWidthHeight($photo,$photo_name,$path,$imgWidth,$imgHeight);

            $paramObj                       = Facilities::find($id);
            $paramObj->name                 = $name;
            $paramObj->facility_group_id    = $facility_group_id;
            $paramObj->description          = $description;
            $paramObj->icon                 = $photo_name;

            $result = $this->repo->update($paramObj);
        }else{
            $paramObj                       = Facilities::find($id);
            $paramObj->name                 = $name;
            $paramObj->facility_group_id    = $facility_group_id;
            $paramObj->description          = $description;
            $paramObj->type                 = $type;
            $paramObj->popular              = $popular;

            //without this condition, when image is removed in update, it won't be removed in DB
            if($removeImageFlag == 1){
                $paramObj->icon     = "";
            }

            $result = $this->repo->update($paramObj);
        }


        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Success', 'Facility is updated ...'));
        }
        else{

            return redirect()->action('Setup\Facilities\FacilitiesController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Facility is not updated ...'));
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
