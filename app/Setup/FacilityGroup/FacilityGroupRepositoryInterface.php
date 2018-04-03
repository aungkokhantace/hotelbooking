<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/28/2017
 * Time: 3:03 PM
 */

namespace App\Setup\FacilityGroup;


interface FacilityGroupRepositoryInterface
{
    public function getObjs();
    public function create($paramObj);
    public function update($paramObj);
    public function getObjByID($id);
    public function delete($id);
    public function getArrays();
    public function checkToDelete($id);
}
