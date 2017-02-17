<?php

namespace App\Http\Controllers\Setup\Amendities;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\AmenditiesEntryRequest;
use App\Backend\Infrastructure\Forms\AmenditiesEditRequest;
use App\Setup\Amendities\AmenditiesRepositoryInterface;
use App\Setup\Amendities\Amendities;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use InterventionImage;
use App\Core\FormatGenerator As FormatGenerator;
use App\Core\ReturnMessage As ReturnMessage;

class AmenditiesController extends Controller
{
    private $amenditiesRepository;

    public function __construct(AmenditiesRepositoryInterface $amenditiesRepository)
    {
        $this->amenditiesRepository = $amenditiesRepository;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $amendities = Amendities::all();
            return view('backend.amendities.index')->with('amendities',$amendities);
        }
        return redirect('/');
    }

    public function create()
    {
        if(Auth::guard('User')->check()){

            return view('backend.amendities.amendities');
        }
        return redirect('/');
    }

    public function store(AmenditiesEntryRequest $request)
    {

        $request->validate();
        $amendities_name    = Input::get('amendities_name');

        $amendities_icon    = Input::file('amendities_icon');

        $file_name     = uniqid().'.'.$amendities_icon->getClientOriginalExtension();
        $path           = base_path().'/public/images/upload/';
        $amendities_icon->move($path, $file_name);

        $image1 = InterventionImage::make(sprintf($path .'/%s', $file_name))->resize(300, 300)->save();

        $paramObj = new Amendities();
        $paramObj->amendities_name = $amendities_name;
        $paramObj->amendities_icon = $file_name;

        $result = $this->amenditiesRepository->create($paramObj);
        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Amendities\AmenditiesController@index')
                ->withMessage(FormatGenerator::message('Success', 'Amendities created ...'));
        }
        else{

            return redirect()->action('Setup\Amendities\AmenditiesController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Amendities did not create ...'));
        }

    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $amendities  = Amendities::find($id);

            return view('backend.amendities.amendities')->with('amendities', $amendities);
        }
        return redirect('/backend/login');
    }

    public function update(AmenditiesEditRequest $request){

        $request->validate();
        $id                         = Input::get('id');
        $amendities_name               = Input::get('amendities_name');

        if(Input::hasFile('amendities_icon')){
            $amendities_icon = Input::file('amendities_icon');
            $file_name       = uniqid().'.'.$amendities_icon->getClientOriginalExtension();
            $path            = base_path().'/public/images/upload/';
            $amendities_icon->move($path, $file_name);

            $image1 = InterventionImage::make(sprintf($path .'/%s', $file_name))->resize(300, 300)->save();

            $paramObj = Amendities::find($id);
            $paramObj->amendities_name = $amendities_name;
            $paramObj->amendities_icon = $amendities_icon;

            $result = $this->amenditiesRepository->update($paramObj);
        }else{
            $paramObj = Feature::find($id);
            $paramObj->amendities_name = $amendities_name;

            $result = $this->amenditiesRepository->update($paramObj);

        }

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){

            return redirect()->action('Setup\Amendities\AmenditiesController@index')
                ->withMessage(FormatGenerator::message('Success', 'Amendities updated ...'));
        }
        else{

            return redirect()->action('Setup\Amendities\AmenditiesController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Amendities did not update ...'));
        }
    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->amenditiesRepository->delete($id);
        }
        return redirect()->action('Setup\Amendities\AmenditiesController@index'); //to redirect listing page
    }



}

