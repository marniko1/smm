<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SentimentSeeder extends Seeder
{

	protected $sentiments = array(
								array('name' => 'neutral', 'icon' => '<i class="fas fa-meh text-warning" title="Neutral"></i>'),
								array('name' => 'negative', 'icon' => '<i class="fas fa-frown text-danger" title="Negative"></i>'),
								array('name' => 'positive', 'icon' => '<i class="fas fa-smile text-success" title="Positive"></i>'),
							);
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->sentiments as $sentiment) {
        	DB::table('sentiments')->insert([
	            'name' => $sentiment['name'],
	            'icon' => $sentiment['icon'],
	            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
	        ]);
        }
    }
}
