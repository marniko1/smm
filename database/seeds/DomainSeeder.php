<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{

	protected $domains = array('Facebook', 'Twitter', 'Instagram');
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->domains as $domain) {
        	DB::table('domains')->insert([
	            'name' => $domain,
	            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
	        ]);
        }
    }
}
