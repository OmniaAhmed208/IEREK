<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\conference_link_out;
class Events extends Model
{
    
    const upload_dir = "securedUploades";
    const abstract_folder = "abstracts";
    const conf_folder = "conferences";
    const speakers_image_folder = "speakers/images";
    const speakers_cv_folder = "speakers/cvs";
    const sponsors_folder = "sponsors";
    const fullpaper_folder = "fullpapers";
    const abstract_type = 1;
    const fullpaper_type = 2;
    const sponsors_logo_type = 3;
    const speakers_img_type = 4;
    const speakers_cv_type = 5;
    public function sub_category()
    {
        return $this->hasOne('App\Models\SubCategory', 'sub_category_id', 'sub_category_id');
    }

    public function event_sections()
    {
        return $this->hasMany('App\Models\EventSection','event_id','event_id');
    }
    
    public function scopeEventsData($query,$dt)
    {
     return $query
       ->where('end_date', '>', $dt)
       ->Join ('event_important_date as eid', 'eid.event_id', '=' , 'events.event_id')
       ->distinct('event_id')
        ->select('events.*');
    }

    protected $table = 'events';

    protected $fillable = 
    [
    'title_en',
    'title_ar',
    'slug',
    'email',
    'location_en',
    'start_date',
    'end_date',
    'sub_category_id',
    'category_id',
    'custome',
    'publish',
    'submission',
    'fullpaper',
    'egy',
    'overview',
    'currency',
    'conver_img',
    'list_img',
    'slider_img',
    'event_master_id',
    'featured_img',
    'writing_template',
    'meta_title',
    'meta_keywords',
    'meta_description',
      'fimage',
    'fimage'
    ];

    /**
     * proform the relation to topics table
     * @return type
     */
    public function topics() {
        return $this->hasMany('App\Models\Topics');
    }

        public function get_conference_link_out()
    {
        return $this->hasOne('App\Models\conference_link_out', 'event_id', 'event_id');
    }


}
