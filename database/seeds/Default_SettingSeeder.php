<?php

use Illuminate\Database\Seeder;

class Default_SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_settings')->delete();

        $roles = array(
            ['code'=>'CANCEL REASON 1', 'type'=>'REASON', 'value'=>'1','description'=>'I found a better place to stay on Myanmar Pole Star'],
            ['code'=>'CANCEL REASON 2', 'type'=>'REASON', 'value'=>'2','description'=>'I fount a better place to stay on another website'],
            ['code'=>'CANCEL REASON 3', 'type'=>'REASON', 'value'=>'3','description'=>'I need to change the details of my reservation.'],
            ['code'=>'CANCEL REASON 4', 'type'=>'REASON', 'value'=>'4','description'=>'I am no longer visiting this destination.'],
            ['code'=>'CANCEL REASON 5', 'type'=>'REASON', 'value'=>'5','description'=>'For Personal Reason.'],

        );

        DB::table('core_settings')->insert($roles);
    }
}
