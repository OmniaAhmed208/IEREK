<?php

namespace App\Http\Controllers\Api\Event\Studyabroad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\EventFees;
use App\Models\EventTopic;
use App\Models\EventSection;
use App\Models\EventWidgets;
use App\Models\EventImportantDate;
use App\Models\EventAttendance;
use App\Models\EventSCommittee;
use App\Models\SubCategory;
use App\Models\Users;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class StudyabroadsController extends Controller
{
    //
    public function index()
    {
        $years = SubCategory::where('category_id',3)->orderBy('title', 'ASC')->get(['title','sub_category_id']);
        $all_studyabroads = [];
        foreach($years as $y){
            $count = 0;
            $studyabroads = Events::where('publish',1)->where('deleted',0)->where('sub_category_id',$y->sub_category_id)->orderBy('start_date','ASC')->get(['event_id','title_en','location_en','start_date','end_date']);
            $yc = [];
            $yc['upcomming'] = [];
            $yc['overview'] = [];
            foreach($studyabroads as $co) {
                $c = [];
                $c['event_id'] = $co->event_id;
                $c['title'] = $co->title_en;
                $c['location'] = $co->location_en;
                $c['image'] = url('/storage/uploads/studyabroads/'.$co->event_id.'/cover_img.jpg');
                $c['dates'] = date("d M", strtotime($co->start_date)).' / '.date("d M Y", strtotime($co->end_date));
                if($co->start_date >= date('Y-m-d')){ 
                    array_push($yc['upcomming'], $c);
                } else {
                    array_push($yc['overview'], $c);
                }
                $count++;
                
            }
            if($count == 0){
                unset($all_studyabroads[$y->title]);
            } else {
                $all_studyabroads[$y->title] = $yc;
            }
            
        }
        return response()->json($all_studyabroads);
    }

    public function show($event_id)
    {
        $event_base = Events::where('event_id', $event_id)->where('category_id',3)->where('publish',1)->where('deleted',0)->first([
            'title_en','start_date','end_date','location_en','email','cover_img','featured_img']);
        
        if($event_base != null){    
            $event_base['title'] = $event_base['title_en']; unset($event_base['title_en']);
            $event_base['image'] = url('/storage/uploads/studyabroads/'.$event_id.'/cover_img.jpg');
            unset($event_base['cover_img']);
            unset($event_base['featured_img']);
            $event_base['location'] = $event_base['location_en']; unset($event_base['location_en']);
            $dates = date("d M", strtotime($event_base['start_date'])).' / '.date("d M Y", strtotime($event_base['end_date']));
            $event_base['event_dates'] = $dates;
            $event_base['call'] = 'IEREK Study Abroad';
            $event_base['authenticated'] = false;
            $event_base['registered'] = 0;
            $event_base['payment'] = 0;

            // this will set the token on the object
            try{
                $user = JWTAuth::parseToken()->authenticate(); 
                if(auth()->check()){ 
                    $event_base['authenticated'] = true;
                    $user_id = auth()->user()->user_id;
                    $isreg = EventAttendance::where("event_id", $event_id)->where("user_id", $user_id)->where('unregistered', 0)->first();   
                    if(count($isreg) > 0){ $event_base['registered'] = 1; $event_base['payment'] = $isreg['payment']; }
                }
            } catch(JWTException $e) {
                $event_base['authenticated'] = false;
            }

            $get_sections = EventSection::where('event_id', $event_id)->orderBy('position')->get(['title_en','description_en','section_type_id']);
            $fees = EventFees::where('event_id', $event_id)->orderBy('fees_category_id','ASC')->orderBy('event_attendance_type_id','ASC')->orderBy('event_date_type_id','ASC')->get();


            // Proccess Fees
            $all_fees = [];
            foreach($fees as $fee){
                $fees_row = [$fee->title_en, $fee->currency.' '.$fee->amount];
                array_push($all_fees, $fees_row);
            }
            $fees_table = $this->totable(array('Fee','Amount'), $all_fees);


            // Proccess Sections
            $sections = [];
            foreach ($get_sections as $gs) {
                $s = [
                'title'         => $gs['title_en'],
                'description' => ''
                ];
                switch ($gs['section_type_id']) {
                    case 3:
                        $s['description'] = $gs['description_en'].$fees_table;
                        break;
                    
                    default:
                        $s['description'] = $gs['description_en'];
                        break;
                }
                array_push($sections, $s);
            }


            $event['details'] = $event_base;
            $event['sections'] = $sections;

            return response()->json($event, 200);
        } else {
            return response()->json(['error' => 'No data available'], 400);
        }
    }

    public function register($event_id){
        $user_id = auth()->user()->user_id;
        $check = EventAttendance::where("event_id", $event_id)->where("user_id", $user_id)->first();
        $event = Events::where('event_id', $event_id)->first();
        if(count($check) > 0){
           $register = EventAttendance::where('event_attendance_id', $check->event_attendance_id)->update(array('unregistered' => 0));
        }else{
            $register = EventAttendance::create(array(
                "event_id"                  => $event_id,
                "user_id"                   => $user_id,
                "event_attendance_type_id"  => 1
            ));
        }
        $user = Users::where('user_id', $user_id)->first();
        if($event['category_id'] == 1){$template = 2;}elseif ($event['category_id'] == 2) {$template = 3;}elseif ($event['category_id'] == 3) {$template = 4;}
        $mail = curl_init(url('mail_send?event='.$event_id.'&abstract=&paper=&template='.$template.'&user_id='.auth()->user()->user_id));
        curl_exec($mail);

        return response()->json(['message' => 'Registered in event successfully'], 200);
    }

    public function unregister($event_id)
    {
        $user_id = auth()->user()->user_id;
        $unregistered = EventAttendance::where('user_id', $user_id)->where('event_id', $event_id)->update(array(
            'unregistered' => 1,
            'postpone'     => NULL
        ));
        return response()->json(['message' => 'Unregistered from event'], 200);
    }

    private function totable(array $head,$body)
    {
        $cols = count($head);
        $header = '';
        $rows = '';
        for($i = 0; $i < $cols; $i++){
            $header = $header.'<th>'.$head[$i].'</th>';
        }
        foreach($body as $row_cols){
            $row = '';
            for($i = 0; $i < $cols; $i++){
                $row = $row.'<td>'.$row_cols[$i].'</td>';
            }
            $rows = $rows.'<tr>'.$row.'</tr>';
        }
        $table = '<div style="width:100vw;overflow-x:auto">'.
                    '<table style="width:100%">'.
                        '<tr>'.
                            $header.
                        '</tr>'.
                        $rows.
                    '</table>'.
                 '</div>';
        return $table;
    }
}
