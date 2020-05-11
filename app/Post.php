<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The metas that belong to the post.
     */
    public function metas()
    {
        return $this->belongsToMany('App\Meta')->withPivot('tag_id');
    }
}
