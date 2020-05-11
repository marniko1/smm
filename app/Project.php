<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
 	 * Get the posts for the project.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
