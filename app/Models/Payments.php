<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //
	public function order()
    {
        return $this->hasOne('App\Models\Users', 'order_id', 'order_id');
    }
    
    protected $table = "payments";

    protected $fillable = 
    [
    'payment_id',
    'order_id',
    'res_token',
    'status',
    'created_at'
    ];
}
