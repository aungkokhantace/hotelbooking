<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/21/2016
 * Time: 3:51 PM
 */
namespace App\Setup\Amendities;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Setup\Amendities\Amendities;
use App\Core\Utility;
use App\Core\ReturnMessage;
class AmenditiesRepository implements AmenditiesRepositoryInterface
{
    public function create($paramObj){
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;

            return $returnedObj;
        }
        catch(Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();

            return $returnedObj;
        }
    }

    public function update($paramObj){
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;

            return $returnedObj;
        }
        catch(Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage();

            return $returnedObj;
        }
    }

    public function delete($id)
    {
        $tempObj                = Amendities::find($id);
        $tempObj                = Utility::addDeletedBy($tempObj);
        $tempObj->deleted_at    = date('Y-m-d H:m:i');
        $tempObj->save();
    }
}