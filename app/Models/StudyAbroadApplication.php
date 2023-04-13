<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StudyAbroadApplication extends Model
{
    use Notifiable;

    protected $table = 'study_abroad_applications';

    protected $fillable = ['app_undersigned_name', 'app_date_birth_day', 'app_city', 'app_state', 'app_state_of_residence', 'app_permanent_address','app_email','app_signature','app_category','app_sub_category','app_event_id'];


}
