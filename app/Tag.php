<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

	/**
     * The posts that belong to the tag.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }

    /**
     * Get the category that owns the tag.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
