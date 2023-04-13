<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFullPaper extends Model
{
    //
    public function users()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'author_id');
    }

    protected $table = "event_full_paper";

    protected $fillable = ["paper_id","abstract_id","event_id","final_edition","title","code","file","paid","author_id","paper_kind","blind_file"];
}
