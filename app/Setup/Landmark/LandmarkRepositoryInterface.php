<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/2/2017
 * Time: 8:57 PM
 */

namespace App\Setup\Landmark;


interface LandmarkRepositoryInterface
{
    public function getObjs();
    public function getArrays();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete($paramObj);
    public function getPopularLandmarks();
}