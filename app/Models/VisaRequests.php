<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaRequests extends Model
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
    
    public static function getVisaRequestsOfuserInEvent($attendanceId, $eventId){
        return self::where('event_attendance_id',$attendanceId)
                            ->where('event_id',$eventId)
                            ->where('paid', 1)
                            ->get();
    }
    protected $table = "visa_requests";

    protected $fillable = 
    [
    'visa_id',
    'event_attendance_id',
    'event_id',
    'fname',
    'mname',
    'lname',
    'passport_no',
    'address',
    'empassy_address',
    'additional',
    'image',
    'paid',
    'created_at',
    'updated_at'
    ];
}
