<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FeaturedEvents extends Model
{

	public function event()
    {
        return $this->hasOne('App\Models\Events', 'event_id', 'event_id');
    }

    	public function get_conference_link_out()
    {
        return $this->hasOne('App\Models\conference_link_out', 'conference_id', 'event_id');
    }

    
    //
    protected $table = 'featured_events';

    protected $fillable = ['event_id','position','category_id','created_by','updated_by'];
}
