<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('so_id');
            $table->text('content');
            $table->text('link');
            $table->timestamp('sm_created_at');
            $table->timestamp('so_added_to_system');
            $table->unsignedBigInteger('domain_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('sentiment_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('gender_id');
            $table->timestamps();

            $table->foreign('domain_id')->references('id')->on('domains');
            $table->foreign('type_id')->references('id')->on('types');
            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('sentiment_id')->references('id')->on('sentiments');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('gender_id')->references('id')->on('genders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
