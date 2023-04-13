<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class StudyApplication extends Model
{
    //
	use SoftDeletes;
	use Notifiable;

	public function users()
	{
		return $this->hasOne('App\User','user_id','user_id');
	}

    protected $fillable = ['user_id','application','event_id'];
    protected $dates = ['deleted_at'];
}