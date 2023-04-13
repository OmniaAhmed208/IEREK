<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
   protected $table = 'partners';

    protected $fillable = ['id','img_path','created_at','updated_at'];
}