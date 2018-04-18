<?php namespace App\Http\Controllers\Core;

use App\Core\Config\Config;
use App\Core\Config\ConfigRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use InterventionImage;
use App\Core\FormatGenerator As FormatGenerator;
use App\Backend\Infrastructure\Forms\ConfigEditRequest;

class ConfigController extends Controller
{
    private $ConfigRepository;
    public $tbConfig = "";

    public function __construct(ConfigRepositoryInterface $ConfigRepository)
    {
        $this->ConfigRepository = $ConfigRepository;
        $this->tbConfig = (new Config())->getTable();
    }

    public function edit(){
        if (Auth::guard('User')->check()) {

            $configs      = $this->ConfigRepository->getSiteConfigs();

            if (is_null($configs) || count($configs) == 0)
            {
                $configs = array();
                $configs['SETTING_COMPANY_NAME'] = "";
                $configs['SETTING_LOGO'] = "";
                $configs['GST'] = "";
                $configs['SERVICE_TAX'] = "";

                return view('core.config.config')->with('configs', $configs);
            }

            $tempConfigs = array();
            foreach($configs as $config){
                $tempCode = $config->code;
                $tempValue = $config->value;
                $tempConfigs[$tempCode] = $tempValue;
            }

            if(!array_key_exists("SETTING_LOGO",$tempConfigs)){
                $tempConfigs["SETTING_LOGO"] = "";
            }

            if(!array_key_exists("SETTING_COMPANY_NAME",$tempConfigs)){
                $tempConfigs["SETTING_COMPANY_NAME"] = "";
            }

            if(!array_key_exists("GST",$tempConfigs)){
                $tempConfigs["GST"] = "";
            }

            if(!array_key_exists("SERVICE_TAX",$tempConfigs)){
                $tempConfigs["SERVICE_TAX"] = "";
            }

            return view('core.config.config')->with('configs', $tempConfigs);

        }
        return redirect('/backend_mps/login');
    }

    public function update(ConfigEditRequest $request){
        $request->validate();
        if (Auth::guard('User')->check()) {

            $SETTING_COMPANY_NAME = Input::get('SETTING_COMPANY_NAME');
            $GST = Input::get('GST');
            $SERVICE_TAX = Input::get('SERVICE_TAX');
            $removeImageFlag = Input::get('removeImageFlag');

            try{
                $loginUserId = 1;
                $sessionObj = session('user');
                if(isset($sessionObj)){
                    $userSession = session('user');
                    $loginUserId = $userSession['id'];
                }
                $updated_at = date('Y-m-d H:m:i');


                DB::statement("DELETE FROM `$this->tbConfig` WHERE `code` = 'SETTING_COMPANY_NAME'");
                $result = DB::statement("INSERT INTO `$this->tbConfig` (code,type,value,description,updated_by,updated_at) VALUES ('SETTING_COMPANY_NAME','SETTING','$SETTING_COMPANY_NAME','Company Name',$loginUserId,'$updated_at')");

                DB::statement("DELETE FROM `$this->tbConfig` WHERE `code` = 'GST'");
                $result = DB::statement("INSERT INTO `$this->tbConfig` (code,type,value,description,updated_by,updated_at) VALUES ('GST','SETTING','$GST','Government Service Tax',$loginUserId,'$updated_at')");

                DB::statement("DELETE FROM `$this->tbConfig` WHERE `code` = 'SERVICE_TAX'");
                $result = DB::statement("INSERT INTO `$this->tbConfig` (code,type,value,description,updated_by,updated_at) VALUES ('SERVICE_TAX','SETTING','$SERVICE_TAX','Service Tax',$loginUserId,'$updated_at')");

                // saving image
                if(Input::hasFile('site_logo'))
                {
                    $file = Input::file('site_logo');
                    $path = base_path().'/public/images';
                    if ( ! file_exists($path))
                    {
                        mkdir($path, 0777, true);
                    }
                    $extension = Input::file('site_logo')->getClientOriginalExtension();
                    $img_name = 'logo'.'.' .$extension;

                    $SETTING_LOGO = '/images/' .$img_name;

                    DB::statement("DELETE FROM `$this->tbConfig` WHERE `code` = 'SETTING_LOGO'");

                    $result = DB::statement("INSERT INTO `$this->tbConfig` (code,type,value,description,updated_by,updated_at) VALUES ('SETTING_LOGO','SETTING','$SETTING_LOGO','Company Logo',$loginUserId,'$updated_at')");

                    // moving image into image folder
                    $file->move($path, $img_name);

                    $rWidth = 1.0;
                    $rHeight =  1.0;

                    // getting image width and height
                    $imgData = getimagesize($path . '/' . $img_name);

                    $width = $imgData[0];
                    $imgWidth = $width * $rWidth;
                    $height = $imgData[1];
                    $imgHeight = $height * $rHeight;

                    // // resizing image
                    // $image = InterventionImage::make(sprintf($path .'/%s', $img_name))->resize($imgWidth, $imgHeight)->save();

                }
                if($removeImageFlag == 1){
                    DB::statement("DELETE FROM `$this->tbConfig` WHERE `code` = 'SETTING_LOGO'");
                    $result = DB::statement("INSERT INTO `$this->tbConfig` (code,type,value,description,updated_by,updated_at) VALUES ('SETTING_LOGO','SETTING','','Company Logo',$loginUserId,'$updated_at')");
                }
                return redirect()->action('Core\ConfigController@edit')
                    ->withMessage(FormatGenerator::message('Success', 'Config is updated ...'));

            }
            catch(Exception $ex){
                return redirect()->action('Core\ConfigController@edit');
//                    return Redirect::to('backend_mps/posconfig/1/edit')
//                        ->withMessage(FormatGenerator::message('Fail', $ex->getMessage()));
            }

        }
        return redirect('/backend_mps/login');
    }

}
