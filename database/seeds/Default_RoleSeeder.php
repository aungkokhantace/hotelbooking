<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 2:17 PM
 */
use Illuminate\Database\Seeder;
class Default_RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_roles')->delete();

        $roles = array(
            ['id'=>1, 'name'=>'SUPER-ADMIN', 'description'=>'This is super admin role'],
            ['id'=>2, 'name'=>'ADMIN', 'description'=>'This is user admin role'],
            ['id'=>3, 'name'=>'HOTEL ADMIN', 'description'=>'This is hotel admin role'],
            ['id'=>4, 'name'=>'CUSTOMER', 'description'=>'This is customer role'],
            ['id'=>9999, 'name'=>'SUPER-ADMIN FIRST LOGIN', 'description'=>'This is super admin first login role'],
        );

        DB::table('core_roles')->insert($roles);
    }
}