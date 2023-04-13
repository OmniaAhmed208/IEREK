<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Response;

use App\Models\Countries;

use App\Models\Titles;

use App\Models\Users;

use App\Models\Notifications;

use App\Models\Messages;

use App\Models\Events;

use Auth;

use Session;

class GetController extends Controller
{
    //
    function element($element)
    {
    	switch ($element) {
    		case 'countries':
    			$result = Countries::where('country_id', '>', 0)->get();
    			break;
    		case 'user_title':
    			$result = Titles::where('user_title_id', '>', 0)->get();
    			break;
            case 'verified':
                if(Auth::check()){
                    $user = Users::where('user_id', Auth::user()->user_id)->first();
                    if($user['verified'] == 0)
                    {
                        $url = url('mail/re-verify/'.Auth::user()->user_id);
                        $result = '<div class="alert alert-warning"><strong>Warning!</strong>, Please verify your account, <a href="'.$url.'">Resend Verification Email</a></div>';
                    }else{
                        $result = [];
                    }
                }else{
                    $result = [];
                }
                break;
            case 'notifications':
                $result = Notifications::where('read', 0)->where('deleted', 0)->where('user_id',Auth::user()->user_id)->orderBy('created_at','DESC')->get();
                
                foreach($result as $res)
                {
                    $show = Notifications::where('notification_id',$res['notification_id'])->update(array(
                        'show' => 1
                    ));
                }
                break;
            case 'messages':
                $result = Messages::where('read', 0)->where('deleted', 0)->where('user_id',Auth::user()->user_id)->orderBy('created_at','DESC')->get();
                
                foreach($result as $res)
                {
                    $show = Messages::where('message_id',$res['message_id'])->update(array(
                        'show' => 1
                    ));
                }
                break;
    		default:
    			# code...
    			break;
    	}
    	if(count($result) > 0 && isset($result)){$msg = true;}else{$msg = false;}
        return Response(array('success' => $msg, 'result' => $result));
    }

    function calendar($year,$month){
        $dateYear = $year;
        $dateMonth = $month;
        $date = $dateYear.'-'.$dateMonth.'-01';
        $dateC = $year.'-'.$month;
        $events = Events::where('deleted', 0)->where('publish',1)->where('start_date','LIKE','%'.$dateC.'%')->get();
        // dd($events);
        $currentMonthFirstDay = date("N",strtotime($date));
        $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
        $totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
        $boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
            @$dayCount = 1;
            for(@$cb=1;@$cb<=@$boxDisplay;@$cb++){
                if((@$cb >= @$currentMonthFirstDay+1 || @$currentMonthFirstDay == 7) && @$cb <= (@$totalDaysOfMonthDisplay)){
                    //Current date
                    @$currentDate = @$dateYear.'-'.@$dateMonth.'-'.@$dayCount;
                    @$eventNum = 0;
                    @$eventTitle = '';
                    @$eventSlug = '#';
                    @$title = '';

                    foreach ($events as $e) {
                        if($e->start_date == $currentDate){
                            $eventNum = 1;
                            if($e->category_id == 1){
                                $eventTitle = '<label class="label label-success">C<label class="tohide">onference</label></label>';
                            }elseif($e->category_id == 2){
                                $eventTitle = '<label class="label label-warning">W<label class="tohide">orkshop</label></label>';
                            }elseif($e->category_id == 3){
                                $eventTitle = '<label class="label label-danger">S<label class="tohide">tudy Abroad</label></label>';
                            }
                            $title = $e->title_en;
                            $eventSlug = '/events/'.$e->slug;
                        }
                    }
                    //Define date cell color
                    if(strtotime(@$currentDate) == strtotime(date("Y-m-d"))){
                        echo '<li date="'.@$currentDate.'" class="grey date_cell">';
                    }elseif(@$eventNum > 0){
                        echo '<li date="'.@$currentDate.'" class="light_sky date_cell">';
                    }else{
                        echo '<li date="'.@$currentDate.'" class="date_cell">';
                    }
                    //Date cell
                    echo '<span>';
                    echo @$dayCount;
                    echo '</span>';
                    
                    //Hover event popup
                    echo '<div>';
                    echo '<a href="'.$eventSlug.'" title="'.$title.'"  data-placement="left" data-toggle="tooltip">'.$eventTitle.'</a>';
                    echo '</div>';
                    
                    echo '</li>';
                    @$dayCount++;
        }else{
            echo '<li class="date_cell empty"><span>&nbsp;</span></li>';
        } }
    }
}
