<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sentiment extends Model
{
    /**
 	 * Get the posts for the sentiment.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
