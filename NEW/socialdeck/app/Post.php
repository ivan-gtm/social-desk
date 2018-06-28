<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function media()
    {
    	return $this->hasMany('App\PostMedias');
    }
}
