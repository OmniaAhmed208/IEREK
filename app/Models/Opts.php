<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opts extends Model
{
    //
    protected $table = "opts";

    protected $fillable = [
    'user_id',
    'log_bg',
    'log_font',
    'log_auto',
    'side_menu'

    ];
}
