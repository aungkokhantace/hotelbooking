<?php
namespace App\Setup\Customer;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogCustom;

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
}