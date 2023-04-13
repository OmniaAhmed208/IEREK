<?php

namespace App\Http\Controllers\Api\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;

class IndexsController extends Controller
{
    //
    public function index($type)
    {

    	$category_id = [
    		'conference' 	=> 1,
    		'workshop'   	=> 2,
    		'studyabroad'	=> 3,
    		'bookseries'	=> 4
    	];

    	$subcats = SubCategory::where('category_id',$category_id[$type])->where('deleted',0)->orderBy('title','ASC')->get(['title']);

    	$index = [];

    	foreach($subcats as $sc){
    		array_push($index, $sc['title']);
    	}

    	return response()->json($index);
    }
}
