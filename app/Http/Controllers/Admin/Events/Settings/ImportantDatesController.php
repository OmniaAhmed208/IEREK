<?php

namespace App\Http\Controllers\Admin\Events\Settings;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EventImportantDates;
use Validator;

class ImportantDatesController extends Controller
{
    //
    public function index()
    {
    	$importantDatesSettings = EventImportantDates::where('id', 1)->firstOrFail();
    	return View('admin.events.settings.important_dates.index')->with(array('settings' => $importantDatesSettings));
    }

    public function update(Request $request, $id)
    {
    	date_default_timezone_set('Egypt');
    	$data = $request->all();
    	$update = EventImportantDates::where('id', $id)->update(array(
                'submission_close' 		=> $data['submission_close'],
                'submission_last' 		=> $data['submission_last'],
                'full_paper_close' 		=> $data['full_paper_close'],
                'full_paper_last' 		=> $data['full_paper_last'],
                'early_payment' 		=> $data['early_payment'],
                'regular_payment' 		=> $data['regular_payment'],
                'late_payment' 			=> $data['late_payment'],
                'visa_letter' 			=> $data['visa_letter'],
                'final_acceptance' 		=> $data['final_acceptance'],
                'conference_program' 	=> $data['conference_program'],
                'conference_launch' 	=> $data['conference_launch'],
                'updated_at'			=> date("Y-m-d h-i:s")
        ));

    	return $update;

    }
}
