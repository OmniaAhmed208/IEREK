<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    //
    public function index()
    {
    	$id = auth()->user()->user_id;
        $user = User::where('user_id', $id)->with('countries','user_titles')->get([
    		'email',
    		'user_title_id',
    		'first_name',
    		'last_name',
    		'country_id',
    		'phone',
    		'age',
    		'gender',
    		'image'
    	]);

    	$user = $user[0];


        $user->user_title_id = $user->user_titles['title']; unset($user['user_titles']);
        $user->country_id = $user->countries['name']; unset($user['countries']);
        if($user->image == null){
            $user->image = null;
        } else {
    	   $user->image = asset('storage/uploads/users/profile/'.$user['image'].'.jpg');
        }
    	return response()->json($user, 200);
    }



    public function update(Request $request)
    {
        $id = auth()->user()->user_id;
        $this->validate($request, [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|email|max:50|unique:users,email,'.$id.',user_id',
            'user_title_id' => 'required|not_in:0',
            'country_id' => 'required|not_in:0',
            'age' => 'required|date_format:Y-m-d',
            'phone' => 'required',
            'gender' => 'required'
        ]);

        $user = User::where('user_id', $id)->update([
            'first_name'    =>      $request->input('first_name'),
            'last_name'     =>      $request->input('last_name'),
            'email'         =>      $request->input('email'),
            'user_title_id' =>      $request->input('user_title_id'),
            'country_id'    =>      $request->input('country_id'),
            'age'           =>      $request->input('age'),
            'phone'         =>      $request->input('phone'),
            'gender'        =>      $request->input('gender')
        ]);

        return response()->json([
            "message"   => "Successfully updated profile"
        ], 200);
    }
}
