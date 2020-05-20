<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
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
 	 * Get the posts for the gender.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
