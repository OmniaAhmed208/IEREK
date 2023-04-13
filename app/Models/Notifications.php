<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    //
    protected $table = 'notifications';

    protected $fillable = [
    'notification_id',
    'title',
    'description',
    'user_id',
    'event_id',
    'type',
    'icon',
    'status',
    'color',
    'timeout',
    'url',
    'read',
    'show',
    'deleted',
    'created_at',
    'updated_at'
    ];
}
