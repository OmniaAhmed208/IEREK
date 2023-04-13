<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class EventSection extends Model {

    protected $table = 'event_section';
    
    protected $fillable = [
        'event_id',
        'title_en',
        'description_en',
        'title_ar',
        'description_ar',
        'section_type_id',
        'position'
    ];

    /**
     * proform the relation to events table
     * @return type
     */
    public function event() {
        return $this->belongsTo('App\Models\Events');
    }

    public function sectionType() {
        return $this->belongsTo('App\Models\SectionType');
    }
    
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at']);
    }


    /**
     * update section positions using transaction
     * @param $positions array with section_id and position
     */
    public function updatePositions($positions)
    {
        // run a Db transaction to update positions
        DB::transaction(function () use ($positions){

            foreach($positions as $position){

                DB::table($this->table)
                    ->where(["section_id" => $position["section_id"]])
                    ->update(['position' => $position["position"]]);

            }
        });
    }
}
