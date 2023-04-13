<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EventImportantDates;
use App\Models\EventImportantDate;
use App\Models\Events;
use Validator;
use Response;
use Input;
include 'functions.php';

class ConferenceDatesController extends Controller
{
    //
    // edit view for conference

    public function edit($id)
    {
        // $ConfDates = EventImportantDate::where('event_id', $id)->get();
        
        // echo $ConfDates;
        $conference = Events::where('event_id', $id)->firstOrFail();
        $sd = date("Y-m-d" ,strtotime($conference->start_date));
        $iDates = EventImportantDate::where('event_id', $id)->get();
        $s = EventImportantDates::where('id', 1)->firstOrFail();
        
      	$apply = array(
      		'submission_close' 		=> dDs($s->submission_close, $sd),
      		'submission_last' 		=> dDs($s->submission_last, $sd),
      		'full_paper_close' 		=> dDs($s->full_paper_close, $sd),
      		'full_paper_last' 		=> dDs($s->full_paper_last, $sd),
      		'early_payment' 		=> dDs($s->early_payment, $sd),
      		'regular_payment' 		=> dDs($s->regular_payment, $sd),
      		'late_payment' 			=> dDs($s->late_payment, $sd),
      		'visa_letter'			=> dDs($s->visa_letter, $sd),
      		'final_acceptance' 		=> dDs($s->final_acceptance, $sd),
      		'conference_program'	=> dDs($s->conference_program, $sd),
      		'conference_launch'		=> dDs($s->conference_launch, $sd),
      		'id'					=> $id
      	);
      	
    //   	dd($apply);
     
        return View('admin.events.conference.dates.edit')->with('apply' ,$apply)->with( array('iDates' => $iDates) );
    }

    public function update(Request $request ,$id)
    {
		$data = $request->all();
		$isExists = EventImportantDate::where('event_id', $id)->get();
		if($isExists->isEmpty()){
        createDates($data['submission_close'], 1, $data['submission_close_en'],'Abstract Submissions Deadline', $id);
        createDates($data['submission_last'], 2, $data['submission_last_en'],'Last Notification for Abstract Acceptance', $id);
        createDates($data['full_paper_close'], 3, $data['full_paper_close_en'],'Full Paper Submission Deadline', $id);
        createDates($data['full_paper_last'], 4, $data['full_paper_last_en'],'Last Notification for Full-Paper Acceptance', $id);
        createDates($data['early_payment'], 5, $data['early_payment_en'],'Early Payment Deadline', $id);
        createDates($data['regular_payment'], 6, $data['regular_payment_en'],'Regular Payment Deadline', $id);
        createDates($data['late_payment'], 7, $data['late_payment_en'],'Late Payment Deadline', $id);
        createDates($data['visa_letter'], 8, $data['visa_letter_en'], 'Letter of Visa (for delegates who need visa entry)', $id);
        createDates($data['final_acceptance'], 9, $data['final_acceptance_en'],'Letter of Final Acceptance', $id);
        createDates($data['conference_program'], 10, $data['conference_program_en'],'Conference Program', $id);
        createDates($data['conference_launch'], 11, $data['conference_launch_en'],'Conference Launch', $id);
    }else{
        updateDates($data['submission_close'], 1, $data['submission_close_en'],'Abstract Submissions Deadline', $id);
        updateDates($data['submission_last'], 2, $data['submission_last_en'],'Last Notification for Abstract Acceptance', $id);
        updateDates($data['full_paper_close'], 3, $data['full_paper_close_en'],'Full Paper Submission Deadline', $id);
        updateDates($data['full_paper_last'], 4, $data['full_paper_last_en'],'Last Notification for Full-Paper Acceptance', $id);
        updateDates($data['early_payment'], 5, $data['early_payment_en'],'Early Payment Deadline', $id);
        updateDates($data['regular_payment'], 6, $data['regular_payment_en'],'Regular Payment Deadline', $id);
        updateDates($data['late_payment'], 7, $data['late_payment_en'],'Late Payment Deadline', $id);
        updateDates($data['visa_letter'], 8, $data['visa_letter_en'], 'Letter of Visa (for delegates who need visa entry)', $id);
        updateDates($data['final_acceptance'], 9, $data['final_acceptance_en'],'Letter of Final Acceptance', $id);
        updateDates($data['conference_program'], 10, $data['conference_program_en'],'Conference Program', $id);
        updateDates($data['conference_launch'], 11, $data['conference_launch_en'],'Conference Launch', $id);
		}
		  
    	return json_encode( array('success' => true) );
    }
}
