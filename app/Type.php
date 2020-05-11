<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
 	 * Get the posts for the type.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
