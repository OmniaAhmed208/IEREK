<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFullPaperHistory extends Model
{
    //

	public function reviewer()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'reviewer_id');
    }
    public function paper()
    {
        return $this->hasOne('App\Models\EventFullPaper', 'paper_id', 'paper_id');
    }

    protected $table = 'event_full_paper_history';

    protected $fillable = ["reviewer_id","paper_id","comments","extras","result","revision_edition","evaluation_sheet","expire"];
}
