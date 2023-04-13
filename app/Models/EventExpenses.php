<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventExpenses extends Model
{
  
    public function event()
    {
        return $this->hasOne('App\Models\Events', 'event_id', 'event_id');
    }
    
    protected $table = 'event_expenses';

    protected $fillable = ['event_id','title','amount','currency','status','created_by','updated_by'];
}