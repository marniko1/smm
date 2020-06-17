<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{

    protected $domains = array(
                    array('name' => 'Facebook', 'icon' => '<i class="fab fa-facebook btn"></i>'),
                    array('name' => 'Twitter', 'icon' => '<i class="fab fa-twitter btn"></i>'),
                    array('name' => 'Instagram', 'icon' => '<i class="fab fa-instagram btn"></i>'),
                );
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->domains as $domain) {
        	DB::table('domains')->insert([
	            'name' => $domain['name'],
                'icon' => $domain['icon'],
	            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
	        ]);
        }
    }
}
