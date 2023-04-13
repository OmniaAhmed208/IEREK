<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventImportantDate extends Model
{
    //
    protected $table = 'event_important_date';

    protected $fillable = ['event_id', 'event_date_type_id', 'title_en', 'title', 'to_date'];
}
