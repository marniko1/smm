<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    /**
     * The posts that belong to the meta.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post')->withPivot('post_id');
    }
}
