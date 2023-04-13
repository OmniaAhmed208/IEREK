<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EventSCommittee;
use App\Models\Users;
use App\Models\Events;

class ConferenceSCommitteeController extends Controller
{
    //
        public function show($id)
    {
        $event = Events::where('event_id', $id)->firstOrFail();
        $eSCommittees = EventSCommittee::where('event_id', $id)->get();
        $eSCommitteeIds = array('0','1');
        foreach($eSCommittees as $eSCommittee){
            array_push($eSCommitteeIds, $eSCommittee['user_id']);
        }
        $uSCommittees = Users::where('user_type_id', 1)->whereNotIn('user_id', $eSCommitteeIds)->orderBy('first_name','ASC')->where('deleted', 0)->get();
        return view('admin.events.conference.scommittee.show')->with(array('eSCommittees' => $eSCommittees, 'uSCommittees' => $uSCommittees, 'event' => $event));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);

        if(!empty($data['confArray'])){
            $eSCommittees = array_filter(array_map('trim',explode(",",$data['confArray'])));
            foreach($eSCommittees as $eSCommittee)
            {
                $check = EventSCommittee::where('event_id', $id)->where('user_id', $eSCommittee)->first();
                if($check === null){
                    $add = EventSCommittee::create(array('event_id' => $id, 'user_id' => $eSCommittee));
                }
            }
        }

        if(!empty($data['confDelArray'])){
            $delSCommittees = array_filter(array_map('trim',explode(",",$data['confDelArray'])));
            foreach($delSCommittees as $delSCommittee)
            {
                $check = EventSCommittee::where('event_id', $id)->where('user_id', $delSCommittee)->first();
                if($check){
                    $delete = EventSCommittee::where('event_id', $id)->where('user_id', $delSCommittee)->delete();
                }
                $delete = EventSCommittee::where('event_id', $id)->where('user_id', 0)->delete();
            }
        }

        return redirect(route('showConferenceSCommittee', $id));
    }
}
