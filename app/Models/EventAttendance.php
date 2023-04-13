<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAttendance extends Model
{
    //
	public function event_attendance_type()
    {
        return $this->hasOne('App\Models\EventAttendanceType', 'event_attendance_type_id', 'event_attendance_type_id');
    }

    public function users()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'user_id');
    }

    public function events()
    {
        return $this->hasOne('App\Models\Events', 'event_id', 'event_id');
    }
    
    /**
     * all attendance of event by eventId
     * @param type $query
     * @param type $eventId
     * @return type
     */
    public function scopeEvent($query, $eventId){
        return $query->where('event_id',$eventId);;
    }
    
    /**
     * all events for certain user by userId
     * @param type $query
     * @param type $eventId
     * @param type $attendanceId
     */
    public function scopeUser($query, $userId){
        return $query->where('user_id',$userId);
    }
    
    public function scopeRegisteredBefore($query, $userId, $eventId){
        return $query->where('user_id',$userId)
                ->where('event_id', "!=" , $eventId)
                ->whereDate('created_at', "<=", date("Y-m-d"))
                ->where("payment", 1);
    }
    
    public function scopeAttendenceDataToInvoiceDetails($query,$event_id,$user_id)
    {
     return $query
        ->where('event_attendance.event_id', $event_id) 
        ->where('event_attendance.user_id',$user_id) 
        ->join ('events as e', 'e.event_id', '=' , 'event_attendance.event_id')   
        ->join ('event_attendance_type as ett', 'ett.event_attendance_type_id', '=' , 'event_attendance.event_attendance_type_id');       
    }

    protected $table = "event_attendance";

    protected $fillable = ["event_id","user_id","event_attendance_type_id","name","email","payment","unregistered","postpone"];
}
