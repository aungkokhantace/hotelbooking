<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 2/15/2017
 * Time: 11:28 AM
 */

namespace App\Setup\Feature;


interface FeatureRepositoryInterface
{
    public function create($paramObj);
    public function update($paramObj);
    public function delete($id);
}