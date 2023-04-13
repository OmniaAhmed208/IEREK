<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;

use App\Models\Notifications;

use Validator;

use Response;

use Session;
use Auth;

class UsersManageController extends Controller
{
    //
    public function index($type)
    {
    	switch ($type)
    	{
    		case 'admins':
    			$users = Users::where('user_type_id', 2)->get();
    			return view('admin.users.show')->with(array(
    				'users' => $users,
    				'type'	=> 'admins',
    				'title' => 'Event Admin'
    			));
    			break;
    		case 'scientific':
    			$users = Users::where('user_type_id', 1)->get();
    			return view('admin.users.show')->with(array(
    				'users' => $users,
    				'type'	=> 'scientific',
    				'title' => 'Scientific Committee'
    			));
    			break;
                case 'editor':
    			$users = Users::where('user_type_id', 3)->get();
    			return view('admin.users.show')->with(array(
    				'users' => $users,
    				'type'	=> 'editor',
    				'title' => 'Event Editor'
    			));
    			break;
                    
                case 'accountant':
    			$users = Users::where('user_type_id', 5)->get();
    			return view('admin.users.show')->with(array(
    				'users' => $users,
    				'type'	=> 'accountant',
    				'title' => 'Accountant'
    			));
    			break;
    	}
    }

    public function make($type)
    {
    	switch($type)
    	{
    		case 'admins':
    			$title = 'Conference Admin';
    		break;
    		case 'scientific':
    			$title = 'Scientific Committee';
    		break;
                case 'editor':
    			$title = 'Conference Editor';
    		break;
    	}
    	return view('admin.users.create')->with(array(
    		'type' => $type,
    		'title' => $title
    	));
    }

    public function addto(Request $request, $type)
    {
    	switch($type)
    	{
    		case 'admins':
    			$type = 2;
    		break;
    		case 'scientific':
    			$type = 1;
    		break;
                case 'editor':
    			$type = 3;
    		break;
    	}
    	$data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            'email' => 'required|email|exists:users|max:255'
        ]);

        // return validation errors if exist
        if ($validator->fails())
        {
            $dd = array(
                'success' => false,
                'errs' => $validator->getMessageBag()->toArray()
            );

            echo json_encode($dd);
        }
        else
        {
            //new Studyabroad Fees
            // Store the new studyabroad fees data...
            $id = Users::where('email',$data['email'])->update(array(
                'user_type_id' => $type
            ));

            $nUser = Users::where('email',$data['email'])->first();
            $id = $nUser['user_id'];
            $users = Users::where('user_type_id','>=', 4)->get();
            $cusers = sizeof($users);
            for ($x = 0; $x < $cusers; $x++) {
                if($users[$x]['user_id'] == Auth::user()->user_id){
                    $createdBy = 'You';
                }else{
                    $createdBy = Auth::user()->first_name;
                }
                if($type == 1){
                    $case = 'Scientific Committee';
                }elseif($type == 2){
                    $case = 'Conference Admin';
                }elseif($type == 3){
                    $case = 'Conference Editor';
                }
                $notification = Notifications::create(array(
                    'title' => $nUser['first_name'].' Was Assigned as '.$case.' By '.$createdBy,
                    'description' => 'User: '.$nUser['first_name'].' '.$nUser['last_name'].'<br>Assigned as '.$case.'<br>By: '.Auth::user()->first_name,
                    'user_id' => $users[$x]['user_id'],
                    'color' => 'red',
                    'type' => 'user_type',
                    'icon' => 'cogs',
                    'timeout' => 5000,
                    'url' => '/admin/all-users/profile/'.$id,
                    'status' => 'danger'
                ));
            }

            if($id)
            {
                return Response::json($id);
            }
        }
    }

    public function remove($id)
    {
        $nUser = Users::where('user_id',$id)->first();
        $type = $nUser['user_type_id'];
        $remove = Users::where('user_id', $id)->update(array(
            'user_type_id' => 0
        ));

        $id = $nUser['user_id'];
        $users = Users::where('user_type_id','>=', 4)->get();
        $cusers = sizeof($users);
        for ($x = 0; $x < $cusers; $x++) {
            if($users[$x]['user_id'] == Auth::user()->user_id){
                $createdBy = 'You';
            }else{
                $createdBy = Auth::user()->first_name;
            }
            if($type == 1){
                    $case = 'Scientific Committee';
                }elseif($type == 2){
                    $case = 'Conference Admin';
                }elseif($type == 3){
                    $case = 'Conference Editor';
                }
            $notification = Notifications::create(array(
                'title' => $nUser['first_name'].' Was Removed from '.$case.' By '.$createdBy,
                'description' => 'User: '.$nUser['first_name'].' '.$nUser['last_name'].'<br>Removed from '.$case.'<br>By: '.Auth::user()->first_name,
                'user_id' => $users[$x]['user_id'],
                'color' => 'orange',
                'type' => 'user_type',
                'icon' => 'user',
                'timeout' => 5000,
                'url' => '/admin/all-users/profile/'.$id,
                'status' => 'warning'
            ));
        }

        if($remove)
        {
            return Response::json($remove);
        }
    }
}
