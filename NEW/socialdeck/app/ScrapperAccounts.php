<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScrapperAccounts extends Model
{
	// protected $table = 'files';
	public function tasks()
    {
		return $this->hasMany('App\ScrapperTasks',  'account_id', 'id');
    }
}
