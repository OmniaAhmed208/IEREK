<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
class SponsorShip extends Model
{
   
    protected $table = "sponsorship";

    
    
    protected $fillable =
    [
    'sponsor_gendar',
    'sponsor_title',
    'sponsor_name',
    'sponsor_organization',
    'sponsor_website',
    'sponsor_department',
    'sponsor_street',
    'sponsor_code',
    'sponsor_city',
    'sponsor_country',
    'sponsor_phone',
        'sponsor_fax',
        'sponsor_mobile',
        'sponsor_email',
        'sponsor_package',
        'sponsor_signature',
        'sponsor_event',
        'created_at',
        'updated_at'
        
    ];
    
    
  
}
