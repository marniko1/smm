<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The tags that belong to the post.
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withPivot('tag_id');
    }

    /**
     * Get the domain that owns the post.
     */
    public function domain()
    {
        return $this->belongsTo('App\Domain');
    }

    /**
     * Get the type that owns the post.
     */
    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    /**
     * Get the author that owns the post.
     */
    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    /**
     * Get the sentiment that owns the post.
     */
    public function sentiment()
    {
        return $this->belongsTo('App\Sentiment');
    }

    /**
     * Get the project that owns the post.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * Get the gender that owns the post.
     */
    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }
}
