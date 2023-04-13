<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\StaticPages;

use App\Models\Users;

use App\Models\Notifications;

use Validator;
use Response;
use Input;
use Storage;
use Session;
use Auth;

class StaticPagesController extends Controller
{
    //
    public function page($type)
    {
    	$page = StaticPages::where('type',$type)->first();
    	return View('admin.static.show')->with(array(
    		'page' => $page
    	));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'cover_img' => 'mimes:jpeg,jpg,png|max:1000000'
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

        $imgChanged = 'Not Changed';

        // checking file is valid.
        if ($request->hasFile('cover_img')  &&  $request->file('cover_img')->isValid()) {
            $coverImg = $request->file('cover_img');
            $destinationPath = 'uploads/images/'; // upload path
            $extension = $coverImg->getClientOriginalExtension(); // getting image extension
            $fileName = $request['type'].'.jpg';//$extension; // renameing image
            $imgChanged = 'Changed';
            $coverImg->move($destinationPath, $fileName); // uploading file to given path
            // Storage::put($destinationPath.$fileName ,file_get_contents($request->file('cover_img')->getRealPath()));
          // sending back with message
        }

        $data = $request->all();
        
        //Update Static Page
        $nPage = StaticPages::where('page_id', $id)->first();

        $uPage = StaticPages::where('page_id', $id)->update(array(
            'content' => $data['content']
        ));

        $page = StaticPages::where('page_id', $id)->first();

        $users = Users::where('user_type_id','>=', 2)->get();
        $cusers = sizeof($users);
        for ($x = 0; $x < $cusers; $x++) {
            if($users[$x]['user_id'] == Auth::user()->user_id){
                $createdBy = 'You';
            }else{
                $createdBy = Auth::user()->first_name;
            }
            $notification = Notifications::create(array(
                'title' => ucfirst($page['type']).' page updated by '.$createdBy,
                'description' => json_encode(array(
            '<:Content:>' => '&&'.$data['content'].'##'.$nPage['content'],
            '<:Image:>' => '&&'.@$imgChanged.'##'
        )),
                'user_id' => $users[$x]['user_id'],
                'color' => '#777',
                'type' => 'static-pages',
                'icon' => 'file',
                'timeout' => 5000,
                'url' => '/admin/pages/static/'.$page['type'],
                'status' => 'info'
            ));
        }

        Session::flash('status', ucfirst($page['type']).' page updated successfully.');

        return redirect(url('admin/pages/static/'.$page['type']));
    }
}
