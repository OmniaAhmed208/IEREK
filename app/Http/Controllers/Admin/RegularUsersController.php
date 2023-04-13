<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;

use App\Models\Titles;

use App\Models\Countries;

use Validator;

use Response;

use Hash;

use Session;

use App\Models\Notifications;

use Auth;
use Storage;

class RegularUsersController extends Controller
{
    //
    public function index()
    {
    	return View('admin.regular-users');
    }
    
    public function searchUsers()
    {
        $searchOptions = Request()->get("search", array());
        
        $start = Request()->get("start", 0);
        $draw = Request()->get("draw",1);
        $length = Request()->get("length",1);
        $pageNumber = ($start/$length) +1;
        
        if(!empty($searchOptions)){
            $searchString = $searchOptions['value'];
            if (\DateTime::createFromFormat('Y-m-d', $searchString) == FALSE) {
            $keyword = $searchString;

            }else{
                $date = date("Y-m-d", strtotime($searchString));
           }
        }
        

        $query = Users::query()->whereIn('user_type_id',[0,1]);
        $countOfUsersWithoutFilter = $query->count();
        
        if(isset($keyword)){
            $query->select("users.*")
                    ->join('user_title', 'user_title.user_title_id', '=', 'users.user_title_id')
                    ->where( function ( $q2 ) use ( $keyword ) {
	                   $q2->whereRaw( 'LOWER(`users`.`first_name`) like ?', array( "%".$keyword."%" ) );
	                   $q2->orWhereRaw( 'LOWER(`users`.`last_name`) like ?', array( "%".$keyword."%" ) );
                           $q2->orWhereRaw( 'LOWER(`user_title`.`title`) like ?', array( "%".$keyword."%" ) );
                    })->orWhere("users.email", "like", "%".$keyword."%");
              
        }
        
        if(isset($date)){
             $query->whereDate("users.created_at", "=", $date);
        }


        $allUsersCounts = $query->count();
        $users = $query->paginate($length, ['*'],'page', $pageNumber);
        
        
        $usersTable = $this->drawTheUsersDataTable($users);
    
   
        return response()->json(
                array(
                    'data' => $usersTable,
                    'recordsTotal' => $countOfUsersWithoutFilter,
                    'recordsFiltered' => $allUsersCounts,
                    'draw' => $draw));
                
 }
 
 public function drawTheUsersDataTable($users){
        $usersArray = array();
    
        foreach($users as $user){
            $userArray = array();
            if($user->gender == 1 OR $user->gender == 0){
                $gender = 'male'; 
                
            }elseif($user->gender == 2){
                $gender = 'female'; 
                
            }
            $image = $user->image ? '/storage/uploads/users/profile/'.$user->image.'.jpg' : '/uploads/default_avatar_'.$gender.'.jpg';
            $name = $user->user_title->title." ".$user->first_name." ".$user->last_name;
            $userArray['email'] = $user->email;
            $userArray['title'] = array("image" => $image, "name" => $name);
            $userArray['phone'] = $user->phone ? $user->phone: 'N/A';
            if($user->country_id == null){
                $userArray['country'] = "N/A";
            }else{
                $userArray['country'] = $user->countries->name == 'HOST' ? 'N/A' : $user->countries->name;
            }
            $userArray['register_date'] = date('Y-m-d', strtotime($user->created_at));
            $userArray['id'] = $user->user_id;
            $usersArray[] = $userArray;
            }
            return $usersArray;
        }
   
    public function profile($id)
    {
    	$user = Users::where('user_id',$id)->first();
        $countries = Countries::where('name','!=','HOST')->get();
        $titles = Titles::where('user_title_id','!=', 0)->get();
    	return View('admin.profile')->with(array(
    		'user'         => $user,
            'countries'    => $countries,
            'titles'       => $titles
    	));
    }

    public function create()
    {
        $countries = Countries::where('name','!=','HOST')->get();
        $titles = Titles::where('user_title_id','!=', 0)->get();
        return View('admin.users.newuser')->with(array(
            'countries'     => $countries,
            'titles'        => $titles
        ));
    }

    public function store(Request $request)
    {
        if($request['role'] > 1){
            if(Auth::user()->user_type_id != 4)
            {
                die('{"success":"false"}');
            }
        }
        // validating submitted data
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|max:255',
            'email'         => 'required|unique:users|email|max:255',
            'password'      => 'required|confirmed|min:8|max:60',
            'slug'          => 'required|unique:users|regex:/(^([a-zA-Z_-]+)(\d+)?$)/u'
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
            $vcode = md5(rand(10000,99999));
            $hashed_password = addslashes(Hash::make($request['password']));

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
            }else{
                $pimg = '';
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
              // sending back with message
            }else{
                $cv = '';
            }

            $user = Users::create(array(
                'first_name'        => $request['first_name'],
                'last_name'         => $request['last_name'],
                'email'             => $request['email'],
                'password'          => $hashed_password,
                'user_title_id'     => $request['user_title_id'],
                'age'               => $request['age'],
                'image'             => $pimg,
                'cv'                => $cv,
                'gender'            => $request['gender'],
                'country_id'        => $request['country_id'],
                'phone'             => $request['phone'],
                'facebook'          => $request['facebook'],
                'linkedin'          => $request['linkedin'],
                'twitter'           => $request['twitter'],
                'url'               => $request['url'],
                'biography'         => $request['biography'],
                'abbreviation'      => $request['abbreviation'],
                'slug'              => $request['slug'],
                'vcode'             => $vcode,
                'verified'          => 0,
                'user_type_id'      => $request['role']
            ));

            $id = $user->id;
            $users = Users::where('user_type_id','>=', 4)->get();
            $cusers = sizeof($users);
            for ($x = 0; $x < $cusers; $x++) {
                if($users[$x]['user_id'] == Auth::user()->user_id){
                    $createdBy = 'You';
                }else{
                    $createdBy = Auth::user()->first_name;
                }
                $notification = Notifications::create(array(
                    'title' => 'New User Created By '.$createdBy,
                    'description' => json_encode(array(
                '<:First Name:>'        => '&&'.$request['first_name'].'##',
                '<:Last Name:>'         => '&&'.$request['last_name'].'##',
                '<:Email:>'             => '&&'.$request['email'].'##',
                '<:Title:>'             => '&&'.$request['user_title_id'].'##',
                '<:Age:>'               => '&&'.$request['age'].'##',
                '<:Image:>'             => '&&'.$pimg.'##',
                '<:C.V.:>'              => '&&'.$cv.'##',
                '<:Gender:>'            => '&&'.$request['gender'].'##',
                '<:Country:>'           => '&&'.$request['country_id'].'##',
                '<:Phone:>'             => '&&'.$request['phone'].'##',
                '<:Facebook:>'          => '&&'.$request['facebook'].'##',
                '<:LinkedIn:>'          => '&&'.$request['linkedin'].'##',
                '<:Twitter:>'           => '&&'.$request['twitter'].'##',
                '<:URL:>'               => '&&'.$request['url'].'##',
                '<:Abbreviation:>'         => '&&'.$request['abbreviation'].'##',
                '<:Biography:>'         => '&&'.$request['biography'].'##',
                '<:Slug:>'              => '&&'.$request['slug'].'##',
                '<:Role:>'              => '&&'.$request['role'].'##'
            )),
                    'user_id' => $users[$x]['user_id'],
                    'color' => 'orange',
                    'type' => 'admin-users-registration',
                    'icon' => 'users',
                    'timeout' => 5000,
                    'url' => '/admin/all-users/profile/'.$id,
                    'status' => 'info'
                ));
            }
            if($request['role'] == 1){
                $mail = curl_init(url('mail/sc/'.$user->id.'/'.$request['password']));
            }else{
                $mail = curl_init(url('mail/verify/'.$user->id));
            }
            Session::flash('status','User was registered successfully.!');
            return Response::json(array(
                'success' => true,
                'mail'  => curl_exec($mail)
            ), 200);
        }
    }

    public function hide($id){
        Users::where('user_id',$id)->update(['hidden' => 1]);
        $user = Users::where('user_id',$id)->first();
        Session::flash('status','User was hidden successfully.!');
        if($user['user_type_id'] == 1){
            return redirect('/admin/users/scientific');
        }elseif($user['user_type_id'] == 2){
            return redirect('/admin/users/admins');
        }elseif($user['user_type_id'] == 3){
            return redirect('/admin/users/editor');
        }
        return redirect('/admin/all-users');
    }

    public function unhide($id){
        Users::where('user_id',$id)->update(['hidden' => 0]);
        $user = Users::where('user_id',$id)->first();
        Session::flash('status','User was unhidden successfully.!');
        if($user['user_type_id'] == 1){
            return redirect('/admin/users/scientific');
        }elseif($user['user_type_id'] == 2){
            return redirect('/admin/users/admins');
        }elseif($user['user_type_id'] == 3){
            return redirect('/admin/users/editor');
        }
        return redirect('/admin/all-users');
    }

    public function update(Request $request)
    {

        $user = Users::where('user_id',$request['user_id'])->first();
        if(Auth::user()->user_type_id != 4){
            die('<h1>Your account is not authorized to edit this profile.</h1>');
        }
        // validating submitted data
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|max:255',
            'email'         => 'required|unique:users,email,'.$request['user_id'].',user_id|email|max:255',
            'password'      => 'required|confirmed|min:8|max:60',
            'slug'          => 'required|unique:users,slug,'.$request['user_id'].',user_id|regex:/(^([a-zA-Z_-]+)(\d+)?$)/u'
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
            if($request['old_password'] != $request['password'])
            {
                $hashed_password = addslashes(Hash::make($request['password']));
            }else{
                $hashed_password = $request['password'];
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
            $nUser = Users::where('user_id',$request['user_id'])->first();
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
                'abbreviation'      => $request['abbreviation'],
                'biography'         => $request['biography'],
                'facebook'          => $request['facebook'],
                'linkedin'          => $request['linkedin'],
                'twitter'           => $request['twitter'],
                'url'               => $request['url'],
                'slug'              => $request['slug'],
                'user_type_id'      => $request['role']
            ));


            $id = $request['user_id'];
            $users = Users::where('user_type_id','>=', 4)->get();
            $cusers = sizeof($users);
            for ($x = 0; $x < $cusers; $x++) {
                if($users[$x]['user_id'] == Auth::user()->user_id){
                    $createdBy = 'You';
                }else{
                    $createdBy = Auth::user()->first_name;
                }
                $notification = Notifications::create(array(
                    'title' => 'User Profile Updated By '.$createdBy,
                    'description' => json_encode(array(
                '<:First Name:>'        => '&&'.$request['first_name'].' ## '.$nUser['first_name'],
                '<:Last Name:>'         => '&&'.$request['last_name'].' ## '.$nUser['last_name'],
                '<:Email:>'             => '&&'.$request['email'].' ## '.$nUser['email'],
                '<:Title:>'             => '&&'.$request['user_title_id'].' ## '.$nUser['user_title_id'],
                '<:Age:>'               => '&&'.$request['age'].' ## '.$nUser['age'],
                '<:Image:>'             => '&&'.@$pimg.' ## '.$nUser['image'],
                '<:C.V.:>'              => '&&'.@$cv.' ## '.$nUser['cv'],
                '<:Gender:>'            => '&&'.$request['gender'].' ## '.$nUser['gender'],
                '<:Country:>'           => '&&'.$request['country_id'].' ## '.$nUser['country_id'],
                '<:Phone:>'             => '&&'.$request['phone'].' ## '.$nUser['phone'],
                '<:Facebook:>'          => '&&'.$request['facebook'].' ## '.$nUser['facebook'],
                '<:LinkedIn:>'          => '&&'.$request['linkedin'].' ## '.$nUser['linkedin'],
                '<:Twitter:>'           => '&&'.$request['twitter'].' ## '.$nUser['twitter'],
                '<:URL:>'               => '&&'.$request['url'].' ## '.$nUser['url'],
                '<:Abbreviation:>'         => '&&'.$request['abbreviation'].'##',
                '<:Biography:>'         => '&&'.$request['biography'].' ## '.$nUser['biography'],
                '<:Slug:>'              => '&&'.$request['slug'].' ## '.$nUser['slug'],
                '<:Role:>'              => '&&'.$request['role'].' ## '.$nUser['role']
            )),
                    'user_id' => $users[$x]['user_id'],
                    'color' => 'orange',
                    'type' => 'admin-user-update',
                    'icon' => 'users',
                    'timeout' => 5000,
                    'url' => '/admin/all-users/profile/'.$id,
                    'status' => 'info'
                ));
            }

            // $mail = curl_init(url('mail/verify/'.$user->id));
            Session::flash('status','User profile was updated successfully.!');
            return Response::json(array(
                'success' => true,
                'mail'  => '<>'
            ), 200);
        }
    }
}
