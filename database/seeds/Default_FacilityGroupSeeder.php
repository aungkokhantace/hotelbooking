<?php
use Illuminate\Database\Seeder;

class Default_FacilityGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('facility_group')->delete();
        $objs = array(
            ['id'=>'1', 'name'=>'Play', 'icon' =>'default_icon.jpg', 'remark' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'2', 'name'=>'Food & Drink', 'icon' =>'default_icon.jpg', 'remark' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'3', 'name'=>'Event', 'icon' =>'default_icon.jpg', 'remark' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'4', 'name'=>'General', 'icon' =>'default_icon.jpg', 'remark' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'5', 'name'=>'General', 'icon' =>'default_icon.jpg', 'remark' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
        );
        DB::table('facility_group')->insert($objs);
    }
}