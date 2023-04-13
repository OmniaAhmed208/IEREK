<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplates extends Model
{
    //
    protected $table = "mail_templates";

    protected $fillable = ['title','trigger','message','cc_mails','bcc_mails','admin_title','admin_email','admin_message','created_at','updated_at','updated_by','inactive'];
}
