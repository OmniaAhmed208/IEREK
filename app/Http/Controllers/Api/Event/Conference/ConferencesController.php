<?php

namespace App\Http\Controllers\Api\Event\Conference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\SubCategory;
use App\Models\EventFees;
use App\Models\EventTopic;
use App\Models\EventSection;
use App\Models\EventWidgets;
use App\Models\EventImportantDate;
use App\Models\EventAttendance;
use App\Models\EventSCommittee;
use App\Models\Users;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ConferencesController extends Controller
{
    //
    public function index()
    {
    	$years = SubCategory::where('category_id',1)->orderBy('title', 'ASC')->get(['title','sub_category_id']);
    	$all_conferences = [];
    	foreach($years as $y){
            $count = 0;
    		$conferences = Events::where('publish',1)->where('deleted',0)->where('sub_category_id',$y->sub_category_id)->orderBy('start_date','ASC')->get(['event_id','title_en','location_en','start_date','end_date']);
    		$yc = [];
            $yc['upcomming'] = [];
            $yc['overview'] = [];
    		foreach($conferences as $co) {
    			$c = [];
    			$c['event_id'] = $co->event_id;
    			$c['title'] = $co->title_en;
    			$c['location'] = $co->location_en;
    			$c['image'] = url('/storage/uploads/conferences/'.$co->event_id.'/list_img.jpg');
    			$c['dates'] = date("d M", strtotime($co->start_date)).' / '.date("d M Y", strtotime($co->end_date));
    			if($co->start_date >= date('Y-m-d')){ 
    				array_push($yc['upcomming'], $c);
    			} else {
    			 	array_push($yc['overview'], $c);
    			}
                $count++;
    			
    		}
            if($count == 0){
                unset($all_conferences[$y->title]);
            } else {
                $all_conferences[$y->title] = $yc;
            }
    	}
    	return response()->json($all_conferences);
    }

    public function show($event_id)
    {
        $event_base = Events::where('event_id', $event_id)->where('category_id',1)->where('publish',1)->where('deleted',0)->first([
            'title_en','start_date','end_date','location_en','email','cover_img','featured_img']);
        
        if($event_base != null){
            $event_base['title'] = $event_base['title_en']; unset($event_base['title_en']);
            $event_base['image'] = url('/storage/uploads/conferences/'.$event_id.'/cover_img.jpg');
            unset($event_base['cover_img']);
            $event_base['publication_image'] = url('/storage/uploads/conferences/'.$event_id.'/featured_img.jpg');
            unset($event_base['featured_img']);
            $event_base['location'] = $event_base['location_en']; unset($event_base['location_en']);
            $dates = date("d M", strtotime($event_base['start_date'])).' / '.date("d M Y", strtotime($event_base['end_date']));
            $event_base['event_dates'] = $dates;
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
            $get_topics = EventTopic::where('event_id', $event_id)->orderBy('position')->get();
            $fees = EventFees::where('event_id', $event_id)->orderBy('fees_category_id','ASC')->orderBy('event_attendance_type_id','ASC')->orderBy('event_date_type_id','ASC')->get();
            $dates = EventImportantDate::where('event_id', $event_id)->orderBy('to_date')->get();
            $get_widgets = EventWidgets::where('event_id', $event_id)->where('deleted',0)->orderBy('position')->get(['widget_title','widget_description','img','img_url']);


            // Proccess Widgets
            $widgets = [];
            if(count($get_widgets) > 0){
                foreach ($get_widgets as $w) {
                    $p_w['title']       = $w['widget_title'];
                    $p_w['description'] = $w['widget_description'];
                    $p_w['image']       = url('/storage/uploads/conferences/'.$event_id.'/widgets/'.$w['img']);
                    $p_w['url']         = !empty($w['img_url']) ? $w['img_url'] : null ;
                    array_push($widgets, $p_w);
                }
            }

            // Proccess Topics
            $topics = '';
            foreach ($get_topics as $t) {
                $topics = $topics.$t['title_en'].$t['description_en'];
            }

            // Proccess Dates
            $all_dates = [];
            foreach($dates as $date){
                $dates_row = [$date->title, $date->currency.' '.$date->to_date];
                array_push($all_dates, $dates_row);
            }
            $dates_table = $this->totable(array('Title','Date'), $all_dates);        

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
                    case 2:
                        $s['description'] = $gs['description_en'].$topics;
                        break;
                    case 3:
                        $s['description'] = $gs['description_en'].$fees_table;
                        break;
                    case 6:
                        $s['description'] = $gs['description'].$dates_table;
                        break;
                    
                    default:
                        $s['description'] = $gs['description_en'];
                        break;
                }
                array_push($sections, $s);
            }

            $iDates = EventImportantDate::where('event_id',$event_id)->get();
            $aIDates = [];
            if(count($iDates) > 0){
                $idate = 1;
                foreach($iDates as $date){
                    $aIDates[$date['event_date_type_id']] = date('Y-m-d', strtotime($date['to_date']));
                }
            }else{
                $idate = 0;
            }

            // Conference Call
            $sd = $event_base['start_date']; $ed = $event_base['end_date']; $cd = date('Y-m-d'); $call = ''; $abst = 0; $ced = ''; $cp = 1; $rp_closed = ''; $sp_closed = ''; $lp_closed = '';
            if($cd > @$iDates[5]) {
                 $rp_closed = 'style="text-decoration: line-through;color:red"';
            }
            if($cd > @$iDates[6]) {
                 $sp_closed = 'style="text-decoration: line-through;color:red"';
            }
            if($cd > @$iDates[7]) {
                 $lp_closed = 'style="text-decoration: line-through;color:red"';
            }
            if($idate == 1){
                if($cd < @$iDates[2]) {
                     $abst = 1; 
                }
                if($cd < @$iDates[1]) {
                     $call = 'Call For Abstract'; $ced = @$cd;
                } elseif ($cd > @$iDates[1] && $cd < @$iDates[2]) {
                     $call = 'Last Call For Abstract'; $ced = @$iDates[1];
                } elseif ($cd > @$iDates[2] && $cd < @$iDates[3]) {
                     $call = 'Call For Paper'; $ced = @$iDates[2];
                } elseif ($cd > @$iDates[3] && $cd < @$iDates[4]) {
                     $call = 'Last Call For Paper'; $ced = @$iDates[3];
                } elseif ($cd > @$iDates[4] && $cd < @$iDates[5]) {
                     $call = 'Early Payment'; $ced = @$iDates[4];
                } elseif ($cd > @$iDates[5] && $cd < @$iDates[6]) {
                     $call = 'Payment Open'; $ced = @$iDates[5];
                } elseif ($cd > @$iDates[6] && $cd < @$iDates[7]) {
                     $call = 'Late Payment'; $ced = @$iDates[6];
                } elseif ($cd > @$iDates[7] && $cd < @$iDates[8]) {
                     $call = 'Registration Closed'; $ced = @$iDates[7];
                } elseif ($cd > @$iDates[8] && $cd < @$iDates[9]) {
                     $call = 'Conference Program is Comming Soon'; $ced = @$iDates[8];
                } elseif ($cd > @$iDates[9] && $cd < @$iDates[10]) {
                     $call = 'Conference Program Released';  $ced = @$iDates[9];
                } elseif ($cd > @$iDates[10] && $cd < @$iDates[11]) {
                if($cd > @$iDates[7]) {
                     $cp = 0;
                }
                    
                $ced = @$iDates[10];
                function dateDiff($d1,$d2){
                    $date1 = new DateTime($d1);
                    $date2 = new DateTime($d2);

                    
                    $interval = $date1->diff($date2);
                    // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 

                    // shows the total amount of days (not divided into years, months and days like above)
                    return $interval->days;
                }
                $call = dateDiff($cd,$sd).' Days To Launch';
                } elseif ($cd > $sd && $cd < $ed) {
                     $call = 'Conference Has Started';
                } elseif ($cd > $ed) {
                     $call = 'Conference Overview';
                } elseif ($cd > $iDates[8]) {
                     $call = 'Registeration Is Open';
                } else {
                     $call = 'IEREK Conference';
                }
            } else {
                 $call = 'IEREK Conference';
            }
            if(date('Y-m-d') > $event_base['end_date'] || $event_base['overview'] == 1){
                 $call = 'Conference Overview';
            } 

            $event_base['call'] = $call;
            $event['details'] = $event_base;
            $event['sections'] = $sections;
            $event['widgets'] = $widgets;

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
