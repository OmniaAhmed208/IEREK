<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
// Required Models
use App\Models\EventSection;
use App\Models\SectionType;
use App\Models\Events;

use Validator;
use Illuminate\Http\Response;
use Session;

class SectionController extends Controller {

    private $view_path = "admin.events.section.";

    /**
     * Show the form for creating a new resource.
     *
     * @return Response view
     */
     
     
     
    public function create(Request $request) {
        
      
        $event = Events::where('event_id', Session::get('event_id'))->first();
        if ($request->session()->has('event_id')) {
  
            $sectionType = new SectionType();

            $allSectionTypes = $sectionType->getAllSectionTypes();

            $arrSectionTypes = array();

            foreach ($allSectionTypes as $key => $allSectionType){
                $arrSectionTypes[$allSectionType->section_type_id] = $allSectionType->title;
//                $newSectionTypes[$key]["title"] = $arrSectionType->title;
            }
//            var_dump($newSectionTypes);
            // load the create form
//            return view($this->view_path . "create");

            return view($this->view_path . "create", [
                "arrSectionTypes" => $arrSectionTypes,
                "event" => $event
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
     
     
     
    public function store(Request $request) {

//        die(var_dump($request->all()));
        // get event_id from session
        $event_id = $request->session()->get('event_id', null);

        $validator = $this->validateRules($request);
        if ($validator->fails()) {

            if ($request->ajax()) {
                return array(
                    'status' => "fail",
                    'msg' => $validator->getMessageBag()->toArray()
                );
            }
            else{
                return redirect(route('createSection'))
                    ->withErrors($validator)
                    ->withInput();
            }

        }
        else{

            $arrSections = $request->all();

            $arrSections["event_id"] = $event_id;

            $last_section_position = EventSection::where("event_id", $arrSections["event_id"])
                ->max('position');

            $arrSections["position"] = $last_section_position + 1;

            // save new section to DB
            EventSection::create($arrSections);

            if ($request->ajax()) {

                return array(
                    'status' => "success",
                    'msg' => "Section added successfully"
                );

                return response()->json($arr_result);
            }
            else{
                return redirect(route('showSection', $event_id))->with([
                    "success" => "Section added successfully!!"
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
        $request->session()->put('event_id', $event_id);
        $event = Events::where('event_id', $event_id)->first();

        $sections = EventSection::where("event_id", $event_id)->get();

        return view($this->view_path . "show", [
            "sections" => $sections,
            "event" => $event
        ]);
    }




    public function edit($id) {
        
        
        
       
        $sectionType = new SectionType();

        $allSectionTypes = $sectionType->getAllSectionTypes();

        $arrSectionTypes = array();

        foreach ($allSectionTypes as $key => $allSectionType){
            $arrSectionTypes[$allSectionType->section_type_id] = $allSectionType->title;
//                $newSectionTypes[$key]["title"] = $arrSectionType->title;
        }
        $section = EventSection::where('section_id', $id)->first();
        $event = Events::where('event_id', $section['event_id'])->first();
        
        
        if(date('Y', strtotime($event['start_date'])) >= 2021)
        {
                       return view('admin.events.section.includes.oldedit')->with(array('section' => $section, 'arrSectionTypes' => $arrSectionTypes, 'event' => $event)); // last desion    

         //return view('admin.events.section.includes.edit')->with(array('section' => $section, 'arrSectionTypes' => $arrSectionTypes, 'event' => $event));  //new  desion   
        }
        
        else 
            {
               return view('admin.events.section.includes.oldedit')->with(array('section' => $section, 'arrSectionTypes' => $arrSectionTypes, 'event' => $event));
            }
        
        }
        
        

    public function update(Request $request, $id) {
        
         $validator = $this->validateRules($request);

         if($request["description_en"])
         {
           EventSection::where("section_id", $id)
                ->update([
                    'section_type_id' => $request["section_type_id"],
                    'title_en' => $request["title_en"],
                    'description_en' => $request["description_en"]
           ]);
         }
         
         else
         {
  
            if($request["section_type_id"] == 11)
            {
                $description_en = $request["intro"]."&$#and#$&".$request["partner_units"]."&$#and#$&".$request["venue"]."&$#and#$&".$request["activities"];
            }
            
            else if($request["section_type_id"] == 12)
            {
                $description_en = $request["visa"]."&$#and#$&".$request["refund_policy"]."&$#and#$&".$request["fees"];
            }
            
             else if($request["section_type_id"] == 13)
            {
                $description_en = $request["speakers"]."&$#and#$&".$request["advisory_abroad"];
            }
            
             else if($request["section_type_id"] == 14)
            {
                $description_en = $request["author_instructions"]."&$#and#$&".$request["participation_procedures"]."&$#and#$&".$request["plagiarism_policy"]."&$#and#$&".$request["publishing"]."&$#and#$&".$request["english_editing"];
            }
            else if($request["section_type_id"] == 15)
            {
               $description_en = $request["conference_program"]."&$#and#$&"; 
            }
            
        EventSection::where("section_id", $id)
                ->update([
                    'section_type_id' => $request["section_type_id"],
                    'title_en' => $request["title_en"],
                    'description_en' => $description_en
        ]);
         }
        $arr_result = array(
            'status' => "success",
            'msg' => "Section updated successfully",
            'content' => $request->all()
        );

        return response()->json($arr_result);

    }
    
    
    
    
    
    
    
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  int  $event_id
     * @return Response edit view
     */
    public function order(Request $request, $event_id) {
        // get all sections ordered by position
        $event = Events::where('event_id', $event_id)->first();
        $sections = EventSection::where("event_id", $event_id)
            ->orderBy("position")
            ->get();

            if (count($sections) > 0) {
                return view($this->view_path . "edit", [
                    "sections" => $sections,
                    "event_id" => $event_id,
                    "event" => $event
                ]);
            } else {
                return redirect(route("createSection"));
            }
    }

    /**
     * Update the event section and redirect to section list page
     *
     * @param Request $request
     * @param  int  $id
     * @return  response if ajax it returns json, otherwise it redirects to show
     */

    /**
     * Remove the event section.
     * @param  int  $section_id
     * @return json response
     */
    public function destroy(Request $request, $section_id) {

        // get event section with section_id
        $section = EventSection::where('section_id', $section_id)->first();

        if ($section && $request->ajax()) {

            EventSection::where('section_id', $section_id)->delete();

            return response(['msg' => 'Section deleted successfully', 'status' => 'success']);
        }
        return response(['msg' => 'Failed to delete the section', 'status' => 'failed']);
    }

    /**
     * update section positions
     * @param Request $request
     */
    public function changePosition(Request $request){

        if ($request->ajax()) {
            $EventSection = new EventSection();
            $EventSection->updatePositions($request->all()["positions"]);
        }
    }

    /**
     * Check for validation errors
     * @param $request
     * @return validator
     */
    private function validateRules($request) {

        $rules = array(
            "title_en" => "required|max:150",
            "section_type_id" => "required"
        );

        $messages = array(
            'section_type_id.required' => 'Please select section type!',
            'title_en.required' => 'Please enter the english title!',
            'title_ar.required' => 'Please enter the arabic title!',
        );

        return Validator::make($request->all(), $rules, $messages);
    }

}
