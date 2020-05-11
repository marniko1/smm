<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

	protected $categories = array(
								array('name' => 'OBJEKAT', 'prefix' => 'OB_'),
								array('name' => 'TEMA', 'prefix' => 'TM_'),
								array('name' => 'PORUKA', 'prefix' => 'POR_'),
								array('name' => 'AKTIVNOST', 'prefix' => 'AK_'),
								array('name' => 'STRANI AKTERI', 'prefix' => 'FI_'),
								array('name' => 'SENTIMENT', 'prefix' => 'SENT_'),
								array('name' => 'ANOMALIJE', 'prefix' => 'FLAG_'),
							);

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->categories as $category) {
        	DB::table('categories')->insert([
	            'name' => $category['name'],
	            'prefix' => $category['prefix'],
	            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
	        ]);
        }
    }
}
