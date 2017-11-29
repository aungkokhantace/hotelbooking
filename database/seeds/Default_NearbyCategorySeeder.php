<?php
/**
 * Author : Aung Ko Khant
 * Date: 2017-11-29
 * Time: 11:12 AM
 */

use Illuminate\Database\Seeder;
class Default_NearbyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    DB::table('h_nearby_category')->delete();
    /*
    * myanmarpolestar admin pwd - 123@myanmarpolestar
    */
    $objs = array(
        ['id'=>1, 'name'=>'Hotel','description'=>'Hotel','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>2, 'name'=>'Cinema','description'=>'Cinema','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>3, 'name'=>'Zoo','description'=>'Zoo','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>4, 'name'=>'Super-market','description'=>'Super-market','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>5, 'name'=>'Hyper-market','description'=>'Hyper-market','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>6, 'name'=>'Mini-market','description'=>'Mini-market','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>7, 'name'=>'Market','description'=>'Market','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>8, 'name'=>'Convenience Store','description'=>'Convenience Store','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>9, 'name'=>'Hospital','description'=>'Hospital','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>10, 'name'=>'Clinic','description'=>'Clinic','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>11, 'name'=>'Museum','description'=>'Museum','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>12, 'name'=>'Pagoda','description'=>'Pagoda','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>13, 'name'=>'Park','description'=>'Park','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24'],
        ['id'=>14, 'name'=>'Lake','description'=>'Lake','created_at'=>'2017-11-29 11:09:24','updated_at'=>'2017-11-29 11:09:24']

    );

    DB::table('h_nearby_category')->insert($objs);
}
}
