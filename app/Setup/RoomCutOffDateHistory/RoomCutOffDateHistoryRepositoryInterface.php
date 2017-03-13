<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/10/2017
 * Time: 3:15 PM
 */

namespace App\Setup\RoomCutOffDateHistory;


interface RoomCutOffDateHistoryRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);

}