<?php

namespace App\Http\Controllers\Setup\Slider;

use App\Core\Utility;
use App\Backend\Infrastructure\Forms\HotelNearbyEditRequest;
use App\Backend\Infrastructure\Forms\SliderEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Slider\SliderRepositoryInterface;
use App\Setup\Slider\SliderRepository;
use App\Setup\Template\Template;
use App\Setup\Slider\Slider;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use InterventionImage;

class SliderController extends Controller
{
    private $repo;

    public function __construct(SliderRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
         if (Auth::guard('User')->check()) {
             $sliders       = $this->repo->getObjs();
             return view('backend.slider.index')->with('sliders',$sliders);
         }
         return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){
            $templates      = Template::select('id','name')->whereNull('deleted_at')->get();
            return view('backend.slider.slider')->with('templates',$templates);
        }
        return redirect('/');
    }

    public function store(SliderEntryRequest $request)
    {
        $request->validate();
        $template_id            = Input::get('template_id');
        $title                  = Input::get('Title');
        $description            = Input::get('Description');

        //Start Saving Image
        $removeImageFlag        = (Input::has('removeImageFlag')) ? Input::get('removeImageFlag') : 0;
        $path                   = base_path().'/public/assets/shared/images/';
        if(Input::hasFile('photo'))
        {
            $photo                  = Input::file('photo');

            $photo_name_original    = Utility::getImage($photo);
            $photo_ext              = Utility::getImageExt($photo);
            $photo_name             = uniqid() . "." . $photo_ext;
            $photo->move($path, $photo_name);
            $image                  = InterventionImage::make(sprintf($path . '/%s', $photo_name))->save();
        }

        $paramObj                        = new Slider();
        $paramObj->image_url             = $photo_name;
        $paramObj->title                 = $title;
        $paramObj->description           = $description;
        $paramObj->template_id         = $template_id;
        $paramObj->status                = 1;

        $result                 = $this->repo->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\Slider\SliderController@index')
                ->withMessage(FormatGenerator::message('Success', 'Slider created ...'));
        }
        else{
            return redirect()->action('Setup\Slider\SliderController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Slider did not create ...'));
        }
    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->repo->delete($id);
        }
        return redirect()->action('Setup\Slider\SliderController@index'); //to redirect listing page
    }
}
