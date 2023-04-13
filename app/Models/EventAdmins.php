<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAdmins extends Model
{
    //
	public function users()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'user_id');
    }

    protected $table = "event_admins";

    protected $fillable = ["event_id","user_id","created_at","created_by","updated_at","updated_by"];
}
