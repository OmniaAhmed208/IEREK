<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMaster extends Model
{
    //
    protected $table = 'event_master';
    protected $fillable = ['title','slug'];
}
