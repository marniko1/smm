<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
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
 	 * Get the posts for the domain.
 	 */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
