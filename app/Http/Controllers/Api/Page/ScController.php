<?php

namespace App\Http\Controllers\Api\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;

class ScController extends Controller
{
    //
    public function index()
    {
    	$scs = Users::where('user_type_id',1)->where('hidden','!=',1)->where('deleted',0)->orderBy('first_name','ASC')->simplePaginate(10);

    	// dd($scs);
    	$all_scs = [
    		'per_page' 		=> $scs->perPage(),
    		'current_page'	=> $scs->currentPage(),
    		'has_more'		=> $scs->hasMorePages(),
    		'next_page_url' => $scs->nextPageUrl(),
    		'prev_page_url' => $scs->previousPageUrl(),
    		'profiles'		=> []
    	];

    	foreach($scs as $sc){
    		$image = '';
			if($sc['gender'] == 1 OR $sc['gender'] == 0){ $gender = 'male'; }elseif($sc['gender'] == 2){ $gender = 'female'; }
			if($sc['image'] == ''){ $image = url("/uploads/default_avatar_".$gender.".jpg"); }else{ $image = url("/storage/uploads/users/profile/".$sc['image'].".jpg"); }
    		$s_c = [
    			'slug' 		=> $sc['slug'],
    			'name'			=> $sc['first_name'].' '.$sc['last_name'],
    			'abbr'			=> substr($sc['abbreviation'], 0, 75),
    			'image'			=> $image
    		];

    		array_push($all_scs['profiles'], $s_c);
    	}

    	return response()->json($all_scs, 200);
    }


    public function profile($slug)
    {
    	$sc = Users::where('user_type_id',1)->where('hidden','!=',1)->where('slug',$slug)->where('deleted',0)->orderBy('first_name','ASC')->first(['first_name','last_name','image','abbreviation','biography','cv']);

	    if($sc != null){
	    	$image = '';
			if($sc['gender'] == 1 OR $sc['gender'] == 0){ $gender = 'male'; }elseif($sc['gender'] == 2){ $gender = 'female'; }
			if($sc['image'] == ''){ $image = url("/uploads/default_avatar_".$gender.".jpg"); }else{ $image = url("/storage/uploads/users/profile/".$sc['image'].".jpg"); }
			$s_c = [
				'name'			=> $sc['first_name'].' '.$sc['last_name'],
				'abbr'			=> $sc['abbreviation'],
				'biography'		=> $this->array_utf8_encode($sc['biography']),
				'cv'			=> url('storage/users/cv/'.$sc['cv']),
				'image'			=> $image
			];

	    	return response()->json($s_c, 200);
	    } else {
	    	return response()->json(['error' => 'Not data has been founded!']);
	    }
    }

    /**
 * Encode array to utf8 recursively
 * @param $dat
 * @return array|string
 */
	public static function array_utf8_encode($dat)
	{
	    if (is_string($dat))
	        return utf8_encode($dat);
	    if (!is_array($dat))
	        return $dat;
	    $ret = array();
	    foreach ($dat as $i => $d)
	        $ret[$i] = self::array_utf8_encode($d);
	    return $ret;
	}
}
