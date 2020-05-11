<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
 	 * Get the posts for the author.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
