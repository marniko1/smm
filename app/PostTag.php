<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PostTag extends Pivot
{
    public function post() {
        return $this->belongsTo('App\Post');
    }
}
