<?php

namespace App\Http\Controllers\Setup\Feature;

use App\Core\Utility;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\FeatureEntryRequest;
use App\Backend\Infrastructure\Forms\FeatureEditRequest;
use App\Setup\Feature\FeatureRepositoryInterface;
use App\Setup\Feature\Feature;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use InterventionImage;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;

class FeatureController extends Controller
{
    private $repo;

    public function __construct(FeatureRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $features = $this->repo->getObjs();
            return view('backend.feature.index')->with('features',$features);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            return view('backend.feature.feature');
        }
        return redirect('/');
    }

    public function store(FeatureEntryRequest $request)
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

        $paramObj = new Feature();
        $paramObj->name = $name;
        $paramObj->description = $description;
        $paramObj->icon = $photo_name;

        $result = $this->repo->create($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Feature\FeatureController@index')
                ->withMessage(FormatGenerator::message('Success', 'Feature created ...'));
        }
        else{

            return redirect()->action('Setup\Feature\FeatureController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Feature did not create ...'));
        }

    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $feature  = $this->repo->getObjByID($id);
            return view('backend.feature.feature')->with('feature', $feature);
        }
        return redirect('/backend/login');
    }

    public function update(FeatureEditRequest $request){
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

            $paramObj = Feature::find($id);
            $paramObj->name = $name;
            $paramObj->description = $description;
            $paramObj->icon = $photo_name;

            $result = $this->repo->update($paramObj);
        }else{
            $paramObj = Feature::find($id);
            $paramObj->name = $name;
            $paramObj->description = $description;

            //without this condition, when image is removed in update, it won't be removed in DB
            if($removeImageFlag == 1){
                $paramObj->icon     = "";
            }

            $result = $this->repo->update($paramObj);
        }

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Feature\FeatureController@index')
                ->withMessage(FormatGenerator::message('Success', 'Feature updated ...'));
        }
        else{

            return redirect()->action('Setup\Feature\FeatureController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Feature did not update ...'));
        }
    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\Feature\FeatureController@index'); //to redirect listing page
    }
}

