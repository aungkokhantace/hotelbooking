<?php

namespace App\Http\Controllers\Setup\Feature;

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
    private $featureRepository;

    public function __construct(FeatureRepositoryInterface $featureRepository)
    {
        $this->featureRepository = $featureRepository;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $features = Feature::all();
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
        $feature_name    = Input::get('feature_name');

        $feature_icon    = Input::file('feature_icon');

        $file_name     = uniqid().'.'.$feature_icon->getClientOriginalExtension();
        $path           = base_path().'/public/images/upload/';
        $feature_icon->move($path, $file_name);

        $image1 = InterventionImage::make(sprintf($path .'/%s', $file_name))->resize(300, 300)->save();

        $paramObj = new Feature();
        $paramObj->feature_name = $feature_name;
        $paramObj->feature_icon = $file_name;

        $result = $this->featureRepository->create($paramObj);
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
            $feature  = Feature::find($id);

            return view('backend.feature.feature')->with('feature', $feature);
        }
        return redirect('/backend/login');
    }

    public function update(FeatureEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $feature_name               = Input::get('feature_name');

        if(Input::hasFile('feature_icon')){
            $feature_icon = Input::file('feature_icon');
            $file_name     = uniqid().'.'.$feature_icon->getClientOriginalExtension();
            $path           = base_path().'/public/images/upload/';
            $feature_icon->move($path, $file_name);

            $image1 = InterventionImage::make(sprintf($path .'/%s', $file_name))->resize(300, 300)->save();

            $paramObj = Feature::find($id);
            $paramObj->feature_name = $feature_name;
            $paramObj->feature_icon = $feature_icon;

            $result = $this->featureRepository->update($paramObj);
        }else{
            $paramObj = Feature::find($id);
            $paramObj->feature_name = $feature_name;

            $result = $this->featureRepository->update($paramObj);

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
            $this->townshipRepository->delete($id);
        }
        return redirect()->action('Setup\Township\TownshipController@index'); //to redirect listing page
    }



}

