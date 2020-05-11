<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{

	protected $authors = array(
								array('name' => 'Naprednjaci', 'author_id' => '393052167941941'),
								array('name' => 'SDP Srbije (@sdpsrbije)', 'author_id' => '144112841'),
							);
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->authors as $author) {
        	DB::table('authors')->insert([
	            'name' => $author['name'],
	            'author_id' => $author['author_id'],
	            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
	        ]);
        }
    }
}
