<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Countries;
use App\Models\Titles;
use App\Models\SubCategory;
use App\Models\EventAttendance;
use DB;

class WorkshopsController extends Controller
{
    public function index()
    {

        $workshopYears  = DB::table('sub_category')
                ->select('sub_category.*')
                ->where('category_id', '=', 2)
                ->orderBy('title','ASC')
                ->get();
        $eventLists = DB::table('events')
                ->select('events.*')
                ->where('category_id', '=', 2)
                ->where('publish', '=', 1)
                ->where('deleted', '=', 0)
                ->get();
      
        return view('workshops')
                ->with('workshopYears', $workshopYears)
               ->with('eventLists', $eventLists);
    }
}
