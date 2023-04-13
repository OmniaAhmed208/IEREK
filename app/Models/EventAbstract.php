<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAbstract extends Model
{
    const upload_dir = "securedUploades";
    const abstract_folder = "abstracts";
    const fullpaper_folder = "fullpapers";
    const blindpaper_folder = "blindpapers";
    const abstract_type = 1;
    const fullpaper_type = 2;
    const blindpaper_type = 3;
    //
    public function users()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'author_id');
    }

    public function reviewer()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'reviewer_id');
    }

    public function paper()
    {
        return $this->hasOne('App\Models\EventFullPaper', 'abstract_id', 'abstract_id');
    }
    
    public function generateTxtFormAbstractContent(){
        $content = $this->abstract;

        // file name that will be used in the download
        $fileName = "abstract.txt";

        // use headers in order to generate the download
        $headers = [
          'Content-type' => 'text/plain', 
          'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
          'Content-Length' => strlen($content)
        ];
        return ($headers);
    }

    protected $table = "event_abstract";

    protected $fillable = ["topic_id","author_id","reviewer_id","event_id","title","abstract","file","status","code","expire","created_at"];
}
