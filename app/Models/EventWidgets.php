<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventWidgets extends Model
{

    //public function event_attendance_type()
    //{
      //  return $this->hasOne('App\Models\EventAttendanceType', 'event_attendance_type_id', 'event_attendance_type_id');
    //}

    //public function event_date_type()
    //{
      //  return $this->hasOne('App\Models\EventDateType', 'event_date_type_id', 'event_date_type_id');
    //}

    public function widget_type()
    {
       return $this->hasOne('App\Models\WidgetTypes', 'widget_type_id', 'widget_type_id');
    }
    
    protected $table = 'event_widgets';

    protected $fillable = ['event_id','widget_type_id','widget_title','widget_description','img','img_url','position','created_by','updated_by'];
}
