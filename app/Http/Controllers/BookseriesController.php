<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Countries;
use App\Models\Titles;
use App\Models\SubCategory;
use App\Models\EventAttendance;
use App\Models\StaticPages;
use DB;

class BookseriesController extends Controller
{
    public function index()
    {

        $bookseriesYears  = DB::table('sub_category')
                ->select('sub_category.*')
                ->where('category_id', '=', 4)
                ->where('deleted', '=', 0)
                ->orderBy('title','ASC')
                ->get();
        $eventLists = DB::table('events')
                ->select('events.*')
                ->where('category_id', '=', 4)
                ->where('publish', '=', 1)
                ->where('deleted', '=', 0)
                ->orderBy('start_date')
                ->get();
        $content = StaticPages::where('type','bookseries')->first(['content']);
        return view('bookseries')
                ->with('bookseriesYears', $bookseriesYears)
                ->with('eventLists', $eventLists)
                ->with('content', $content);
    }
}
