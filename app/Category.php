<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Get the tags for the category.
     */
    public function tags()
    {
        return $this->hasMany('App\Tag');
    }
}
