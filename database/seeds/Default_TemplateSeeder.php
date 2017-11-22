<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 7/4/2016
 * Time: 3:03 PM
 */

use Illuminate\Database\Seeder;
class Default_TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    DB::table('template')->delete();
    /*
    * myanmarpolestar admin pwd - 123@myanmarpolestar
    */
    $roles = array(
        ['id'=>1, 'name'=>'Home Page','description'=>'Home Page']
    );

    DB::table('template')->insert($roles);
}
}
