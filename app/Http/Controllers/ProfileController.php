<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Users;

use App\Models\Titles;

use App\Models\Countries;

use Session;

use Validator;

use Storage;

use Response;

use Hash;
use Auth;

class ProfileController extends Controller
{
    //
    public function show()
    {
        $countries = Countries::where('name','!=','HOST')->get();
        $titles = Titles::where('user_title_id','!=', 0)->get();
    	$user = Users::where('user_id', Auth::user()->user_id)->first();
    	return view('profile')->with(array(
    		'user' => $user,
            'countries'    => $countries,
            'titles'       => $titles
    	));
    }

        public function update(Request $request)
    {

        $userdata = Users::where('user_id', $request['user_id'])->first();
        $oldpassword = $userdata['password'];

        // validating submitted data
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|max:255',
            'email'         => 'required|unique:users,email,'.$request['user_id'].',user_id|email|max:255',
            'password'      => 'confirmed|min:8|max:60',
        ]);

        // return validation errors if exist
        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errs'    => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        }
        else
        {
            // Store the new user data...
            if($request['password'] != '')
            {
                $hashed_password = addslashes(Hash::make($request['password']));
            }else{
                $hashed_password = $oldpassword;
            }
            

            // checking file is valid.
            if ($request->hasFile('image')  &&  $request->file('image')->isValid()) {
                $pimg = 'profile_'.rand(10000,99999);
                $coverImg = $request->file('image');
                $destinationPath = 'uploads/users/profile/'; // upload path
                $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                $fileName = '/'.$pimg.'.'.'jpg';//$extension; // renameing image
                //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('image')->getRealPath()));
              // sending back with message
                $upimg = Users::where('user_id',$request['user_id'])->update(array(
                    'image'             => $pimg
                ));

            }

            // checking file is valid.
            if ($request->hasFile('cv')  &&  $request->file('cv')->isValid()) {
                $cv = 'cv_'.rand(10000,99999);
                $coverImg = $request->file('cv');
                $destinationPath = 'uploads/users/cv/'; // upload path
                $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                $fileName = '/'.$cv.'.'.$extension;//$extension; // renameing image
                $cv = $fileName;
                //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('cv')->getRealPath()));
                $ucv = Users::where('user_id',$request['user_id'])->update(array(
                    'cv'                => $cv
                ));
              // sending back with message
            }

            $user = Users::where('user_id',$request['user_id'])->update(array(
                'first_name'        => $request['first_name'],
                'last_name'         => $request['last_name'],
                'email'             => $request['email'],
                'password'          => $hashed_password,
                'user_title_id'     => $request['user_title_id'],
                'age'               => $request['age'],
                'gender'            => $request['gender'],
                'country_id'        => $request['country_id'],
                'phone'             => $request['phone'],
                'biography'         => $request['biography'],
                'facebook'          => $request['facebook'],
                'linkedin'          => $request['linkedin'],
                'twitter'           => $request['twitter'],
                'url'               => $request['url']
            ));

            // $mail = curl_init(url('mail/verify/'.$user->id));
            Session::flash('status','Your profile was updated successfully.!');
            return Response::json(array(
                'success' => true,
                'mail'  => '<>'
            ), 200);
        }
    }

    public function verify($vcode)
    {
    	$user = Users::where('vcode',$vcode)->where('verified',0)->first();
    	if(count($user) > 0){
    		$verify = Users::where('user_id',$user['user_id'])->update(array(
    			'verified' => 1
    		));
    		Session::flash('status','Your account has been verified successfully, Thank You.!');
    	}else{
    		Session::flash('status','Verification code has been expired.!');
    	}
    	return redirect(url('/'));
    }
}
