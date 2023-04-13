<?php

namespace App\Http\Controllers;

use App\Models\EventAbstract;
use App\Models\EventFullPaper;
use App\Models\EventFullPaperHistory;
use App\Models\Events;
use App\Models\EventSponsors;
use App\Models\EventSpeakers;
use Auth;
use Illuminate\Support\Facades\Response;

class FileController extends Controller {

    public function getFile($type, $id) {
        $reviewer = 0;
        $dir = EventAbstract::upload_dir;
        
        if ($type == EventAbstract::abstract_type) {
            
            $subDir = EventAbstract::abstract_folder;
            $file = EventAbstract::where('abstract_id', $id)->first();
            $filePath =  $file->file;
            if($filePath == "No File"){
                $headers = $file->generateTxtFormAbstractContent();

                // make a response, with the content, a 200 response code and the headers
                return Response::make($file->abstract, 200, $headers);
            }
        } 
        
        elseif ($type == EventAbstract::fullpaper_type) {
            
            $subDir = EventAbstract::fullpaper_folder;
            $file = EventFullPaper::where('paper_id', $id)->first();
            $filePath = $file->file;
        }
        
        elseif ($type == EventAbstract::blindpaper_type) {
            $subDir = EventAbstract::blindpaper_folder;
            $file = EventFullPaper::where('paper_id', $id)->first();
            $reviewer = EventFullPaperHistory::where('paper_id', $id)->first();
            $filePath = $file->file;
        }
        
        elseif ($type == Events::sponsors_logo_type){
            $subDir = Events::conf_folder;
            $sponserDir = Events::sponsors_folder;
            $file = EventSponsors::where('event_sponsor_sid', $id)->first();
            $filePath =  $sponserDir. "/". $file->img;
        }
        
        elseif ($type == Events::speakers_img_type){
            $subDir = Events::conf_folder;
            $speakersDir = Events::speakers_image_folder;
            $file = EventSpeakers::where('event_speaker_sid', $id)->first();
            $filePath =  $speakersDir. "/". $file->img;
        }
        elseif ($type == Events::speakers_cv_type){
            $subDir = Events::conf_folder;
            $speakersDir = Events::speakers_cv_folder;
            $file = EventSpeakers::where('event_speaker_sid', $id)->first();
            $filePath =  $speakersDir. "/". $file->cv;
        }

        if (Auth::user()->user_id == $file->auther_id ||
                Auth::user()->user_type_id >= \App\Models\UserType::conf_admin ||Auth::user()->user_id == $reviewer->reviewer_id) {
//dd($dir . "/" . $subDir . "/" . $file->event_id . "/" . $filePath);
            return response()->download(
                            storage_path($dir . "/" . $subDir . "/" . $file->event_id . "/" . $filePath
                            ), null, [], null);
        } 
        
        else {
            abort(404);
        }
    }

}
