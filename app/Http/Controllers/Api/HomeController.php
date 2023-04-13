<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FeaturedEvents;
use App\Models\Slider;
use App\Models\Events;
use App\Models\Videos;

class HomeController extends Controller
{
    //
	public function index()
    {
        $sliders = Slider::where('deleted',0)->get(['position','img','img_url']);

        $all_sliders = [];

        foreach($sliders as $s){
        	$img_url = '';

        	$is_event = Events::where('slug', str_replace('events/','',$s['img_url']))->first(['event_id','category_id']);

            $aimgurl = url($s['img_url']);
            if($is_event != null){
                $img_url = $is_event['event_id'];
        	} else {
        		$img_url = null;
        	}

        	$slide = [
        		'position'  => $s['position'],
        		'image'	    => url('/storage/uploads/slider/'.$s['img']),
                'category_id' => isset($is_event['category_id']) ? $is_event['category_id'] : null,
                'url'   => $aimgurl,
        		'event_id'  => $img_url
        	];
        	array_push($all_sliders, $slide);
        }

        $f_conferences = FeaturedEvents::where('category_id',1)->where('deleted',0)->whereHas('event', function($q){
            $q->where('publish', '=', 1);
        })->orderBy('position')->take(4)->get();
        
        $featured_conferences = [];

        foreach ($f_conferences as $fc) {
        	$f_c = [
        		'event_id' 		=> $fc['event_id'],
        		'position' 		=> $fc['position'],
        		'title'			=> $fc->event['title_en'],
        		'location'		=> $fc->event['location_en'],
        		'image'			=> url('/storage/uploads/conferences/'.$fc['event_id'].'/list_img.jpg'),
        		'dates'			=> date("d M", strtotime($fc->event['start_date'])).' / '.date("d M Y", strtotime($fc->event['end_date']))
        	];
        	array_push($featured_conferences, $f_c);
        }


        // $f_workshops = FeaturedEvents::where('category_id',2)->where('deleted',0)->whereHas('event', function($q){
        //     $q->where('publish', '=', 1);
        // })->orderBy('position')->take(4)->get(['position','event_id']);

        $featured_workshops = [];

        // foreach ($f_workshops as $fw) {
        // 	$f_w = [
        // 		'event_id' 		=> $fw['event_id'],
        // 		'position' 		=> $fw['position'],
        // 		'title'			=> $fw->event['title_en'],
        // 		'location'		=> $fw->event['location_en'],
        // 		'image'			=> url('/storage/uploads/workshops/'.$fw['event_id'].'/featured_img.jpg'),
        // 		'dates'			=> date("d M", strtotime($fw->event['start_date'])).' / '.date("d M Y", strtotime($fw->event['end_date']))
        // 	];
        // 	array_push($featured_workshops, $f_w);
        // }
    	


        $rss = new \DOMDocument();
        
        $rss->load(url('news/index.php/feed/'));

        $feed = array();
        $limit = 0;
        foreach ($rss->getElementsByTagName('item') as $node) {
            if($limit < 4){
                $item = array ( 
                    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                    'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                    'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                    'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                    );
                array_push($feed, $item);
                $limit ++;
            }
        }
        $feeds = [];
        foreach($feed as $f) {

            $description = @$f['desc'];
            $desc = substr(@$description, 0, 100);
            $desc = preg_replace("/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/", "", @$desc);
            $desc = str_replace('&#8221;','"',$desc);
            $desc = str_replace('&#8220;','"',$desc);
        	
        	$af = [
        		'title'			=> str_replace(' & ', ' &amp; ', @$f['title']),
        		'link'			=> @$f['link'],
        		'description' 	=> $desc,
        		'date'			=> date('l F d, Y', strtotime(@$f['date']))
        	];

        	array_push($feeds, $af);
        }
        $all_videos = [];
        $videos = Videos::where('deleted',0)->orderBy('position','ASC')->take(2)->get(['url']);

        foreach($videos as $v)
        {
            $xpath = new \DOMXPath(@\DOMDocument::loadHTML($v['url']));
            $src = $xpath->evaluate("string(//iframe/@src)");
            $ytcode = str_replace('https://www.youtube.com/embed/', '', $src);
            array_push($all_videos, $ytcode);
        }

        return response()->json([
            'slides' => $all_sliders,
            'conferences' => $featured_conferences,
            'workshops' => $featured_workshops,
            'videos' => $all_videos,
            'rss_feeds'	=> $feeds
        ]);
    }
}