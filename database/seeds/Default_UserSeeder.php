<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 7/4/2016
 * Time: 3:03 PM
 */

use Illuminate\Database\Seeder;
class Default_UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    DB::table('core_users')->delete();
    /*
    * myanmarpolestar admin pwd - 123@myanmarpolestar
    */
    $roles = array(
        ['id'=>1, 'user_name'=>'admin','display_name'=>'Administrator', 'password' =>'$2y$10$NLS2i1NpEUuQgoLgYk0QSOxsKxk6u1PFdeYJkpCraq2rS6polwYI6', 'email' =>'waiyanaung@aceplussolutions.com','role_id' =>'1','staff_id'=>'0001','address'=>'Building 5, Room 10, MICT Park, Hlaing Township, Yangon, Myanmar.','description'=>'This is super admin role'],
        ['id'=>2, 'user_name'=>'myanmarpolestar','display_name'=>'Myanmar Pole Star Administrator', 'password' =>'$2y$10$KbM7QKh5b0t9OaWoLn793.EuSKdowmbzkfq6KZZe0cagKnz2x9smO', 'email' =>'myanmarpolestar2017testing@gmail.com','role_id' =>'2','staff_id'=>'0002','address'=>'601/602, 6th Floor, La Pyat Wun Plaza, Alan Pya Pagoda Road Dagon Township,Yangon, MYANMAR.','description'=>'This is user admin role'],
         
    );

    DB::table('core_users')->insert($roles);
}
}