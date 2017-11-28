<?php
/**
 * Created by PhpStorm.
 * Author: Aung Ko Khant
 * Date: 2017-10-20
 * Time: 0427 PM
 */

use Illuminate\Database\Seeder;
class Default_RestaurantCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    DB::table('h_restaurant_categories')->delete();

    $objs = array(
        ['id'=>1, 'name'=>'Myanmar','description'=>'Myanmar'],
        ['id'=>2, 'name'=>'Chinese','description'=>'Chinese'],
        ['id'=>3, 'name'=>'Japanese','description'=>'Japanese'],
        ['id'=>4, 'name'=>'Thai','description'=>'Thai'],
        ['id'=>5, 'name'=>'Europe','description'=>'Europe'],
        ['id'=>6, 'name'=>'Italian','description'=>'Italian'],
        ['id'=>7, 'name'=>'Korean','description'=>'Korean']
    );

    DB::table('h_restaurant_categories')->insert($objs);
}
}
