<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSponsors extends Model
{

	//
    protected $table = 'event_sponsors';

    protected $fillable = ['event_id','company_name','brief_description','img','website','contact_person_name','phone','email','proposal','linkedin','twitter','facebook','created_by','updated_by'];
}
