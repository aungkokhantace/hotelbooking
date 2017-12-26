<?php
/**
 * Author: Aung Ko Khant
 * Date: 2017-12-26
 * Time: 02:40 PM
 */

namespace App\Setup\BedType;


interface BedTypeRepositoryInterface
{
    public function getObjs();
    public function create($paramObj);
    public function update($paramObj);
    public function getObjByID($id);
    public function delete($id);
    public function getArrays();
}
