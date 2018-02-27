<?php
/**
 * Created by PhpStorm.
 * Author: Aung Ko Khant
 * Date: 2017-10-20
 * Time: 0427 PM
 */

use Illuminate\Database\Seeder;
class Default_BedTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    DB::table('bed_types')->delete();

    $objs = array(
        ['id'=>1, 'name'=>'Single','description'=>'Single bed type', 'icon'=>'/images/upload/Single_Bed.png', 'status' =>1],
        ['id'=>2, 'name'=>'Double','description'=>'Double bed type', 'icon'=>'/images/upload/Double_Bed.png', 'status' =>1],
        ['id'=>3, 'name'=>'Triple','description'=>'Triple bed type', 'icon'=>'/images/upload/Triple.png', 'status' =>1],
        ['id'=>4, 'name'=>'Quad','description'=>'Quad bed type', 'icon'=>'/images/upload/Quad.png', 'status' =>1],
        ['id'=>5, 'name'=>'Queen','description'=>'Queen bed type', 'icon'=>'/images/upload/Queen.png', 'status' =>1],
        ['id'=>6, 'name'=>'King','description'=>'King bed type', 'icon'=>'/images/upload/KING.png', 'status' =>1],
        ['id'=>7, 'name'=>'Twin','description'=>'Twin bed type', 'icon'=>'/images/upload/Twin.png', 'status' =>1]
    );

    DB::table('bed_types')->insert($objs);
}
}
