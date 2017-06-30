<?php

namespace App\Http\Controllers\Setup\Page;

use App\Backend\Infrastructure\Forms\PageEditRequest;
use App\Backend\Infrastructure\Forms\PageEntryRequest;
use App\Core\FormatGenerator;
use App\Core\ReturnMessage;
use App\Setup\Page\PageRepositoryInterface;
use App\Setup\Page\PageRepository;
use App\Setup\Page\Page;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;

class PageController extends Controller
{
    private $repo;

    public function __construct(PageRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
         if (Auth::guard('User')->check()) {
             $pages          = $this->repo->getObjs();
             return view('backend.page.index')->with('pages',$pages);
         }
         return redirect('/');
    }

    public function edit($id)
    {
        if (Auth::guard('User')->check()) {
            $page       = $this->repo->getObjByID($id);

            return view('backend.page.page')
                ->with('page',$page);
        }
        return redirect('/backend/login');
    }

    public function update(PageEditRequest $request)
    {
        $request->validate();
        $id                     = Input::get('id');
        $page_name              = Input::get('page_name');
        $content                = Input::get('content');

        $paramObj               = $this->repo->getObjByID($id);
        $paramObj->name         = $page_name;
        $paramObj->content      = $content;

        $result = $this->repo->update($paramObj);

        if($result['aceplusStatusCode'] ==  ReturnMessage::OK){
            return redirect()->action('Setup\Page\PageController@index')
                ->withMessage(FormatGenerator::message('Success', 'Page updated ...'));
        }
        else{
            return redirect()->action('Setup\Page\PageController@index')
                ->withMessage(FormatGenerator::message('Fail', 'Page did not update ...'));
        }

    }

    public function upload(Request $request) {
        
    }
}
