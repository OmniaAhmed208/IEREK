<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coauthors extends Model
{
    //
    protected $table = 'coauthors';

    protected $fillable = [
    	'paper_id',
    	'user_id',
    	'event_id',
    	'name',
    	'email',
    	'deleted',
    	'updated_at'
    ];
}
