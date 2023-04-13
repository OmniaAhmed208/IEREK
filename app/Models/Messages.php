<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    //
	public function sender()
    {
        return $this->hasOne('App\Models\Users', 'user_id', 'sender_id');
    }

    protected $table = "messages";

    protected $fillable = ['sender_id','user_id','created_at','updated_at','title','body','piority','timeout','read','deleted'];
}
