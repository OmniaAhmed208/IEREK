<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;

use App\Models\MailTemplates;

class MailTemplatesController extends Controller
{
    //
	public function index()
	{
		$templates = MailTemplates::all();
		return view('admin.mailtemplates.index')->with(array(
			'templates' => $templates
		));
	}

	public function edit($id)
	{
		$template = MailTemplates::where('mail_id', $id)->first();
		return view('admin.mailtemplates.edit')->with(array(
			'template' => $template
		));
	}

	public function update(Request $request){
		$data = $request->all();
		unset($data['_token']);
		$update = MailTemplates::where('mail_id',$data['mail_id'])->update($data);
		if($update){
			return Response(['success' => true]);
		}else{
			return Response(['success' => false]);
		}
	}
}
