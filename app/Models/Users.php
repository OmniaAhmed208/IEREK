<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class Users extends Model
{
    use Notifiable;
	public function countries()
    {
        return $this->hasOne('App\Models\Countries', 'country_id', 'country_id');
    }
    public function user_type()
    {
        return $this->hasOne('App\Models\UserType', 'user_type_id', 'user_type_id');
    }
    public function user_title()
    {
        return $this->hasOne('App\Models\Titles', 'user_title_id', 'user_title_id');
    }
    
    public static function  barcodeGenerator($id)
    {
        $barcode = new BarcodeGenerator();
        $barcode->setText("https://www.ierek.com/admin/invoices/show/".$id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $code = $barcode->generate();
        return $code;
    }
    //
    protected $table = 'users';

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'age', 'user_title_id','linkedin','twitter','facebook','url', 'country_id', 'phone', 'gender','user_type_id','vcode','image','abbreviation','biography','slug','user_login','menu_toggle','cv','verified'];

    protected $hidden = ['password','remember_token'];

}
