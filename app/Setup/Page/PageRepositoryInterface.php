<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/19/2017
 * Time: 10:27 PM
 */

namespace App\Setup\Page;


interface PageRepositoryInterface
{
    public function getObjs();
    public function getObjByID($id);
    public function update($paramObj);
}