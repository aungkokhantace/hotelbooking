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
            ['id'=>'1', 'hotel_id'=>'1', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'2', 'hotel_id'=>'1', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'3', 'hotel_id'=>'2', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'4', 'hotel_id'=>'2', 'name' =>'Suite Bungalow Room Type', 'description' =>'This is Suite Bungalow Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'5', 'hotel_id'=>'2', 'name' =>'Corner Suite Room Type', 'description' =>'This is Corner Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'6', 'hotel_id'=>'2', 'name' =>'Amazing Suite Room Type', 'description' =>'This is Amazing Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'7', 'hotel_id'=>'3', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'8', 'hotel_id'=>'3', 'name' =>'Jasmine/Orchid Villa Garden View Room Type', 'description' =>'This is Jasmine/Orchid Villa Garden View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'9', 'hotel_id'=>'3', 'name' =>'Jasmine/Orchid Villa Lake View Room Type', 'description' =>'This is Jasmine/Orchid Villa Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'10', 'hotel_id'=>'3', 'name' =>'Lotus Villa Garden View/Temple View Room Type', 'description' =>'This is Lotus Villa Garden View/Temple View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'11', 'hotel_id'=>'3', 'name' =>'Palm Tree Villa Room Type', 'description' =>'This is Palm Tree Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'12', 'hotel_id'=>'3', 'name' =>'Island Villa Room Type', 'description' =>'This is Island Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'13', 'hotel_id'=>'4', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'14', 'hotel_id'=>'4', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'15', 'hotel_id'=>'4', 'name' =>'Heritage Suite Room Type', 'description' =>'This is Heritage Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'16', 'hotel_id'=>'4', 'name' =>'Royal Heritage Suite Room Type', 'description' =>'This is Royal Heritage Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'17', 'hotel_id'=>'5', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'18', 'hotel_id'=>'5', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'19', 'hotel_id'=>'5', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'20', 'hotel_id'=>'6', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'21', 'hotel_id'=>'6', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'22', 'hotel_id'=>'6', 'name' =>'Serene Deluxe Room Type', 'description' =>'This is Serene Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


            ['id'=>'23', 'hotel_id'=>'7', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'24', 'hotel_id'=>'7', 'name' =>'Deluxe Classic Room Type', 'description' =>'This is Deluxe Classic Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'25', 'hotel_id'=>'7', 'name' =>'Deluxe Garden View Room Type', 'description' =>'This is Deluxe Garden View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'26', 'hotel_id'=>'7', 'name' =>'Deluxe River View Room Type', 'description' =>'This is Deluxe River View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'27', 'hotel_id'=>'7', 'name' =>'River View Suite Room Type', 'description' =>'This is River View Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'28', 'hotel_id'=>'8', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'29', 'hotel_id'=>'8', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'30', 'hotel_id'=>'9', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'31', 'hotel_id'=>'9', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            
            ['id'=>'32', 'hotel_id'=>'10', 'name' =>'Bagan Room Type', 'description' =>'This is Bagan Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'33', 'hotel_id'=>'10', 'name' =>'Garden Villa Room Type', 'description' =>'This is Garden Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'34', 'hotel_id'=>'11', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'35', 'hotel_id'=>'11', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'36', 'hotel_id'=>'11', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'37', 'hotel_id'=>'12', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'38', 'hotel_id'=>'12', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'39', 'hotel_id'=>'13', 'name' =>'Deluxe Classic Room Type', 'description' =>'This is Deluxe Classic Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'40', 'hotel_id'=>'13', 'name' =>'Deluxe Garden View Room Type', 'description' =>'This is Deluxe Garden View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'41', 'hotel_id'=>'13', 'name' =>'Deluxe River View Room Type', 'description' =>'This is Deluxe River View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'42', 'hotel_id'=>'13', 'name' =>'River View Suite Room Type', 'description' =>'This is River View Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'43', 'hotel_id'=>'14', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'44', 'hotel_id'=>'14', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'45', 'hotel_id'=>'14', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'46', 'hotel_id'=>'14', 'name' =>'Premier Deluxe Room Type', 'description' =>'This is Premier Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'47', 'hotel_id'=>'15', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'48', 'hotel_id'=>'15', 'name' =>'Standard Balcony Room Type', 'description' =>'This is Standard Balcony Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'49', 'hotel_id'=>'15', 'name' =>'Deluxe Bungalow Room Type', 'description' =>'This is Deluxe Bungalow Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'50', 'hotel_id'=>'16', 'name' =>'Amata Villa Room Type', 'description' =>'This is Amata Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'51', 'hotel_id'=>'16', 'name' =>'Deluxe Suite Room Type', 'description' =>'This is Deluxe Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'52', 'hotel_id'=>'16', 'name' =>'Royal Deluxe Lake Side View Room Type', 'description' =>'This is Royal Deluxe Lake Side View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'53', 'hotel_id'=>'16', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'54', 'hotel_id'=>'17', 'name' =>'Floating Deluxe Room Type', 'description' =>'This is Floating Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'55', 'hotel_id'=>'17', 'name' =>'Floating Deluxe Triple Room Type', 'description' =>'This is Floating Deluxe Triple Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'56', 'hotel_id'=>'17', 'name' =>'On Land Deluxe Room Type', 'description' =>'This is On Land Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'57', 'hotel_id'=>'17', 'name' =>'Upper Superior Room Type', 'description' =>'This is Upper Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'58', 'hotel_id'=>'17', 'name' =>'Lower Superior Room Type', 'description' =>'This is Lower Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'59', 'hotel_id'=>'18', 'name' =>'Second Row Villa Room Type', 'description' =>'This is Second Row Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'60', 'hotel_id'=>'18', 'name' =>'Villa On the Shore Room Type', 'description' =>'This is Villa On the Shore Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'61', 'hotel_id'=>'18', 'name' =>'First Row Villa Room Type', 'description' =>'This is First Row Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'62', 'hotel_id'=>'19', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'63', 'hotel_id'=>'19', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'64', 'hotel_id'=>'20', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'65', 'hotel_id'=>'20', 'name' =>'Lake Front Deluxe Cottage Room Type', 'description' =>'This is Lake Front Deluxe Cottage Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'66', 'hotel_id'=>'20', 'name' =>'Mountain View Chalet Room Type', 'description' =>'This is Mountain View Chalet Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'67', 'hotel_id'=>'20', 'name' =>'Lake Front View Chalet Room Type', 'description' =>'This is Lake Front View Chalet Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'68', 'hotel_id'=>'20', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'69', 'hotel_id'=>'22', 'name' =>'Villa Room Type', 'description' =>'This is Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'70', 'hotel_id'=>'22', 'name' =>'Mountain Houses Room Type', 'description' =>'This is Mountain Houses Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'71', 'hotel_id'=>'22', 'name' =>'Garden Houses Room Type', 'description' =>'This is Garden Houses Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'72', 'hotel_id'=>'22', 'name' =>'Lake Houses Room Type', 'description' =>'This is Lake Houses Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'73', 'hotel_id'=>'22', 'name' =>'Princess Houses Room Type', 'description' =>'This is Princess Houses Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'], 

            ['id'=>'74', 'hotel_id'=>'23', 'name' =>'Garden Cottage Room Type', 'description' =>'This is Garden Cottage Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'75', 'hotel_id'=>'23', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'76', 'hotel_id'=>'23', 'name' =>'Royal Villa Room Type', 'description' =>'This is Royal Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'77', 'hotel_id'=>'23', 'name' =>'Royal Villa Inle Lake View Room Type', 'description' =>'This is Royal Villa Inle Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],     


            ['id'=>'78', 'hotel_id'=>'24', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'79', 'hotel_id'=>'24', 'name' =>'Superior Balcony Room Type', 'description' =>'This is Superior Balcony Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'80', 'hotel_id'=>'24', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'81', 'hotel_id'=>'24', 'name' =>'Deluxe Suite Room Type', 'description' =>'This is Royal Villa Deluxe Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'82', 'hotel_id'=>'24', 'name' =>'Mount Inle Suite Room Type', 'description' =>'This is Mount Inle Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'83', 'hotel_id'=>'25', 'name' =>'Second Row Deluxe Lake View Room Type', 'description' =>'This is Second Row Deluxe Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'84', 'hotel_id'=>'25', 'name' =>'Deluxe Mountain View Room Type', 'description' =>'This is Deluxe Mountain View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'85', 'hotel_id'=>'25', 'name' =>'Deluxe Lake View Room Type', 'description' =>'This is Deluxe Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'86', 'hotel_id'=>'25', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


            ['id'=>'87', 'hotel_id'=>'26', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'88', 'hotel_id'=>'26', 'name' =>'Deluxe Suite with Lake View Room Type', 'description' =>'This is Deluxe Suite with Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'89', 'hotel_id'=>'26', 'name' =>'Superior Villa Room Type', 'description' =>'This is Superior Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'90', 'hotel_id'=>'26', 'name' =>'Deluxe Villa Lake View Room Type', 'description' =>'This is Deluxe Villa Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'91', 'hotel_id'=>'26', 'name' =>'Presidential Villa Room Type', 'description' =>'This is Presidential Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'92', 'hotel_id'=>'27', 'name' =>'Superior Teak Room Type', 'description' =>'This is Superior Teak Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'93', 'hotel_id'=>'27', 'name' =>'Traditional Inthar-Deluxe Cottage Room Type', 'description' =>'This is Traditional Inthar-Deluxe Cottage Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


            ['id'=>'94', 'hotel_id'=>'28', 'name' =>'Floating Duplex Room Type', 'description' =>'This is Floating Duplex Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'95', 'hotel_id'=>'28', 'name' =>'Floating Duplex Family Room Type', 'description' =>'This is Floating Duplex Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'96', 'hotel_id'=>'28', 'name' =>'Inle Lotus Villa Room Type', 'description' =>'This is TInle Lotus Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'97', 'hotel_id'=>'28', 'name' =>'Inle Lotus Villa with Private Spa Room', 'description' =>'This is Inle Lotus Villa with Private Spa Room', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'98', 'hotel_id'=>'28', 'name' =>'Inle Lotus Suite Room Type', 'description' =>'This is Inle Lotus Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'99', 'hotel_id'=>'29', 'name' =>'Cloister Deluxe Room Type', 'description' =>'This is Cloister Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'100', 'hotel_id'=>'29', 'name' =>'Provost Junior Suite Garden View Villa Room Type', 'description' =>'This is Provost Junior Suite Garden View Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'101', 'hotel_id'=>'29', 'name' =>'Abbey Suite Room Type', 'description' =>'This is Abbey Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'], 

            ['id'=>'102', 'hotel_id'=>'30', 'name' =>'Deluxe Room Type', 'description' =>'This isDeluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'103', 'hotel_id'=>'30', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'104', 'hotel_id'=>'31', 'name' =>'Superior City View Room Type', 'description' =>'This is Superior City View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'105', 'hotel_id'=>'31', 'name' =>'Deluxe City View Room Type', 'description' =>'This is Deluxe City View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'106', 'hotel_id'=>'31', 'name' =>'Deluxe  River View Room Type', 'description' =>'This is Deluxe  River View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'107', 'hotel_id'=>'31', 'name' =>'Suite City View Room Type', 'description' =>'This is Suite City View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'108', 'hotel_id'=>'32', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'109', 'hotel_id'=>'32', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'110', 'hotel_id'=>'33', 'name' =>'Deluxe without Balcony Room Type', 'description' =>'This is Deluxe without Balcony Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'111', 'hotel_id'=>'33', 'name' =>'Deluxe with Balcony Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'112', 'hotel_id'=>'33', 'name' =>'Premier with Balcony Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'113', 'hotel_id'=>'33', 'name' =>'Executive Suite Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],        

            ['id'=>'114', 'hotel_id'=>'34', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],  
            ['id'=>'115', 'hotel_id'=>'34', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],  
            ['id'=>'116', 'hotel_id'=>'34', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],  
            ['id'=>'117', 'hotel_id'=>'34', 'name' =>'Special Suite Room Type', 'description' =>'This is Special Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],  
            ['id'=>'118', 'hotel_id'=>'34', 'name' =>'Triple Suite Room Type', 'description' =>'This is Triple Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],  
            ['id'=>'119', 'hotel_id'=>'34', 'name' =>'Family Suite Room Type', 'description' =>'This is Family Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],   

            ['id'=>'120', 'hotel_id'=>'35', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'121', 'hotel_id'=>'35', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'122', 'hotel_id'=>'35', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],      

              ['id'=>'123', 'hotel_id'=>'36', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'124', 'hotel_id'=>'36', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'125', 'hotel_id'=>'36', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'126', 'hotel_id'=>'36', 'name' =>'Family Room Type', 'description' =>'This is Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'127', 'hotel_id'=>'37', 'name' =>'Rakhine Room Type', 'description' =>'This is Rakhine Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'128', 'hotel_id'=>'37', 'name' =>'Kachin Room Type', 'description' =>'This is Kachin Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'129', 'hotel_id'=>'37', 'name' =>'Shan Room Type', 'description' =>'This is Shan Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'130', 'hotel_id'=>'37', 'name' =>'Chin Room Type', 'description' =>'This is Chin Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'131', 'hotel_id'=>'38', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'132', 'hotel_id'=>'38', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'133', 'hotel_id'=>'39', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'134', 'hotel_id'=>'39', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'135', 'hotel_id'=>'40', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'136', 'hotel_id'=>'40', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'137', 'hotel_id'=>'40', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'138', 'hotel_id'=>'41', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'139', 'hotel_id'=>'41', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'140', 'hotel_id'=>'41', 'name' =>'Royal Suite Room Type', 'description' =>'This is Royal Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'141', 'hotel_id'=>'42', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'142', 'hotel_id'=>'42', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'143', 'hotel_id'=>'42', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'144', 'hotel_id'=>'42', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'145', 'hotel_id'=>'42', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'146', 'hotel_id'=>'43', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'147', 'hotel_id'=>'43', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'148', 'hotel_id'=>'43', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'149', 'hotel_id'=>'44', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'150', 'hotel_id'=>'44', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'151', 'hotel_id'=>'44', 'name' =>'Family Room Type', 'description' =>'This is Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'152', 'hotel_id'=>'44', 'name' =>'Kyi Tin Suite Room Type', 'description' =>'This is Kyi Tin Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'153', 'hotel_id'=>'44', 'name' =>'Bungalow Room Type', 'description' =>'This is Bungalow Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'154', 'hotel_id'=>'45', 'name' =>'Superior Room Type', 'description' =>'This is Bungalow Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'155', 'hotel_id'=>'45', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'156', 'hotel_id'=>'45', 'name' =>'Family Room Type', 'description' =>'This is Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'157', 'hotel_id'=>'46', 'name' =>'Eco Single Room Type', 'description' =>'This is Eco Single Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'158', 'hotel_id'=>'46', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'159', 'hotel_id'=>'46', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'160', 'hotel_id'=>'46', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'161', 'hotel_id'=>'47', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'162', 'hotel_id'=>'47', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'163', 'hotel_id'=>'47', 'name' =>'Corner Deluxe Room Type', 'description' =>'This is Corner Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'164', 'hotel_id'=>'47', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'165', 'hotel_id'=>'47', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'166', 'hotel_id'=>'47', 'name' =>'Spa Villa Room Type', 'description' =>'This is Spa Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'167', 'hotel_id'=>'47', 'name' =>'Mandalar Suite Room Type', 'description' =>'This is Mandalar Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'168', 'hotel_id'=>'48', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'169', 'hotel_id'=>'48', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'170', 'hotel_id'=>'49', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'171', 'hotel_id'=>'49', 'name' =>'Corner Suite Room Type', 'description' =>'This is Corner Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'172', 'hotel_id'=>'49', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'173', 'hotel_id'=>'50', 'name' =>'Deluxe Twin Room Type', 'description' =>'This is Deluxe Twin Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'174', 'hotel_id'=>'50', 'name' =>'Deluxe Double Room Type', 'description' =>'This is Deluxe Double Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'175', 'hotel_id'=>'50', 'name' =>'Superior Twin Room Type', 'description' =>'This is Superior Twin Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'176', 'hotel_id'=>'50', 'name' =>'Superior Double Room Type', 'description' =>'This is Superior Double Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'177', 'hotel_id'=>'51', 'name' =>'Deluxe Room Type', 'description' =>'This is SDeluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'178', 'hotel_id'=>'51', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'179', 'hotel_id'=>'51', 'name' =>'Royal Room Type', 'description' =>'This is Royal Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'180', 'hotel_id'=>'51', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'181', 'hotel_id'=>'52', 'name' =>'Family Suite Zakawah Room Type', 'description' =>'This is Family Suite Zakawah Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'182', 'hotel_id'=>'52', 'name' =>'Family Suite Zizawah Room Type', 'description' =>'This is Family Suite Zizawah Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'183', 'hotel_id'=>'52', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'184', 'hotel_id'=>'52', 'name' =>'Pool View Premier Suite Room Type', 'description' =>'This is Pool View Premier Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'185', 'hotel_id'=>'52', 'name' =>'Premier Suite Room Type', 'description' =>'This is Premier Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'186', 'hotel_id'=>'52', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'187', 'hotel_id'=>'53', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'188', 'hotel_id'=>'53', 'name' =>'Premier Deluxe Room Type', 'description' =>'This is Premier Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'189', 'hotel_id'=>'53', 'name' =>'Club Deluxe Room Type', 'description' =>'This is Club Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'190', 'hotel_id'=>'53', 'name' =>'Club Premier Room Type', 'description' =>'This is Club Premier Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'191', 'hotel_id'=>'53', 'name' =>'Club Suite Room Type', 'description' =>'This is Club Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'192', 'hotel_id'=>'53', 'name' =>'Apartment Suite Room Type', 'description' =>'This isApartment Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'193', 'hotel_id'=>'53', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'194', 'hotel_id'=>'53', 'name' =>'Ambassador Suite Room Type', 'description' =>'This is Ambassador Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'195', 'hotel_id'=>'54', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'196', 'hotel_id'=>'54', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'197', 'hotel_id'=>'54', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'198', 'hotel_id'=>'55', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'199', 'hotel_id'=>'55', 'name' =>'Corner Suite Room Type', 'description' =>'This is Corner Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'200', 'hotel_id'=>'55', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'201', 'hotel_id'=>'55', 'name' =>'Premier Suite Room Type', 'description' =>'This is Premier Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'202', 'hotel_id'=>'55', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'203', 'hotel_id'=>'55', 'name' =>'Villa Room Type', 'description' =>'This is Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'204', 'hotel_id'=>'55', 'name' =>'Royal Villa Suite Room Type', 'description' =>'This is Royal Villa Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'205', 'hotel_id'=>'55', 'name' =>'Royal King Villa Suite Room Type', 'description' =>'This is Royal King Villa Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'206', 'hotel_id'=>'56', 'name' =>'Superior Room Type', 'description' =>'This is Royal Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'207', 'hotel_id'=>'56', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'208', 'hotel_id'=>'56', 'name' =>'Shwe Ye Mon Special Room Type', 'description' =>'This is Shwe Ye Mon Special Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'209', 'hotel_id'=>'57', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'210', 'hotel_id'=>'57', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'211', 'hotel_id'=>'57', 'name' =>'Family Room Type', 'description' =>'This is Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'212', 'hotel_id'=>'58', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'213', 'hotel_id'=>'58', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'214', 'hotel_id'=>'58', 'name' =>'Executive Room Type', 'description' =>'This is Executive Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'215', 'hotel_id'=>'59', 'name' =>'Villa Junior Suite Room Type', 'description' =>'This is Villa Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'216', 'hotel_id'=>'59', 'name' =>'Villa Deluxe Room Type', 'description' =>'This is Villa Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'217', 'hotel_id'=>'59', 'name' =>'Economy Room Type', 'description' =>'This is Economy Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'218', 'hotel_id'=>'60', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'219', 'hotel_id'=>'60', 'name' =>'Family Room Type', 'description' =>'This is Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'220', 'hotel_id'=>'60', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'221', 'hotel_id'=>'61', 'name' =>'Superior ', 'description' =>'This is Superior ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'222', 'hotel_id'=>'61', 'name' =>'Deluxe', 'description' =>'This is Deluxe', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'223', 'hotel_id'=>'61', 'name' =>'Villa', 'description' =>'This is Villa', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'224', 'hotel_id'=>'62', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'225', 'hotel_id'=>'62', 'name' =>'Executive Room Type', 'description' =>'This is Executive Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'226', 'hotel_id'=>'62', 'name' =>'Royal Suite Room Type', 'description' =>'This is Royal Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'227', 'hotel_id'=>'63', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'228', 'hotel_id'=>'63', 'name' =>'Executive Deluxe Room Type', 'description' =>'This is Executive Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'229', 'hotel_id'=>'63', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'230', 'hotel_id'=>'63', 'name' =>'Premier Deluxe Room Type', 'description' =>'This is Premier Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'231', 'hotel_id'=>'64', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'232', 'hotel_id'=>'64', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'233', 'hotel_id'=>'64', 'name' =>'Royal Deluxe Room Type', 'description' =>'This is Royal Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'234', 'hotel_id'=>'65', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'235', 'hotel_id'=>'65', 'name' =>'Chatrium Club Room Type', 'description' =>'This is Chatrium Club Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'236', 'hotel_id'=>'65', 'name' =>'Corner Deluxe Room Type', 'description' =>'This is Corner Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'237', 'hotel_id'=>'65', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'238', 'hotel_id'=>'65', 'name' =>'Studio Suite Room Type', 'description' =>'This is Studio Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'239', 'hotel_id'=>'65', 'name' =>'Deluxe Suite Room Type', 'description' =>'This is Deluxe Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'240', 'hotel_id'=>'65', 'name' =>'Luxury Suite Room Type', 'description' =>'This is Luxury Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'241', 'hotel_id'=>'65', 'name' =>'Royal Lake Suite Room Type', 'description' =>'This isRoyal Lake Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'242', 'hotel_id'=>'66', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'243', 'hotel_id'=>'66', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'244', 'hotel_id'=>'66', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'245', 'hotel_id'=>'66', 'name' =>'Executive Room Type', 'description' =>'This is Executive Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'246', 'hotel_id'=>'67', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'247', 'hotel_id'=>'67', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-67 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'248', 'hotel_id'=>'67', 'name' =>'Executive Lounge Deluxe Room Type', 'description' =>'This is Executive Lounge Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'249', 'hotel_id'=>'67', 'name' =>'Executive Lounge Suite Room Type', 'description' =>'This is Executive Lounge Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'250', 'hotel_id'=>'67', 'name' =>'Royal Suite Room Type', 'description' =>'This is Royal Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'251', 'hotel_id'=>'68', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'252', 'hotel_id'=>'68', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'253', 'hotel_id'=>'68', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'254', 'hotel_id'=>'68', 'name' =>'Apartment Room Type', 'description' =>'This is Apartment Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'255', 'hotel_id'=>'69', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'256', 'hotel_id'=>'69', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'257', 'hotel_id'=>'69', 'name' =>'Lake Front Deluxe Room Type', 'description' =>'This is Lake Front Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'258', 'hotel_id'=>'69', 'name' =>'Diplomat Suite Room Type', 'description' =>'This is Diplomat Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'259', 'hotel_id'=>'69', 'name' =>'Corporate Suite Room Type', 'description' =>'This is Corporate Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'260', 'hotel_id'=>'69', 'name' =>'Governor Suite Room Type', 'description' =>'This is Governor Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'261', 'hotel_id'=>'69', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'262', 'hotel_id'=>'69', 'name' =>'Imperial Suite Room Type', 'description' =>'This is Imperial Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'263', 'hotel_id'=>'69', 'name' =>'Royal Bungalow Room Type', 'description' =>'This is Royal Bungalow Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'264', 'hotel_id'=>'70', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'265', 'hotel_id'=>'70', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'266', 'hotel_id'=>'70', 'name' =>'Premier Lake View Type', 'description' =>'This is Premier Lake View Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'267', 'hotel_id'=>'70', 'name' =>'Club Deluxe Room Type', 'description' =>'This is Club Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'268', 'hotel_id'=>'70', 'name' =>'Club Premier Room Type', 'description' =>'This is Club Premier Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'269', 'hotel_id'=>'71', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'270', 'hotel_id'=>'71', 'name' =>'Premier Lake View Room Type', 'description' =>'This is Premier Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'271', 'hotel_id'=>'71', 'name' =>'The Level Room Type', 'description' =>'This is The Level Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'272', 'hotel_id'=>'71', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'273', 'hotel_id'=>'71', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'274', 'hotel_id'=>'71', 'name' =>'Grand Suite Room Type', 'description' =>'This is Grand Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'275', 'hotel_id'=>'71', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'276', 'hotel_id'=>'72', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'277', 'hotel_id'=>'72', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'278', 'hotel_id'=>'72', 'name' =>'Deluxe Suite Room Type', 'description' =>'This is Deluxe Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'279', 'hotel_id'=>'72', 'name' =>'Executive Room Type', 'description' =>'This is Executive Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'280', 'hotel_id'=>'72', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'281', 'hotel_id'=>'73', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'282', 'hotel_id'=>'73', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'283', 'hotel_id'=>'74', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'284', 'hotel_id'=>'74', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'285', 'hotel_id'=>'74', 'name' =>'Premier Room Type', 'description' =>'This is Premier Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'286', 'hotel_id'=>'74', 'name' =>'Orchid Club Room Type', 'description' =>'This is Orchid Club Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'287', 'hotel_id'=>'74', 'name' =>'Studio Suite Room Type', 'description' =>'This is Studio Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'288', 'hotel_id'=>'74', 'name' =>'Service Suite Room Type', 'description' =>'This is Service Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'289', 'hotel_id'=>'74', 'name' =>'Ambassador Suite Room Type', 'description' =>'This is Ambassador Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'290', 'hotel_id'=>'74', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'291', 'hotel_id'=>'75', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'292', 'hotel_id'=>'75', 'name' =>'Executive Deluxe Room Type', 'description' =>'This is Executive Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'293', 'hotel_id'=>'75', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'294', 'hotel_id'=>'76', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'295', 'hotel_id'=>'76', 'name' =>'Balcony Deluxe Room Type', 'description' =>'This is Balcony Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'296', 'hotel_id'=>'76', 'name' =>'Bamboo Executive Room Type', 'description' =>'This is Bamboo Executive Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'297', 'hotel_id'=>'76', 'name' =>'Padauk Suite Room Type', 'description' =>'This is Padauk Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'298', 'hotel_id'=>'77', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'299', 'hotel_id'=>'77', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'300', 'hotel_id'=>'77', 'name' =>'Premier Room Type', 'description' =>'This is Premier Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'301', 'hotel_id'=>'77', 'name' =>'Studio Suite Room Type', 'description' =>'This is Studio Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'302', 'hotel_id'=>'77', 'name' =>'Balcony Suite Room Type', 'description' =>'This is Balcony Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'303', 'hotel_id'=>'77', 'name' =>'Sedona Club Room Type', 'description' =>'This is Sedona Club Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'304', 'hotel_id'=>'77', 'name' =>'Sedona Club Suite Room Type', 'description' =>'This is Sedona Club Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'305', 'hotel_id'=>'77', 'name' =>'Princess Suite Room Type', 'description' =>'This is Princess Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'306', 'hotel_id'=>'77', 'name' =>'Ambassador Suite Room Type', 'description' =>'This is Ambassador Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'307', 'hotel_id'=>'77', 'name' =>'Royal Sedona Suite Room Type', 'description' =>'This is Royal Sedona Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'308', 'hotel_id'=>'77', 'name' =>'Executive Apartment Room Type', 'description' =>'This is Executive Apartment Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'309', 'hotel_id'=>'77', 'name' =>'Premier Deluxe Room Type', 'description' =>'This is Premier Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'310', 'hotel_id'=>'77', 'name' =>'Premier Club Deluxe Room Type', 'description' =>'This is Premier Club Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'311', 'hotel_id'=>'77', 'name' =>'Prestige Suite Room Type', 'description' =>'This is Prestige Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'312', 'hotel_id'=>'77', 'name' =>'Irrawaddy Suite Room Type', 'description' =>'This is Irrawaddy Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'313', 'hotel_id'=>'77', 'name' =>'Shinsawbu Suite Room Type', 'description' =>'This is Shinsawbu Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'314', 'hotel_id'=>'77', 'name' =>'Anawyahta Suite Room Type', 'description' =>'This is Anawyahta Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'315', 'hotel_id'=>'78', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'316', 'hotel_id'=>'78', 'name' =>'Superior Suite Room Type', 'description' =>'This is Superior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'317', 'hotel_id'=>'78', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'318', 'hotel_id'=>'78', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'319', 'hotel_id'=>'79', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'320', 'hotel_id'=>'79', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'321', 'hotel_id'=>'79', 'name' =>'Horizon Club Room Type', 'description' =>'This is Horizon Club Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'322', 'hotel_id'=>'79', 'name' =>'Deluxe Suite Room Type', 'description' =>'This is Deluxe Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'323', 'hotel_id'=>'79', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'324', 'hotel_id'=>'79', 'name' =>'Club Suite Room Type', 'description' =>'This is Club Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'325', 'hotel_id'=>'79', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'326', 'hotel_id'=>'80', 'name' =>'Supeior Room Type', 'description' =>'This is Supeior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'327', 'hotel_id'=>'80', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'328', 'hotel_id'=>'80', 'name' =>'Premier Room Type', 'description' =>'This is Premier Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'329', 'hotel_id'=>'80', 'name' =>'Studio Suite Room Type', 'description' =>'This is Studio Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'330', 'hotel_id'=>'80', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'331', 'hotel_id'=>'80', 'name' =>'Family Suite Room Type', 'description' =>'This is Family Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'332', 'hotel_id'=>'80', 'name' =>'Premier Suite Room Type', 'description' =>'This is Premier Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'333', 'hotel_id'=>'80', 'name' =>'Premier Family Suite Room Type', 'description' =>'This is Premier Family Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'334', 'hotel_id'=>'80', 'name' =>'Pagoda Suite Room Type', 'description' =>'This is Pagoda Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

               ['id'=>'335', 'hotel_id'=>'81', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

        );
        DB::table('h_room_type')->insert($objs);
    }
}