<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sentiment extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'icon'
    ];
    /**
 	 * Get the posts for the sentiment.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
