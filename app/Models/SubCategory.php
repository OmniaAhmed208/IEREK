<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
	public function events()
    {
        return $this->hasMany('App\Models\Events', 'sub_category_id', 'sub_category_id');
    }

    //
    protected $table = 'sub_category';

    protected $fillable = ['title', 'description', 'category_id'];
}
