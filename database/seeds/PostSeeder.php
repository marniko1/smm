<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\Post::class, 5000)->create()->each(function($post) {
            $post->tags()->sync(
                App\Tag::all()->random( rand(1,5) )->pluck('id')->toArray()
            );
        });
    }
}
