<?php
use Illuminate\Database\Seeder;

class Default_RoomCategoryAmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('r_category_amenities')->delete();
        $objs = array(
          
            ['amenity_id'=>'1', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'2', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'3', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'5', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'6', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'7', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'8', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'9', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'10', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'11', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'12', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'13', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'14', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'15', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'16', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'17', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['amenity_id'=>'28', 'room_category_id'=>'1', 'value' =>'0', 'description' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
                    	
          	
             

        );
        DB::table('r_category_amenities')->insert($objs);
    }
}