<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class conference_link_out extends Model
{
    //
    protected $table='conference_link_outs';
    protected $fillable = [
        'id','conference_link',
    ];
   

  

}