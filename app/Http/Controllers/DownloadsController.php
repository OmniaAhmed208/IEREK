<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DownloadsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('user');
    }

    

    public function comment($event_id, $filename)
    {
    	# code...
    	return redirect('storage/uploads/fullpapers/'.$event_id.'/'.'comments/'.$filename);
    }
}
