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

class StudiesFeesController extends Controller
{
    //
    public function show($event_id)
    {
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
    	$fees = EventFees::where('event_id', $event_id)->where('deleted','=', 0)->get();

        return view('admin.events.studies.fees.show')->with(
            array(
            'fees' => $fees, 
            'event_id' => $event_id,
            'event' => $eventTitle,
            'event_currency' =>$event['currency']
            ));

    }

    public function filter($event_id, $deleted)
    {
        $event = Events::where('event_id', $event_id)->first();
        $eventTitle = $event['title_en'];
        switch($deleted)
        {
            case "active-only";
                $fees = EventFees::where('deleted', '=', 0)->where('event_id', $event_id)->get();
                return View('admin.events.studies.fees.show')->with(array('fees' => $fees) )->with('select','active-only')->with('event_id', $event_id)->with(
            'event_currency', $event['currency'])->with(array(
            'event' => $eventTitle
            ));
            break;
            case "inactive-only";
                $fees = EventFees::where('deleted', '=', 1)->where('event_id', $event_id)->get();
                return View('admin.events.studies.fees.show')->with(array('fees' => $fees) )->with('select','inactive-only')->with('event_id', $event_id)->with(
            'event_currency', $event['currency'])->with(array(
            'event' => $eventTitle
            ));
            break;
            case "all";
                $fees = EventFees::where('event_id', $event_id)->get();
                return View('admin.events.studies.fees.show')->with(array('fees' => $fees) )->with('select','all')->with('event_id', $event_id)->with(
            'event_currency', $event['currency'])->with(array(
            'event' => $eventTitle
            ));
            break;
        }
    }

    public function create($event_id)
    {
    	$for = EventAttendanceType::all();
        $condition = EventDateType::whereBetween('event_date_type_id',array(5,7) )->get();
        $category = FeesCategoryType::all();
        $fees = EventFees::where('event_id', $event_id)->where('deleted','=', 0)->get();
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        return view('admin.events.studies.fees.create')->with(
            array(
            'for' => $for, 
            'condition' => $condition, 
            'category' => $category, 
            'event_id' => $event_id,
            'fees' => $fees,
            'event' => $eventTitle,
            'event_currency' =>$event['currency']
            ));
    }

    public function edit($id)
    {
        $fees = EventFees::where('event_fees_id', $id)->firstOrFail();
        $event_id = $fees['event_id'];
        $for = EventAttendanceType::all();
        $condition = EventDateType::whereBetween('event_date_type_id',array(5,7) )->get();
        $category = FeesCategoryType::all();
        $feex = EventFees::where('event_id', $event_id)->where('deleted','=', 0)->get();
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        return view('admin.events.studies.fees.edit')->with(
            array(
                'fee' => $fees,
                'for' => $for, 
                'condition' => $condition, 
                'category' => $category, 
                'event_id' => $event_id,
                'fees' => $feex, 
                'event' => $eventTitle,
                'event_currency' =>$event['currency']
                ));
    }

    public function store(Request $request, $event_id)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            'title_en' => 'required|max:255',
            'amount' => 'required'
        ]);

        // return validation errors if exist
        if ($validator->fails())
        {
            $dd = array(
                'success' => false,
                'errs' => $validator->getMessageBag()->toArray()
            );

            echo json_encode($dd);
        }
        else
        {
            //new Studies Fees
            // Store the new studies fees data...
            $id = EventFees::create(array(
                'title_en' => $data['title_en'],
                'event_id' => $event_id,
                'event_date_type_id' => $data['event_date_type_id'],
                'event_attendance_type_id' => $data['event_attendance_type_id'],
                'fees_category_id' => $data['fees_category_id'],
                'amount' => $data['amount'],
                'currency' => $data['currency']
            ));

            if($id)
            {
                return Response::json($id);
            }
        }

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            'title_en' => 'required|max:255',
            'amount' => 'required'
        ]);

        // return validation errors if exist
        if ($validator->fails())
        {
            $dd = array(
                'success' => false,
                'errs' => $validator->getMessageBag()->toArray()
            );

            echo json_encode($dd);
        }
        else
        {
            //Update Studies Fees
            // Update the studies fees data...
            $idu = EventFees::where('event_fees_id', $id)->update(array(
                'title_en' => $data['title_en'],
                'event_date_type_id' => $data['event_date_type_id'],
                'event_attendance_type_id' => $data['event_attendance_type_id'],
                'fees_category_id' => $data['fees_category_id'],
                'amount' => $data['amount'],
                'currency' => $data['currency']
            ));

            if($idu)
            {
                return Response::json($idu);
            }
        }
    }

    public function destroy($id)
    {
        $delete = EventFees::where('event_fees_id', $id)->update(array(
                'deleted' => 1,
                ));
    }

    public function restore($id)
    {
        $delete = EventFees::where('event_fees_id', $id)->update(array(
                'deleted' => 0,
                ));
    }
}
