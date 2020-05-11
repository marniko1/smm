<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MetaPost extends Pivot
{
    public function post() {
        return $this->belongsTo('App\Post');
    }
}
