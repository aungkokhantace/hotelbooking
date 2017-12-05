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
        ['id'=>9999, 'user_name'=>'administrator_mps','display_name'=>'Administrator', 'password' =>'$2y$10$EYtEVFwk8HB.kK7Lr32YtOrnRsDew7dsyFWYNZNWxtMFFzf9zqzQ6', 'email' =>'waiyanaung1@aceplussolutions.com','role_id' =>'9999','staff_id'=>'9999','address'=>'Building 5, Room 10, MICT Park, Hlaing Township, Yangon, Myanmar.','description'=>'This is super admin first login role'],
        ['id'=>2, 'user_name'=>'myanmarpolestar','display_name'=>'Myanmar Pole Star Administrator', 'password' =>'$2y$10$KbM7QKh5b0t9OaWoLn793.EuSKdowmbzkfq6KZZe0cagKnz2x9smO', 'email' =>'myanmarpolestar2017testing@gmail.com','role_id' =>'2','staff_id'=>'0002','address'=>'601/602, 6th Floor, La Pyat Wun Plaza, Alan Pya Pagoda Road Dagon Township,Yangon, MYANMAR.','description'=>'This is user admin role'],
        ['id'=>1, 'user_name'=>'admin_aceplus','display_name'=>'Administrator', 'password' =>'$2y$10$wbHOhVmP001yRaS2sZhXJOsoO0aItWjB9rZ6zrGEIRGbfUjkiNSDK', 'email' =>'waiyanaung@aceplussolutions.com','role_id' =>'1','staff_id'=>'0001','address'=>'Building 5, Room 10, MICT Park, Hlaing Township, Yangon, Myanmar.','description'=>'This is super admin role'],

    );

    DB::table('core_users')->insert($roles);
}
}
