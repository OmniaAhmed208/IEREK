<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    //
    protected $table = 'slider';

    protected $fillable = ['slider_sid' , 'position',  'img' , 'img_url', 'created_at', 'created_by', 'updated_at', 'updated_by','deleted' ];

}