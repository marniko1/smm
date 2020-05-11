<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{

	protected $types = array('Post', 'Video', 'Tweet');
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->types as $type) {
        	DB::table('types')->insert([
	            'name' => $type,
	            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
	        ]);
        }
    }
}
