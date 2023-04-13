<?php
	namespace App\Http\Controllers\Admin\Events;
	use App\Models\EventImportantDate;
    function dDs($days, $start)
    {
    	return date("Y-m-d", strtotime( "-".$days." day", strtotime($start) ) );
    }
    $add = [];
    function updateDates($aDate, $type, $desc_en, $title ,$event_id)
    {
    	$update = EventImportantDate::where(array('event_id' => $event_id, 'event_date_type_id'=> $type) )->update(array(
    			'title_en' 			 => $desc_en,
                'title'              => $title,
    			'to_date'  			 => $aDate
    		));
    	return $update;
    }

    function createDates($aDate, $type, $desc_en, $title ,$event_id)
    {
    	$create = EventImportantDate::create(array(
    			'event_id'			 => $event_id,
    			'event_date_type_id' => $type,
    			'title_en' 			 => $desc_en,
                'title'              => $title,
    			'to_date'  			 => $aDate
    		));
    	return $create;
    }