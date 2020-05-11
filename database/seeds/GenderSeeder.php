<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
	protected $genders = array(
					array('name' => 'u', 'icon' => '<i class="fas fa-genderless" title="unspecified"></i>'),
					array('name' => 'm', 'icon' => '<i class="fas fa-mars" title="male"></i>'),
					array('name' => 'f', 'icon' => '<i class="fas fa-venus" title="female"></i>'),
				);
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->genders as $gender) {
        	DB::table('genders')->insert([
	            'name' => $gender['name'],
	            'icon' => $gender['icon'],
	            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
	        ]);
        }
    }
}
