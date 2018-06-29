<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScrapperTasks extends Model
{
	// protected $table = 'files';
	public function posts()
    {
		return $this->hasMany('App\ScrapperPosts');
    }
}
