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
            ['id'=>'1', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'2', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'3', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'4', 'name' =>'Suite Bungalow Room Type', 'description' =>'This is Suite Bungalow Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'5', 'name' =>'Corner Suite Room Type', 'description' =>'This is Corner Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'6', 'name' =>'Amazing Suite Room Type', 'description' =>'This is Amazing Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'7', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'8', 'name' =>'Jasmine/Orchid Villa Garden View Room Type', 'description' =>'This is Jasmine/Orchid Villa Garden View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'9', 'name' =>'Jasmine/Orchid Villa Lake View Room Type', 'description' =>'This is Jasmine/Orchid Villa Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'10', 'name' =>'Lotus Villa Garden View/Temple View Room Type', 'description' =>'This is Lotus Villa Garden View/Temple View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'11', 'name' =>'Palm Tree Villa Room Type', 'description' =>'This is Palm Tree Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'12', 'name' =>'Island Villa Room Type', 'description' =>'This is Island Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'13', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'14', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'15', 'name' =>'Heritage Suite Room Type', 'description' =>'This is Heritage Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'16', 'name' =>'Royal Heritage Suite Room Type', 'description' =>'This is Royal Heritage Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'17', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'18', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'19', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'20', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'21', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'22', 'name' =>'Serene Deluxe Room Type', 'description' =>'This is Serene Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


            ['id'=>'23', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'24', 'name' =>'Deluxe Classic Room Type', 'description' =>'This is Deluxe Classic Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'25', 'name' =>'Deluxe Garden View Room Type', 'description' =>'This is Deluxe Garden View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'26', 'name' =>'Deluxe River View Room Type', 'description' =>'This is Deluxe River View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'27', 'name' =>'River View Suite Room Type', 'description' =>'This is River View Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'28', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'29', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'30', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'31', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'32', 'name' =>'Bagan Room Type', 'description' =>'This is Bagan Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'33', 'name' =>'Garden Villa Room Type', 'description' =>'This is Garden Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'34', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'35', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'36', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'37', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'38', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'39', 'name' =>'Deluxe Classic Room Type', 'description' =>'This is Deluxe Classic Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'40', 'name' =>'Deluxe Garden View Room Type', 'description' =>'This is Deluxe Garden View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'41', 'name' =>'Deluxe River View Room Type', 'description' =>'This is Deluxe River View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'42', 'name' =>'River View Suite Room Type', 'description' =>'This is River View Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'43', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'44', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'45', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'46', 'name' =>'Premier Deluxe Room Type', 'description' =>'This is Premier Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'47', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'48', 'name' =>'Standard Balcony Room Type', 'description' =>'This is Standard Balcony Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'49', 'name' =>'Deluxe Bungalow Room Type', 'description' =>'This is Deluxe Bungalow Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'50', 'name' =>'Amata Villa Room Type', 'description' =>'This is Amata Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'51', 'name' =>'Deluxe Suite Room Type', 'description' =>'This is Deluxe Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'52', 'name' =>'Royal Deluxe Lake Side View Room Type', 'description' =>'This is Royal Deluxe Lake Side View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'53', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'54', 'name' =>'Floating Deluxe Room Type', 'description' =>'This is Floating Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'55', 'name' =>'Floating Deluxe Triple Room Type', 'description' =>'This is Floating Deluxe Triple Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'56', 'name' =>'On Land Deluxe Room Type', 'description' =>'This is On Land Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'57', 'name' =>'Upper Superior Room Type', 'description' =>'This is Upper Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'58', 'name' =>'Lower Superior Room Type', 'description' =>'This is Lower Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'59', 'name' =>'Second Row Villa Room Type', 'description' =>'This is Second Row Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'60', 'name' =>'Villa On the Shore Room Type', 'description' =>'This is Villa On the Shore Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'61', 'name' =>'First Row Villa Room Type', 'description' =>'This is First Row Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'62', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'63', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'64', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'65', 'name' =>'Lake Front Deluxe Cottage Room Type', 'description' =>'This is Lake Front Deluxe Cottage Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'66', 'name' =>'Mountain View Chalet Room Type', 'description' =>'This is Mountain View Chalet Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'67', 'name' =>'Lake Front View Chalet Room Type', 'description' =>'This is Lake Front View Chalet Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'68', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'69', 'name' =>'Villa Room Type', 'description' =>'This is Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'70', 'name' =>'Mountain Houses Room Type', 'description' =>'This is Mountain Houses Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'71', 'name' =>'Garden Houses Room Type', 'description' =>'This is Garden Houses Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'72', 'name' =>'Lake Houses Room Type', 'description' =>'This is Lake Houses Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'73', 'name' =>'Princess Houses Room Type', 'description' =>'This is Princess Houses Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'74', 'name' =>'Garden Cottage Room Type', 'description' =>'This is Garden Cottage Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'75', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'76', 'name' =>'Royal Villa Room Type', 'description' =>'This is Royal Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'77', 'name' =>'Royal Villa Inle Lake View Room Type', 'description' =>'This is Royal Villa Inle Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


            ['id'=>'78', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'79', 'name' =>'Superior Balcony Room Type', 'description' =>'This is Superior Balcony Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'80', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'81', 'name' =>'Deluxe Suite Room Type', 'description' =>'This is Royal Villa Deluxe Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'82', 'name' =>'Mount Inle Suite Room Type', 'description' =>'This is Mount Inle Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'83', 'name' =>'Second Row Deluxe Lake View Room Type', 'description' =>'This is Second Row Deluxe Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'84', 'name' =>'Deluxe Mountain View Room Type', 'description' =>'This is Deluxe Mountain View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'85', 'name' =>'Deluxe Lake View Room Type', 'description' =>'This is Deluxe Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'86', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


            ['id'=>'87', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'88', 'name' =>'Deluxe Suite with Lake View Room Type', 'description' =>'This is Deluxe Suite with Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'89', 'name' =>'Superior Villa Room Type', 'description' =>'This is Superior Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'90', 'name' =>'Deluxe Villa Lake View Room Type', 'description' =>'This is Deluxe Villa Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'91', 'name' =>'Presidential Villa Room Type', 'description' =>'This is Presidential Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'92', 'name' =>'Superior Teak Room Type', 'description' =>'This is Superior Teak Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'93', 'name' =>'Traditional Inthar-Deluxe Cottage Room Type', 'description' =>'This is Traditional Inthar-Deluxe Cottage Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


            ['id'=>'94', 'name' =>'Floating Duplex Room Type', 'description' =>'This is Floating Duplex Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'95', 'name' =>'Floating Duplex Family Room Type', 'description' =>'This is Floating Duplex Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'96', 'name' =>'Inle Lotus Villa Room Type', 'description' =>'This is TInle Lotus Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'97', 'name' =>'Inle Lotus Villa with Private Spa Room', 'description' =>'This is Inle Lotus Villa with Private Spa Room', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'98', 'name' =>'Inle Lotus Suite Room Type', 'description' =>'This is Inle Lotus Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'99', 'name' =>'Cloister Deluxe Room Type', 'description' =>'This is Cloister Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'100', 'name' =>'Provost Junior Suite Garden View Villa Room Type', 'description' =>'This is Provost Junior Suite Garden View Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'101', 'name' =>'Abbey Suite Room Type', 'description' =>'This is Abbey Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'102', 'name' =>'Deluxe Room Type', 'description' =>'This isDeluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'103', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'104', 'name' =>'Superior City View Room Type', 'description' =>'This is Superior City View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'105', 'name' =>'Deluxe City View Room Type', 'description' =>'This is Deluxe City View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'106', 'name' =>'Deluxe  River View Room Type', 'description' =>'This is Deluxe  River View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'107', 'name' =>'Suite City View Room Type', 'description' =>'This is Suite City View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'108', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'109', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'110', 'name' =>'Deluxe without Balcony Room Type', 'description' =>'This is Deluxe without Balcony Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'111', 'name' =>'Deluxe with Balcony Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'112', 'name' =>'Premier with Balcony Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'113', 'name' =>'Executive Suite Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'114', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'115', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'116', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'117', 'name' =>'Special Suite Room Type', 'description' =>'This is Special Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'118', 'name' =>'Triple Suite Room Type', 'description' =>'This is Triple Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'119', 'name' =>'Family Suite Room Type', 'description' =>'This is Family Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

            ['id'=>'120', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'121', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
            ['id'=>'122', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'123', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'124', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'125', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'126', 'name' =>'Family Room Type', 'description' =>'This is Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'127', 'name' =>'Rakhine Room Type', 'description' =>'This is Rakhine Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'128', 'name' =>'Kachin Room Type', 'description' =>'This is Kachin Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'129', 'name' =>'Shan Room Type', 'description' =>'This is Shan Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'130', 'name' =>'Chin Room Type', 'description' =>'This is Chin Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'131', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'132', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'133', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'134', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'135', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'136', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'137', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'138', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'139', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'140', 'name' =>'Royal Suite Room Type', 'description' =>'This is Royal Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'141', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'142', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'143', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'144', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'145', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'146', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'147', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'148', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'149', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'150', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'151', 'name' =>'Family Room Type', 'description' =>'This is Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'152', 'name' =>'Kyi Tin Suite Room Type', 'description' =>'This is Kyi Tin Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'153', 'name' =>'Bungalow Room Type', 'description' =>'This is Bungalow Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'154', 'name' =>'Superior Room Type', 'description' =>'This is Bungalow Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'155', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'156', 'name' =>'Family Room Type', 'description' =>'This is Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'157', 'name' =>'Eco Single Room Type', 'description' =>'This is Eco Single Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'158', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'159', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'160', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'161', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'162', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'163', 'name' =>'Corner Deluxe Room Type', 'description' =>'This is Corner Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'164', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'165', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'166', 'name' =>'Spa Villa Room Type', 'description' =>'This is Spa Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'167', 'name' =>'Mandalar Suite Room Type', 'description' =>'This is Mandalar Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'168', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'169', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'170', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'171', 'name' =>'Corner Suite Room Type', 'description' =>'This is Corner Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'172', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'173', 'name' =>'Deluxe Twin Room Type', 'description' =>'This is Deluxe Twin Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'174', 'name' =>'Deluxe Double Room Type', 'description' =>'This is Deluxe Double Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'175', 'name' =>'Superior Twin Room Type', 'description' =>'This is Superior Twin Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'176', 'name' =>'Superior Double Room Type', 'description' =>'This is Superior Double Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'177', 'name' =>'Deluxe Room Type', 'description' =>'This is SDeluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'178', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'179', 'name' =>'Royal Room Type', 'description' =>'This is Royal Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'180', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'181', 'name' =>'Family Suite Zakawah Room Type', 'description' =>'This is Family Suite Zakawah Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'182', 'name' =>'Family Suite Zizawah Room Type', 'description' =>'This is Family Suite Zizawah Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'183', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'184', 'name' =>'Pool View Premier Suite Room Type', 'description' =>'This is Pool View Premier Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'185', 'name' =>'Premier Suite Room Type', 'description' =>'This is Premier Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'186', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'187', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'188', 'name' =>'Premier Deluxe Room Type', 'description' =>'This is Premier Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'189', 'name' =>'Club Deluxe Room Type', 'description' =>'This is Club Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'190', 'name' =>'Club Premier Room Type', 'description' =>'This is Club Premier Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'191', 'name' =>'Club Suite Room Type', 'description' =>'This is Club Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'192', 'name' =>'Apartment Suite Room Type', 'description' =>'This isApartment Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'193', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'194', 'name' =>'Ambassador Suite Room Type', 'description' =>'This is Ambassador Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'195', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'196', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'197', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'198', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'199', 'name' =>'Corner Suite Room Type', 'description' =>'This is Corner Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'200', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'201', 'name' =>'Premier Suite Room Type', 'description' =>'This is Premier Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'202', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'203', 'name' =>'Villa Room Type', 'description' =>'This is Villa Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'204', 'name' =>'Royal Villa Suite Room Type', 'description' =>'This is Royal Villa Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'205', 'name' =>'Royal King Villa Suite Room Type', 'description' =>'This is Royal King Villa Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'206', 'name' =>'Superior Room Type', 'description' =>'This is Royal Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'207', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'208', 'name' =>'Shwe Ye Mon Special Room Type', 'description' =>'This is Shwe Ye Mon Special Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'209', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'210', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'211', 'name' =>'Family Room Type', 'description' =>'This is Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'212', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'213', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'214', 'name' =>'Executive Room Type', 'description' =>'This is Executive Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'215', 'name' =>'Villa Junior Suite Room Type', 'description' =>'This is Villa Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'216', 'name' =>'Villa Deluxe Room Type', 'description' =>'This is Villa Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'217', 'name' =>'Economy Room Type', 'description' =>'This is Economy Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'218', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'219', 'name' =>'Family Room Type', 'description' =>'This is Family Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'220', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'221', 'name' =>'Superior ', 'description' =>'This is Superior ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'222', 'name' =>'Deluxe', 'description' =>'This is Deluxe', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'223', 'name' =>'Villa', 'description' =>'This is Villa', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'224', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'225', 'name' =>'Executive Room Type', 'description' =>'This is Executive Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'226', 'name' =>'Royal Suite Room Type', 'description' =>'This is Royal Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'227', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'228', 'name' =>'Executive Deluxe Room Type', 'description' =>'This is Executive Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'229', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'230', 'name' =>'Premier Deluxe Room Type', 'description' =>'This is Premier Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'231', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'232', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'233', 'name' =>'Royal Deluxe Room Type', 'description' =>'This is Royal Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'234', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'235', 'name' =>'Chatrium Club Room Type', 'description' =>'This is Chatrium Club Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'236', 'name' =>'Corner Deluxe Room Type', 'description' =>'This is Corner Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'237', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'238', 'name' =>'Studio Suite Room Type', 'description' =>'This is Studio Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'239', 'name' =>'Deluxe Suite Room Type', 'description' =>'This is Deluxe Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'240', 'name' =>'Luxury Suite Room Type', 'description' =>'This is Luxury Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'241', 'name' =>'Royal Lake Suite Room Type', 'description' =>'This isRoyal Lake Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'242', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'243', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'244', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'245', 'name' =>'Executive Room Type', 'description' =>'This is Executive Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'246', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'247', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-67 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'248', 'name' =>'Executive Lounge Deluxe Room Type', 'description' =>'This is Executive Lounge Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'249', 'name' =>'Executive Lounge Suite Room Type', 'description' =>'This is Executive Lounge Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'250', 'name' =>'Royal Suite Room Type', 'description' =>'This is Royal Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'251', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'252', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'253', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'254', 'name' =>'Apartment Room Type', 'description' =>'This is Apartment Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'255', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'256', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'257', 'name' =>'Lake Front Deluxe Room Type', 'description' =>'This is Lake Front Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'258', 'name' =>'Diplomat Suite Room Type', 'description' =>'This is Diplomat Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'259', 'name' =>'Corporate Suite Room Type', 'description' =>'This is Corporate Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'260', 'name' =>'Governor Suite Room Type', 'description' =>'This is Governor Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'261', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'262', 'name' =>'Imperial Suite Room Type', 'description' =>'This is Imperial Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'263', 'name' =>'Royal Bungalow Room Type', 'description' =>'This is Royal Bungalow Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'264', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'265', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'266', 'name' =>'Premier Lake View Type', 'description' =>'This is Premier Lake View Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'267', 'name' =>'Club Deluxe Room Type', 'description' =>'This is Club Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'268', 'name' =>'Club Premier Room Type', 'description' =>'This is Club Premier Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'269', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'270', 'name' =>'Premier Lake View Room Type', 'description' =>'This is Premier Lake View Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'271', 'name' =>'The Level Room Type', 'description' =>'This is The Level Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'272', 'name' =>'Junior Suite Room Type', 'description' =>'This is Junior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'273', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'274', 'name' =>'Grand Suite Room Type', 'description' =>'This is Grand Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'275', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'276', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'277', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'278', 'name' =>'Deluxe Suite Room Type', 'description' =>'This is Deluxe Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'279', 'name' =>'Executive Room Type', 'description' =>'This is Executive Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'280', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'281', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'282', 'name' =>'Suite Room Type', 'description' =>'This is Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'283', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'284', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'285', 'name' =>'Premier Room Type', 'description' =>'This is Premier Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'286', 'name' =>'Orchid Club Room Type', 'description' =>'This is Orchid Club Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'287', 'name' =>'Studio Suite Room Type', 'description' =>'This is Studio Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'288', 'name' =>'Service Suite Room Type', 'description' =>'This is Service Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'289', 'name' =>'Ambassador Suite Room Type', 'description' =>'This is Ambassador Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'290', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'291', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'292', 'name' =>'Executive Deluxe Room Type', 'description' =>'This is Executive Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'293', 'name' =>'Grand Deluxe Room Type', 'description' =>'This is Grand Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'294', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'295', 'name' =>'Balcony Deluxe Room Type', 'description' =>'This is Balcony Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'296', 'name' =>'Bamboo Executive Room Type', 'description' =>'This is Bamboo Executive Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'297', 'name' =>'Padauk Suite Room Type', 'description' =>'This is Padauk Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'298', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'299', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'300', 'name' =>'Premier Room Type', 'description' =>'This is Premier Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'301', 'name' =>'Studio Suite Room Type', 'description' =>'This is Studio Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'302', 'name' =>'Balcony Suite Room Type', 'description' =>'This is Balcony Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'303', 'name' =>'Sedona Club Room Type', 'description' =>'This is Sedona Club Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'304', 'name' =>'Sedona Club Suite Room Type', 'description' =>'This is Sedona Club Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'305', 'name' =>'Princess Suite Room Type', 'description' =>'This is Princess Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'306', 'name' =>'Ambassador Suite Room Type', 'description' =>'This is Ambassador Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'307', 'name' =>'Royal Sedona Suite Room Type', 'description' =>'This is Royal Sedona Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'308', 'name' =>'Executive Apartment Room Type', 'description' =>'This is Executive Apartment Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'309', 'name' =>'Premier Deluxe Room Type', 'description' =>'This is Premier Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'310', 'name' =>'Premier Club Deluxe Room Type', 'description' =>'This is Premier Club Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'311', 'name' =>'Prestige Suite Room Type', 'description' =>'This is Prestige Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'312', 'name' =>'Irrawaddy Suite Room Type', 'description' =>'This is Irrawaddy Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'313', 'name' =>'Shinsawbu Suite Room Type', 'description' =>'This is Shinsawbu Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'314', 'name' =>'Anawyahta Suite Room Type', 'description' =>'This is Anawyahta Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'315', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'316', 'name' =>'Superior Suite Room Type', 'description' =>'This is Superior Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'317', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'318', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

              ['id'=>'319', 'name' =>'Superior Room Type', 'description' =>'This is Superior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'320', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'321', 'name' =>'Horizon Club Room Type', 'description' =>'This is Horizon Club Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'322', 'name' =>'Deluxe Suite Room Type', 'description' =>'This is Deluxe Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'323', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'324', 'name' =>'Club Suite Room Type', 'description' =>'This is Club Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'325', 'name' =>'Presidential Suite Room Type', 'description' =>'This is Presidential Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],


              ['id'=>'326', 'name' =>'Supeior Room Type', 'description' =>'This is Supeior Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'327', 'name' =>'Deluxe Room Type', 'description' =>'This is Deluxe Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'328', 'name' =>'Premier Room Type', 'description' =>'This is Premier Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'329', 'name' =>'Studio Suite Room Type', 'description' =>'This is Studio Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'330', 'name' =>'Executive Suite Room Type', 'description' =>'This is Executive Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'331', 'name' =>'Family Suite Room Type', 'description' =>'This is Family Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'332', 'name' =>'Premier Suite Room Type', 'description' =>'This is Premier Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'333', 'name' =>'Premier Family Suite Room Type', 'description' =>'This is Premier Family Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],
              ['id'=>'334', 'name' =>'Pagoda Suite Room Type', 'description' =>'This is Pagoda Suite Room Type', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

               ['id'=>'335', 'name' =>'Standard Room Type ', 'description' =>'This is Standard Room Type ', 'created_by' =>'1', 'updated_by' =>'1', 'created_at' =>'2017-01-06 11:30:35', 'updated_at' =>'2017-01-06 11:30:35'],

        );
        DB::table('h_room_type')->insert($objs);
    }
}
