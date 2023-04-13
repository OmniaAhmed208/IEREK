<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFullPaperReviewers extends Model
{
    //
    protected $table = "event_full_paper_reviewers";

    protected $fillable = ["paper_id","reviewer_id","status","status","expire","type","created_at"];
}
