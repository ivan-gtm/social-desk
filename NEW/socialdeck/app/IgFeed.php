<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IgFeed extends Model
{
    public function hashtags()
    {
        return $this->hasMany('App\hashtags');
    }
}
