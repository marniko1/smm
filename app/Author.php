<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'author_id'
    ];
    /**
 	 * Get the posts for the author.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
