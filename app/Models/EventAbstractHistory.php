<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAbstractHistory extends Model
{
    //
    public function users()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'reviewer_id');
    }

    protected $table = "event_abstract_history";

    protected $fillable = ["reviewer_id","abstract_id","title","comment","updated_at","created_at"];
}