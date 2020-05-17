<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use App\Domain;
use App\Post;
use App\Sentiment;
use App\Type;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {

	$so_id = $faker->boolean(80) ? $faker->unique(true)->numerify('###############_###############') : $faker->unique(true)->numerify('twitter_###################');

    if (strpos($so_id, 'twitter') === false) {
        $domain = 'Facebook';
        $type = $faker->boolean(90) ? 'Post' : 'Video';
        $author = 'Naprednjaci';
    } else {
        $domain = 'Twitter';
        $type = 'Tweet';
        $author = 'SDP Srbije (@sdpsrbije)';
    }



    if ($faker->boolean(80)) {
        $sentiment = 'neutral';
    } else {
        $sentiment = $faker->randomElement(['positive', 'negative']);
    }



    $domain_id = Domain::where('name', $domain)->first()->id;
    $type_id = Type::where('name', $type)->first()->id;
    $author_id = Author::where('name', $author)->first()->id;
	$sentiment_id = Sentiment::where('name', $sentiment)->first()->id;

    return [
        'so_id' => $so_id,
        'content' => $faker->realText(rand(80, 600)),
        'link' => 'http://www.facebook.com/189911378558330/posts/490543108495154',
        'sm_created_at' => '2000-01-01',
        'so_added_to_system' => '2000-01-01',
        'domain_id' => $domain_id,
        'type_id' => $type_id,
        'author_id' => $author_id,
        'sentiment_id' => $sentiment_id,
        'project_id' => 1,
        'gender_id' => 1,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    	'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});