<?php

namespace App\Http\Controllers\Setup\Amenities;

use App\Core\Utility;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\AmenitiesEntryRequest;
use App\Backend\Infrastructure\Forms\AmenitiesEditRequest;
use App\Setup\Amenities\AmenitiesRepositoryInterface;
use App\Setup\Amenities\Amenity;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use InterventionImage;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;

class AmenitiesController extends Controller
{
    private $repo;

    public function __construct(AmenitiesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $amenities = $this->repo->getObjs();
            return view('backend.amenities.index')->with('amenities',$amenities);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            return view('backend.amenities.amenities');
        }
        return redirect('/');
    }

    public function store(AmenitiesEntryRequest $request)
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

        $paramObj = new Amenity();
        $paramObj->name = $name;
        $paramObj->description = $description;
        $paramObj->icon = $photo_name;

        $result = $this->repo->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Amenities\AmenitiesController@index')
                ->withMessage(FormatGenerator::message('Success', 'Amenity created ...'));
        }
        else{

            return redirect()->action('Setup\Amenities\AmenitiesController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Amenity did not create ...'));
        }
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $amenities  = $this->repo->getObjByID($id);
            return view('backend.amenities.amenities')->with('amenities', $amenities);
        }
        return redirect('/backend/login');
    }

    public function update(AmenitiesEditRequest $request){
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
            $imgWidth       = 24;
            $imgHeight      = 24;
            $image          = Utility::resizeImageWithDefaultWidthHeight($photo,$photo_name,$path,$imgWidth,$imgHeight);

            $paramObj = Amenity::find($id);
            $paramObj->name = $name;
            $paramObj->description = $description;
            $paramObj->icon = $photo_name;

            $result = $this->repo->update($paramObj);
        }else{
            $paramObj = Amenity::find($id);
            $paramObj->name = $name;
            $paramObj->description = $description;

            //without this condition, when image is removed in update, it won't be removed in DB
            if($removeImageFlag == 1){
                $paramObj->icon     = "";
            }

            $result = $this->repo->update($paramObj);
        }


        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Amenities\AmenitiesController@index')
                ->withMessage(FormatGenerator::message('Success', 'Amenity updated ...'));
        }
        else{
            return redirect()->action('Setup\Amenities\AmenitiesController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Amenity did not update ...'));
        }
    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\Amenities\AmenitiesController@index');//to redirect listing page
    }
}

