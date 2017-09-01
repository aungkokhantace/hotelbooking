<?php

use Illuminate\Database\Seeder;

class Default_PriceFilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('price_filter')->delete();

        $roles = array(
            ['id'=>1,'name'=>'Under 50','from'=>0,'to'=>50,'type'=>'under','status'=>1],
            ['id'=>2,'name'=>'50-100','from'=>50,'to'=>100,'type'=>'between','status'=>1],
            ['id'=>3,'name'=>'100-150','from'=>100,'to'=>150,'type'=>'between','status'=>1],
            ['id'=>4,'name'=>'150-200','from'=>150,'to'=>200,'type'=>'between','status'=>1],
            ['id'=>5,'name'=>'200-250','from'=>200,'to'=>250,'type'=>'between','status'=>1],
            ['id'=>6,'name'=>'250-300','from'=>250,'to'=>300,'type'=>'between','status'=>1],
            ['id'=>7,'name'=>'Above 300','from'=>300,'to'=>0,'type'=>'above','status'=>1]
                                                            

        );

        DB::table('price_filter')->insert($roles);
    }
}
