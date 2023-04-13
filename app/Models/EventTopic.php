<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class EventTopic extends Model {

    protected $table = 'event_topic';
    
    protected $fillable = [
        'event_id',
        'title_en',
        'description_en',
        'title_ar',
        'description_ar',
        'position'
    ];

    /**
     * proform the relation to topics table
     * @return type
     */
    public function event() {
        return $this->belongsTo('App\Models\Events');
    }

    
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at']);
    }


    /**
     * update topic positions using transaction
     * @param $positions array with topic_id and position
     */
    public function updatePositions($positions)
    {
        // run a Db transaction to update positions
        DB::transaction(function () use ($positions){

            foreach($positions as $position){

                DB::table($this->table)
                    ->where(["topic_id" => $position["topic_id"]])
                    ->update(['position' => $position["position"]]);

            }
        });
    }
}
