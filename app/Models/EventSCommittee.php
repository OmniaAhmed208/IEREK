<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSCommittee extends Model
{
    //
	public function users()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'user_id');
    }

    protected $table = "event_scientific_committee";

    protected $fillable = ["event_id","user_id","position","created_at","created_by","updated_at","updated_by"];

}
