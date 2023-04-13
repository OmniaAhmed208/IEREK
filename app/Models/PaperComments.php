<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaperComments extends Model
{
    //
	public function Users()
	{
		return $this->hasOne('App\Models\Users', 'user_id', 'user_id');
	}

    protected $table = 'paper_comments';

    protected $fillable = ["paper_id","user_id","user_type","message","filename","file"];
}
