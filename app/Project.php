<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    /**
 	 * Get the posts for the project.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
