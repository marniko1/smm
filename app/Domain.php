<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
   	/**
 	 * Get the posts for the domain.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
