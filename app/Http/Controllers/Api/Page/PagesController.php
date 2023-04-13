<?php

namespace App\Http\Controllers\Api\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StaticPages;

class PagesController extends Controller
{
    //
	public function page($page)
	{
		$get_page = StaticPages::where('type',$page)->first();
		$types = [
			'contact' 				=> 'Contact Us',
			'faq'					=> 'FAQ',
			'press'					=> 'IEREK Press',
			'terms'					=> 'Terms & Conditions',
			'about'					=> 'About Us',
			'sc'					=> 'Scientific Committee',
			'translation_service' 	=> 'Translation Service'
		];
		$pages = [
			'title' 	=> $types[$page],
			'image' 	=> url('uploads/images/'.$page.'.jpg'),
			'content' 	=> str_replace('src="/uploads', 'src="https://www.ierek.com/uploads', $get_page['content'])
		];

		return response()->json($pages, 200);

	}
}
