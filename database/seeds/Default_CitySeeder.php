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
        // DB::table('cities')->delete();
        DB::table('cities')->truncate();
        $objs = array(
            ['country_id'=>'117', 'name'=>'Ayeyarwady', 'name_jp'=>'エヤワディ', 'id' =>'1', 'image' =>'ayeyarwaddy.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Bago', 'name_jp'=>'バゴー', 'id' =>'2', 'image' =>'bago.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Chin', 'name_jp'=>'チン', 'id' =>'3', 'image' =>'chin.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Kachin', 'name_jp'=>'カチン', 'id' =>'4', 'image' =>'kachin.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Kayah', 'name_jp'=>'カヤー', 'id' =>'5', 'image' =>'kayah.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Kayin', 'name_jp'=>'カイン', 'id' =>'6', 'image' =>'kayin.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Magway', 'name_jp'=>'マグエー', 'id' =>'7', 'image' =>'magway.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Mandalay', 'name_jp'=>'マンダレー', 'id' =>'8', 'image' =>'mandalay.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Mon', 'name_jp'=>'モン', 'id' =>'9', 'image' =>'mon.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Rakhine', 'name_jp'=>'ラカイン', 'id' =>'10', 'image' =>'rakhine.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Sagaing', 'name_jp'=>'サガイン', 'id' =>'11', 'image' =>'sagaing.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Shan', 'name_jp'=>'シャン', 'id' =>'12', 'image' =>'shan.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Tanintharyi', 'name_jp'=>'タニンターリ', 'id' =>'13', 'image' =>'tanintharyi.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Yangon', 'name_jp'=>'ヤンゴン', 'id' =>'14', 'image' =>'yangon.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['country_id'=>'117', 'name'=>'Naypyidaw', 'name_jp'=>'ネピドー', 'id' =>'15', 'image' =>'naypyitaw.jpg', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
        );
        DB::table('cities')->insert($objs);
    }
}
