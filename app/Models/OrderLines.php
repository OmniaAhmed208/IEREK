<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderLines extends Model
{
	public function paper()
    {
        return $this->hasOne('App\Models\EventFullPapers', 'paper_id', 'paper_id');
    }

	public function ticket()
    {
        return $this->hasOne('App\Models\EventTickets', 'ticket_id', 'ticket_id');
    }

    public function visa()
    {
        return $this->hasOne('App\Models\VisaRequests', 'visa_id', 'visa_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'user_id');
    }
    
     public function scopeInvoiceDetails($query,$id)
    {
     return $query
       ->where('order_lines.order_id',$id) 
       ->leftJoin ('event_fees as ef', 'order_lines.event_fees_id', '=' , 'ef.event_fees_id')
       ->select('order_lines.*','ef.title_en','ef.fees_category_id');
    }
    
    //
    protected $table = 'order_lines';

    protected $fillable = [
    'order_line_id',
    'order_id',
    'user_id',
    'event_fees_id',
    'amount',
    'currency',
    'paper_id',
    'ticket_id',
    'visa_id'
    ];
}
