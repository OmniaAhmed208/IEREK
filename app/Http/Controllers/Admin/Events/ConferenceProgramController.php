<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EventFees;
use App\Models\EventAttendanceType;
use App\Models\EventDateType;
use App\Models\FeesCategoryType;
use App\Models\Events;
use Validator;
use Response;

class ConferenceProgramController extends Controller
{
 public function show($event_id)
    {
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];

        return view('admin.events.conference.program.edit')->with(
            array(
            
            'event_id' => $event_id,
            'event' => $eventTitle,
            'event_currency' =>$event['currency']
            ));

    }
    
    public function edit()
    {
        echo "fffffff";
    }
}