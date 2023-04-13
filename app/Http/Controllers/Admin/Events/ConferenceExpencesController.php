<?php

namespace App\Http\Controllers\Admin\Events;

use App\Http\Controllers\Controller;

use App\Models\EventExpenses;

use App\Models\Events;

use Illuminate\Http\Request;

use App\Models\Notifications;

use Auth;

class ConferenceExpencesController extends Controller
{
    public function show($event_id)
    { 
       $event = Events::where('event_id', $event_id)->firstOrFail();
       $event_expenses = EventExpenses::where('event_id', '=', $event_id)
               ->with('event')
               ->get();
        
        return View('admin.events.conference.expences.show')->with(array(
            'expenses' => $event_expenses,
            'event_id' => $event_id,
            'event_currency' =>$event['currency']
        ));
        
    }
    
    public function create($event_id)
    {
        $event_expenses = EventExpenses::where('event_id', '=', $event_id)
               ->with('event')
               ->get();
        $event = Events::where('event_id', $event_id)->firstOrFail();
        return View('admin.events.conference.expences.create')->with(array(
            'event_id' => $event_id,
            'event_currency' =>$event['currency'],
            'expenses' => $event_expenses
        ));
    }
    
    public function store(Request $request)
    {
        //dd("in store");
              
     $this->validate($request, [
        'title' => 'required',
        'event_id' => 'required',
        'amount' => 'required|Integer',
        'currency' => 'required'
     ]);
     
      EventExpenses::create(array(
                        "event_id"=> $request['event_id'],
                        "title"=> $request['title'],
                        "amount"=> $request['amount'],
                        "currency" => $request['currency'],
                        "status" => "approved",
                    ));

                    
                    
        Notifications::create(array(
                      'title' => 'Payment Done',
                      'description' => 'The Expenses of event was done successfully.',
                      'user_id' => Auth::user()->user_id,
                      'color' => 'green',
                      'type' => 'payment-Done',
                      'icon' => 'dollar',
                      'timeout' => 25000,
                      'url' => '/billing',
                      'status' => 'info'
                ));
       
       

                 return redirect(route('showConferenceExpences',$request['event_id']));
                 
    }
    
    
}