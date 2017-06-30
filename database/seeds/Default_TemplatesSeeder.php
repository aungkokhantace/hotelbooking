<?php

use Illuminate\Database\Seeder;

class Default_TemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('template')->delete();

        $template = array(
            ['name'=>'Home Page', 'description'=>'Sliders show in home page'],
            ['name'=>'Destination Page', 'description'=>'Sliders show in destination page'],
            ['name'=>'About Us Page', 'description'=>'Sliders show in about us page'],
            ['name'=>'FAQ Page', 'description'=>'Sliders show in FAQ page'],
            ['name'=>'Contact Us Page', 'description'=>'Sliders show in Contact Us page'],
        );

        DB::table('template')->insert($template);
    }
}
