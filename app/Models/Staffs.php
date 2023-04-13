<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staffs extends Model
{
    //
    protected $table = 'Staffs';

    protected $fillable = ['staff_id', 'staff_name', 'birth_date', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted'];

}