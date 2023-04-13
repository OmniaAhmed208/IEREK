<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    //
    protected $table = 'videos';

    protected $fillable = 
    [
    'video_id',
    'img',
    'title',
    'url',
    'created_at',
    'updated_at',
    'deleted',
    'position'
    ];
}
