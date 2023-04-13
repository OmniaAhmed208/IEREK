<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
// Models required
use App\Models\EventTopic;
use App\Models\Events;
use Validator;
use Illuminate\Http\Response;

class ConferenceTopicsController extends Controller {

    private $view_path = "admin.events.conference.topics.";

    /**
     * Show the form for creating a new resource.
     *
     * @return Response view
     */
    public function create(Request $request) {

        // if ($request->session()->has('event_id')) {
            // load the create form
            
            
         
            return view($this->view_path . "create");
        // }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        // get event_id from session
        $event_id = $request->session()->get('event_id', null);

        $validator = $this->validateRules($request);
        if ($validator->fails()) {

            if ($request->ajax()) {
                $arr_result = array(
                    'status' => "fail",
                    'msg' => $validator->getMessageBag()->toArray()
                );
            }
            else{
                return redirect(route('createConferenceTopics'))
                    ->withErrors($validator)
                    ->withInput();
            }

        }
        else{

            $arrTopics = $request->all();

            $arrTopics["event_id"] = $event_id;

            $last_topic_position = EventTopic::where("event_id", $arrTopics["event_id"])
                ->max('position');

            $arrTopics["position"] = $last_topic_position + 1;

            // save new topic to DB
            EventTopic::create($arrTopics);

            if ($request->ajax()) {

                $arr_result = array(
                    'status' => "success",
                    'msg' => "Topic added successfully"
                );

                return response()->json($arr_result);
            }
            else{
                return redirect(route('showConferenceTopics', $event_id))->with([
                    "success" => "Topic added successfully!!"
                ]);
            }

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @return view index
     */
    public function show(Request $request, $event_id) {

        // add event id to session to be used later
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $request->session()->put('event_id', $event_id);

        $topics = EventTopic::where("event_id", $event_id)->get();

        return view($this->view_path . "show", [
            "topics" => $topics,
            "event"  => $event,
            "eid"    => $event_id
        ]);
    }


    public function edit($id) {


            $topic = EventTopic::where("topic_id", $id)->first();
            $event = Events::where("event_id", $topic["event_id"])->first();

            return view($this->view_path . "includes.edit", [
                "topic" => $topic,
                "event_id" => $topic['event_id'],
                "event" => $event
            ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  int  $event_id
     * @return Response edit view
     */
    public function order(Request $request, $event_id) {

        $event = Events::where('event_id', $event_id)->first();
        if ($request->ajax()) {
            
            $topics = EventTopic::where("event_id", $event_id)->get();

            return view($this->view_path . "includes.ajaxEdit", [
                "topics" => $topics,
                "event_id" => $event_id
            ]);

        }
        else{

            $topics = EventTopic::where("event_id", $event_id)->orderBy('position')->get();

            if (count($topics) > 0) {
                return view($this->view_path . "edit", [
                    "topics" => $topics,
                    "event_id" => $event_id,
                    "event" => $event
                ]);
            } else {
                return redirect(route("createConferenceTopics"));
            }
        }
    }

    /**
     * Update the event topic and redirect to topic list page
     *
     * @param Request $request
     * @param  int  $id
     * @return  response if ajax it returns json, otherwise it redirects to show
     */
    public function update(Request $request, $id) {
        
        $validator = $this->validateRules($request);
        $arr_topic = $request->all();

        if ($request->ajax()) {
            if ($validator->fails()) {

                $arr_result = array(
                    'status' => "fail",
                    'msg' => $validator->getMessageBag()->toArray()
                );

            }
            else {

                EventTopic::where("topic_id", $id)
                        ->update([
                            'title_en' => $arr_topic["title_en"],
                            'description_en' => $arr_topic["description_en"]
                ]);

                $arr_result = array(
                    'status' => "success",
                    'msg' => "Topic updated successfully"
                );

            }

            return response()->json($arr_result);

        }
        else {
            return redirect(route("showConferenceTopics", $arr_topic->event_id));
        }

    }

    /**
     * Remove the event topic.
     * @param  int  $topic_id
     * @return json response
     */
    public function destroy(Request $request, $topic_id) {

        // get event topic with topic_id
        $topic = EventTopic::where('topic_id', $topic_id)->first();

        EventTopic::where('topic_id', $topic_id)->delete();

        return redirect(route('showConferenceTopics', $request->event_id));
    }

    /**
     * update topic positions
     * @param Request $request
     */
    public function changePosition(Request $request){

        if ($request->ajax()) {
            $eventTopic = new EventTopic();
            $eventTopic->updatePositions($request->all()["positions"]);
        }
    }

    /**
     * Check for validation errors
     * @param $request
     * @return validator
     */
    private function validateRules($request) {
        return Validator::make($request->all(), [
                    "title_en" => "required|max:150",
        ]);
    }

}
