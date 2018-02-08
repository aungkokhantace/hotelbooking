<?php
use Illuminate\Database\Seeder;

class Default_HotelRoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('h_room_type')->delete();
        $objs = array(
            ['id'=>'1', 'name' =>'Building', 'description' =>'Building', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'2', 'name' =>'Bungalow', 'description' =>'Bungalow', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'3', 'name' =>'Villa', 'description' =>'Villa', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'4', 'name' =>'Cottage', 'description' =>'Cottage', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'5', 'name' =>'Garden Wing', 'description' =>'Garden Wing', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'6', 'name' =>'Inya Wing', 'description' =>'Inya Wing', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'], 
        );
        DB::table('h_room_type')->insert($objs);
    }
}
