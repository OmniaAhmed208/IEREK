<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
class Announcements extends Model
{
   
    protected $table = "announcements";

    
    
    protected $fillable =
    [
    'announce_image',
    'announce_url',
    'announce_active',
    'announce_position'
    ];
    
    
     public function updatePositions($positions)
    {
        // run a Db transaction to update positions
        DB::transaction(function () use ($positions){

            foreach($positions as $position){

                DB::table($this->table)
                    ->where(["announce_id" => $position["announce_id"]])
                    ->update(['announce_position' => $position["position"]]);

            }
        
    });

    }
}
