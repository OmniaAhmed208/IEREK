<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //
	public function parent()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'parent_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payments', 'payment_id', 'payment_id');
    }


    public function event()
    {
        return $this->hasOne('App\Models\Events', 'event_id', 'event_id');
    }

	public function attendance()
    {
        return $this->hasOne('App\Models\EventAttendance', 'event_attendance_id', 'event_attendance_id');
    }

    protected $table = "orders";

    protected $fillable = 
    [
    'order_id',
    'event_attendance_id',
    'event_id',
    'payment_id',
    'parent_id',
    'order_type',
    'status',
    'total',
    'currency',
    'created_at'
    ];
}
