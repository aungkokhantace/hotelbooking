<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 2:19 PM
 */

use Illuminate\Database\Seeder;

class Default_RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_permission_role')->delete();

        $roles = array(
            ['role_id'=>1, 'permission_id'=>1],
            ['role_id'=>1, 'permission_id'=>2],
            ['role_id'=>1, 'permission_id'=>3],
            ['role_id'=>1, 'permission_id'=>4],
            ['role_id'=>1, 'permission_id'=>5],
            ['role_id'=>1, 'permission_id'=>6],
            ['role_id'=>1, 'permission_id'=>7],
            ['role_id'=>1, 'permission_id'=>8],
            ['role_id'=>1, 'permission_id'=>9],
            ['role_id'=>1, 'permission_id'=>10],
            ['role_id'=>1, 'permission_id'=>11],
            ['role_id'=>1, 'permission_id'=>12],
            ['role_id'=>1, 'permission_id'=>13],
            ['role_id'=>1, 'permission_id'=>14],
            ['role_id'=>1, 'permission_id'=>15],
            ['role_id'=>1, 'permission_id'=>16],
            ['role_id'=>1, 'permission_id'=>17],
            ['role_id'=>1, 'permission_id'=>18],
            ['role_id'=>1, 'permission_id'=>19],
            ['role_id'=>1, 'permission_id'=>20],
            ['role_id'=>1, 'permission_id'=>21],
            ['role_id'=>1, 'permission_id'=>22],
            ['role_id'=>1, 'permission_id'=>23],

            ['role_id'=>1, 'permission_id'=>30],
            ['role_id'=>1, 'permission_id'=>31],
            ['role_id'=>1, 'permission_id'=>32],
            ['role_id'=>1, 'permission_id'=>33],
            ['role_id'=>1, 'permission_id'=>34],
            ['role_id'=>1, 'permission_id'=>35],
            ['role_id'=>1, 'permission_id'=>36],
            ['role_id'=>1, 'permission_id'=>37],
            ['role_id'=>1, 'permission_id'=>38],
            ['role_id'=>1, 'permission_id'=>39],
            ['role_id'=>1, 'permission_id'=>40],
            ['role_id'=>1, 'permission_id'=>41],
            ['role_id'=>1, 'permission_id'=>42],
            ['role_id'=>1, 'permission_id'=>43],
            ['role_id'=>1, 'permission_id'=>44],

            //Country
            ['role_id'=>1, 'permission_id'=>50],
            ['role_id'=>1, 'permission_id'=>51],
            ['role_id'=>1, 'permission_id'=>52],
            ['role_id'=>1, 'permission_id'=>53],
            ['role_id'=>1, 'permission_id'=>54],
            ['role_id'=>1, 'permission_id'=>55],

            //Township
            ['role_id'=>1, 'permission_id'=>60],
            ['role_id'=>1, 'permission_id'=>61],
            ['role_id'=>1, 'permission_id'=>62],
            ['role_id'=>1, 'permission_id'=>63],
            ['role_id'=>1, 'permission_id'=>64],
            ['role_id'=>1, 'permission_id'=>65],

            //City
            ['role_id'=>1, 'permission_id'=>70],
            ['role_id'=>1, 'permission_id'=>71],
            ['role_id'=>1, 'permission_id'=>72],
            ['role_id'=>1, 'permission_id'=>73],
            ['role_id'=>1, 'permission_id'=>74],
            ['role_id'=>1, 'permission_id'=>75],

            //Features
            ['role_id'=>1, 'permission_id'=>80],
            ['role_id'=>1, 'permission_id'=>81],
            ['role_id'=>1, 'permission_id'=>82],
            ['role_id'=>1, 'permission_id'=>83],
            ['role_id'=>1, 'permission_id'=>84],
            ['role_id'=>1, 'permission_id'=>85],

            //Amenities
            ['role_id'=>1, 'permission_id'=>90],
            ['role_id'=>1, 'permission_id'=>91],
            ['role_id'=>1, 'permission_id'=>92],
            ['role_id'=>1, 'permission_id'=>93],
            ['role_id'=>1, 'permission_id'=>94],
            ['role_id'=>1, 'permission_id'=>95],

            //Facilities
            ['role_id'=>1, 'permission_id'=>100],
            ['role_id'=>1, 'permission_id'=>101],
            ['role_id'=>1, 'permission_id'=>102],
            ['role_id'=>1, 'permission_id'=>103],
            ['role_id'=>1, 'permission_id'=>104],
            ['role_id'=>1, 'permission_id'=>105],

            //Hotel Restaurant Category
            ['role_id'=>1, 'permission_id'=>110],
            ['role_id'=>1, 'permission_id'=>111],
            ['role_id'=>1, 'permission_id'=>112],
            ['role_id'=>1, 'permission_id'=>113],
            ['role_id'=>1, 'permission_id'=>114],
            ['role_id'=>1, 'permission_id'=>115],

            //Room Category Amenities
            ['role_id'=>1, 'permission_id'=>120],
            ['role_id'=>1, 'permission_id'=>121],
            ['role_id'=>1, 'permission_id'=>122],
            ['role_id'=>1, 'permission_id'=>123],
            ['role_id'=>1, 'permission_id'=>124],
            ['role_id'=>1, 'permission_id'=>125],

            //Jquery Validation for Country and Township
            ['role_id'=>1, 'permission_id'=>130],
            ['role_id'=>1, 'permission_id'=>131],

            //Room View
            ['role_id'=>1, 'permission_id'=>140],
            ['role_id'=>1, 'permission_id'=>141],
            ['role_id'=>1, 'permission_id'=>142],
            ['role_id'=>1, 'permission_id'=>143],
            ['role_id'=>1, 'permission_id'=>144],
            ['role_id'=>1, 'permission_id'=>145],

            //Hotel
            ['role_id'=>1, 'permission_id'=>150],
            ['role_id'=>1, 'permission_id'=>151],
            ['role_id'=>1, 'permission_id'=>152],
            ['role_id'=>1, 'permission_id'=>153],
            ['role_id'=>1, 'permission_id'=>154],
            ['role_id'=>1, 'permission_id'=>155],

            //Hotel Room Type
            ['role_id'=>1, 'permission_id'=>160],
            ['role_id'=>1, 'permission_id'=>161],
            ['role_id'=>1, 'permission_id'=>162],
            ['role_id'=>1, 'permission_id'=>163],
            ['role_id'=>1, 'permission_id'=>164],
            ['role_id'=>1, 'permission_id'=>165],

            //Hotel Room Category
            ['role_id'=>1, 'permission_id'=>170],
            ['role_id'=>1, 'permission_id'=>171],
            ['role_id'=>1, 'permission_id'=>172],
            ['role_id'=>1, 'permission_id'=>173],
            ['role_id'=>1, 'permission_id'=>174],
            ['role_id'=>1, 'permission_id'=>175],

            //Room
            ['role_id'=>1, 'permission_id'=>180],
            ['role_id'=>1, 'permission_id'=>181],
            ['role_id'=>1, 'permission_id'=>182],
            ['role_id'=>1, 'permission_id'=>183],
            ['role_id'=>1, 'permission_id'=>184],
            ['role_id'=>1, 'permission_id'=>185],

            //Room Category Facilities
            ['role_id'=>1, 'permission_id'=>190],
            ['role_id'=>1, 'permission_id'=>191],
            ['role_id'=>1, 'permission_id'=>192],
            ['role_id'=>1, 'permission_id'=>193],
            ['role_id'=>1, 'permission_id'=>194],
            ['role_id'=>1, 'permission_id'=>195],

            //Hotel Feature
            ['role_id'=>1, 'permission_id'=>200],
            ['role_id'=>1, 'permission_id'=>201],
            ['role_id'=>1, 'permission_id'=>202],
            ['role_id'=>1, 'permission_id'=>203],
            ['role_id'=>1, 'permission_id'=>204],
            ['role_id'=>1, 'permission_id'=>205],

            //Room Discount
            ['role_id'=>1, 'permission_id'=>210],
            ['role_id'=>1, 'permission_id'=>211],
            ['role_id'=>1, 'permission_id'=>212],
            ['role_id'=>1, 'permission_id'=>213],
            ['role_id'=>1, 'permission_id'=>214],
            ['role_id'=>1, 'permission_id'=>215],

        );

        DB::table('core_permission_role')->insert($roles);
    }
}
