<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    //
    protected $table = 'user_type';
    const super_admin = 4;
    const conf_editor = 3;
    const conf_admin = 2;
    const scientific_committee = 1;
    const regular_user = 0;
    const accountant = 5;
}
