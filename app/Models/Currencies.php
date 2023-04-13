<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    //
    protected $table = 'currencies';

    protected $fillable = ['currency_sid' , 'currency_code',  'currency_name' , 'currency_symbol', 'created_at', 'created_by', 'updated_at', 'updated_by','deleted' ];

}