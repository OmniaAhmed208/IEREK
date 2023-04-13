<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class HostConference extends Model
{
    use Notifiable;

    protected $table = 'host_conference';

    protected $fillable = ['host_university', 'host_contact_name', 'host_contact_email', 'host_contact_affliation', 'host_conference_overview', 'host_residential_overview','host_catering','host_location','host_conference_program','host_budget'];


}
