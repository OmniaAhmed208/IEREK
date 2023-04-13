<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EventAdmins;
use App\Models\Users;
use App\Models\Events;

class StudyabroadAdminsController extends Controller
{
    //
    public function show($id)
    {
        $event = Events::where('event_id', $id)->firstOrFail();
        $eAdmins = EventAdmins::where('event_id', $id)->get();
        $eAdminsIds = array('0','1','4');
        foreach($eAdmins as $eAdmin){
            array_push($eAdminsIds, $eAdmin['user_id']);
        }
        $uAdmins = Users::whereIn('user_type_id', [2,3])->whereNotIn('user_id', $eAdminsIds)->where('deleted', 0)->get();
        return view('admin.events.studyabroad.admins.show')->with(array('eAdmins' => $eAdmins, 'uAdmins' => $uAdmins, 'event' => $event));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        if(!empty($data['confArray'])){
            $eAdmins = array_filter(array_map('trim',explode(",",$data['confArray'])));
            foreach($eAdmins as $eAdmin)
            {
                $check = EventAdmins::where('event_id', $id)->where('user_id', $eAdmin)->first();
                if($check === null){
                    $add = EventAdmins::create(array('event_id' => $id, 'user_id' => $eAdmin));
                }
            }
        }
        if(!empty($data['confDelArray'])){
            $delAdmins = array_filter(array_map('trim',explode(",",$data['confDelArray'])));
            foreach($delAdmins as $delAdmin)
            {
                $check = EventAdmins::where('event_id', $id)->where('user_id', $delAdmin)->first();
                if($check){
                    $delete = EventAdmins::where('event_id', $id)->where('user_id', $delAdmin)->delete();
                }
                $delete = EventAdmins::where('event_id', $id)->where('user_id', 0)->delete();
            }
        }

        return redirect(route('showStudyabroadAdmins', $id));
    }
}
