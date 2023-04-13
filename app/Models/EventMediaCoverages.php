<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMediaCoverages extends Model
{

	//
    protected $table = 'event_media_coverages';

    protected $fillable = ['event_id','organization','email','img','brief_description','media_type','created_by','updated_by'];
}
