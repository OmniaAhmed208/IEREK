<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSpeakers extends Model
{

	//
    protected $table = 'event_speakers';

    protected $fillable = ['event_id','full_name','email','img','cv','brief_description','university','linkedin','twitter','facebook','created_by','updated_by'];
}
