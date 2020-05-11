<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    /**
 	 * Get the posts for the gender.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
