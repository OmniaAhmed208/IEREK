<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodations extends Model
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

    public function fees()
    {
        return $this->hasOne('App\Models\EventFees', 'event_fees_id', 'event_fees_id');
    }
    protected $table = "accommodations";

    protected $fillable =
    [
    'accommodation_id',
    'event_attendance_id',
    'event_id',
    'event_fees_id',
    'paid',
    'created_at',
    'updated_at'
    ];
    
    /**
     * 
     * @param type $attendanceId
     * @param type $eventId
     * @return type
     */
    public static function getAccommodationOfEvent($attendanceId, $eventId){
        return self::where('event_attendance_id',$attendanceId)
                            ->where('event_id',$eventId)
                            ->where('paid', 1)
                            ->get();
    }
}
