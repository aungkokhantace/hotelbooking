<?php
use Illuminate\Database\Seeder;

class Default_AmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('amenities')->delete();
        $objs = array(
            ['id'=>'1', 'name'=>'Safety Box', 'icon' =>'default_icon.jpg', 'description' =>'This is Safety Box', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'2', 'name'=>'Mini Bar', 'icon' =>'default_icon.jpg', 'description' =>'This is Mini Bar', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'3', 'name'=>'Coffee/Tea Making', 'icon' =>'default_icon.jpg', 'description' =>'This is Coffee/Tea Making', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'4', 'name'=>'Coffee/Tea Making', 'icon' =>'default_icon.jpg', 'description' =>'This is Coffee/Tea Making', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'5', 'name'=>'LCD TV', 'icon' =>'default_icon.jpg', 'description' =>'This is LCD TV', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'6', 'name'=>'Slipper', 'icon' =>'default_icon.jpg', 'description' =>'This is Slipper', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'7', 'name'=>'FOC Water', 'icon' =>'default_icon.jpg', 'description' =>'This is FOC Water', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'8', 'name'=>'Dush Bin', 'icon' =>'default_icon.jpg', 'description' =>'This is Dush Bin', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'9', 'name'=>'Shower Cap', 'icon' =>'default_icon.jpg', 'description' =>'This is Shower Cap', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'10', 'name'=>'Soap', 'icon' =>'default_icon.jpg', 'description' =>'This is Soap', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'11', 'name'=>'Conditioner', 'icon' =>'default_icon.jpg', 'description' =>'This is Conditioner', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'12', 'name'=>'Towel', 'icon' =>'default_icon.jpg', 'description' =>'This is Towel', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'13', 'name'=>'Bath Robe', 'icon' =>'default_icon.jpg', 'description' =>'This is Bath Robe', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'14', 'name'=>'Tooth Brush', 'icon' =>'default_icon.jpg', 'description' =>'This is Tooth Brush', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'15', 'name'=>'Toilet Roll', 'icon' =>'default_icon.jpg', 'description' =>'This is Toilet Roll', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'16', 'name'=>'Tissue Box', 'icon' =>'default_icon.jpg', 'description' =>'This is Tissue Box', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'17', 'name'=>'Hair Dryer', 'icon' =>'default_icon.jpg', 'description' =>'This is Hair Dryer', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'18', 'name'=>'Shaving Kid', 'icon' =>'default_icon.jpg', 'description' =>'This is Shaving Kid', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'19', 'name'=>'Kettle Pot', 'icon' =>'default_icon.jpg', 'description' =>'This is Kettle Pot', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'20', 'name'=>'Bathtap', 'icon' =>'default_icon.jpg', 'description' =>'This is Bathtap', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'21', 'name'=>'Fruit Basket', 'icon' =>'default_icon.jpg', 'description' =>'This is Fruit Basket', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'22', 'name'=>'Adapters', 'icon' =>'default_icon.jpg', 'description' =>'This is Adapters', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'23', 'name'=>'Nightdress', 'icon' =>'default_icon.jpg', 'description' =>'This is Nightdress', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'24', 'name'=>'Hot Water', 'icon' =>'default_icon.jpg', 'description' =>'This is Hot Water', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'25', 'name'=>'Hot Water', 'icon' =>'default_icon.jpg', 'description' =>'This is Hot Water', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'51', 'name'=>'Hand Shower', 'icon' =>'default_icon.jpg', 'description' =>'This is Hand Shower', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'26', 'name'=>'Baby Bed', 'icon' =>'default_icon.jpg', 'description' =>'This is Baby Bed', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'27', 'name'=>'Baby Bed', 'icon' =>'default_icon.jpg', 'description' =>'This is Baby Bed', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'28', 'name'=>'Shower Booth', 'icon' =>'default_icon.jpg', 'description' =>'This is Shower Booth', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'29', 'name'=>'Shower Booth', 'icon' =>'default_icon.jpg', 'description' =>'This is Shower Booth', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'30', 'name'=>'Balcony', 'icon' =>'default_icon.jpg', 'description' =>'This is Balcony', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'31', 'name'=>'Refrigerator', 'icon' =>'default_icon.jpg', 'description' =>'This is Refrigerator', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'32', 'name'=>'Jacuzzi', 'icon' =>'default_icon.jpg', 'description' =>'This is Jacuzzi', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'33', 'name'=>'Shaver', 'icon' =>'default_icon.jpg', 'description' =>'This is Shaver', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'34', 'name'=>'Individually controlled air-conditioning', 'icon' =>'default_icon.jpg', 'description' =>'This is Individually controlled air-conditioning', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'35', 'name'=>'Fully Stocked Mini bar', 'icon' =>'default_icon.jpg', 'description' =>'This is Fully Stocked Mini bar', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'36', 'name'=>'Tea & Coffee Facilities', 'icon' =>'default_icon.jpg', 'description' =>'This is Tea & Coffee Facilities', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'37', 'name'=>'Complimentary Bottled Water', 'icon' =>'default_icon.jpg', 'description' =>'This is Complimentary Bottled Water', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'38', 'name'=>'13 cable television channels', 'icon' =>'default_icon.jpg', 'description' =>'This is 13 cable television channels', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'39', 'name'=>'Wireless Internet Access', 'icon' =>'default_icon.jpg', 'description' =>'This is Wireless Internet Access', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'40', 'name'=>'Personal Security Safe', 'icon' =>'default_icon.jpg', 'description' =>'This is Personal Security Safe', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'41', 'name'=>'Hot and Cold Water System', 'icon' =>'default_icon.jpg', 'description' =>'This is Hot and Cold Water System', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'42', 'name'=>'Range of bathroom toiletries', 'icon' =>'default_icon.jpg', 'description' =>'This is Range of bathroom toiletries', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'43', 'name'=>'Alarm clock with audio speaker', 'icon' =>'default_icon.jpg', 'description' =>'This is Alarm clock with audio speaker', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'44', 'name'=>'Comprehensive Satellite TV channels', 'icon' =>'default_icon.jpg', 'description' =>'This is Comprehensive Satellite TV channels', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'45', 'name'=>'Bluetooth connectivity', 'icon' =>'default_icon.jpg', 'description' =>'This is Bluetooth connectivity', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'46', 'name'=>'USB charging port', 'icon' =>'default_icon.jpg', 'description' =>'This is USB charging port', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'47', 'name'=>'Iron and Iron board', 'icon' =>'default_icon.jpg', 'description' =>'This is Iron and Iron board', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'48', 'name'=>'Shaving Mirror', 'icon' =>'default_icon.jpg', 'description' =>'This is Shaving Mirror', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'49', 'name'=>'Shaving Mirror', 'icon' =>'default_icon.jpg', 'description' =>'This is Shaving Mirror', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'50', 'name'=>'Flat-screen TV', 'icon' =>'default_icon.jpg', 'description' =>'This is Flat-screen TV', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
        );
        DB::table('amenities')->insert($objs);
    }
}