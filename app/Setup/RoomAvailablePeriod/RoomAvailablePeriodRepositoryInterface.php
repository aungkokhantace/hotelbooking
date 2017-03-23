<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/22/2017
 * Time: 5:15 PM
 */

namespace App\Setup\RoomAvailablePeriod;


interface RoomAvailablePeriodRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($paramObj);
}