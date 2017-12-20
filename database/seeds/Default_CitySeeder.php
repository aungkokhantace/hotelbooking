<?php
use Illuminate\Database\Seeder;

class Default_CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('cities')->delete();
        $objs = array(
            ['country_id'=>'117', 'name'=>'Ayeyarwady Division', 'id' =>'1', 'image' =>'ayeyarwaddy.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Bago Division', 'id' =>'2', 'image' =>'bago.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Chin State', 'id' =>'3', 'image' =>'chin.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Kachin State', 'id' =>'4', 'image' =>'kachin.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Kayah State', 'id' =>'5', 'image' =>'kayah.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Kayin State', 'id' =>'6', 'image' =>'kayin.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Magway Division', 'id' =>'7', 'image' =>'magway.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Mandalay Division', 'id' =>'8', 'image' =>'mandalay.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Mon State', 'id' =>'9', 'image' =>'mon.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Rakhine State', 'id' =>'10', 'image' =>'rakhine.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Sagaing Division', 'id' =>'11', 'image' =>'sagaing.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Shan State', 'id' =>'12', 'image' =>'', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Tanintharyi Division', 'id' =>'13', 'image' =>'tanintharyi.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Yangon Division', 'id' =>'14', 'image' =>'yangon.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Naypyidaw', 'id' =>'15', 'image' =>'naypyitaw.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
        );
        DB::table('cities')->insert($objs);
    }
}
