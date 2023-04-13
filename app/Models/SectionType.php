<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class SectionType extends Model {

    protected $table = 'section_type';
    
    protected $fillable = [
        'title',
        'description'
    ];

    /**
     * proform the relation to section table
     * @return type
     */
    public function section() {
        return $this->hasMany('App\Models\EventSection');
    }

    /**
     * @return array
     */
    public function getAllSectionTypes()
    {
        // run a Db transaction to update positions
//        DB::transaction(function () use ($positions){
//
//            foreach($positions as $position){
//
//                DB::table($this->table)
//                    ->where(["topic_id" => $position["topic_id"]])
//                    ->update(['position' => $position["position"]]);
//
//            }
//        });

        return DB::table($this->table)->select('section_type_id', 'title')->get();

    }
}
