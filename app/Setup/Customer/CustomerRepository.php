<?php
namespace App\Setup\Customer;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;
use App\User;

/**
 * Created by PhpStorm.
 * Author: Khin Zar Ni Wint
 * Date: 4/26/2017
 * Time: 3:23 PM
 */
class CustomerRepository implements CustomerRepositoryInterface
{
    public function create($userObj)
    {
        $tempObj = Utility::addCreatedBy($userObj);
        $tempObj->save();
    }

    public function getObjByID($id){
        $user = User::find($id);
        return $user;
    }

    public function update($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentCustomerID(); //get currently logged in user

        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            //update info log
            $date       = $tempObj->updated_at;
            $message    = '['. $date .'] '. 'info: ' . 'User ID - '.$currentUser.' updated his/her information '. PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            //update error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User ID - '.$currentUser.' updated his/her information and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }
}