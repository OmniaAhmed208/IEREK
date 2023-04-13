<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTickets extends Model
{
    //
    public function attendance()
    {
        return $this->hasOne('App\Models\EventAttendance', 'event_attendance_id', 'event_attendance_id');
    }
    
    public function event()
    {
        return $this->hasOne('App\Models\Events', 'event_id', 'event_id');
    }

    protected $table = "payments";

    protected $fillable = 
    [
    'ticket_id',
    'event_ticket',
    'event_id',
    'paid',
    'created_at'
    ];
}
