<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;

use Hash;

class HashController extends Controller
{
    //
    public function hashz(){
    	$password = 'helmy6155';
    	$passwordHash = '$P$BmJiWu1WoCjzKTPkfbN8Dl6ZyfOSns/';

    	$password1 = '123456';
    	$passwordHash1 = '$2y$10$abAuUmHes7DeDLh03plIyOOTSlVm93.YRdCNclh/0xUyBN6IASHQG';

        $password2 = '12345678';
        $passwordHash2 = '$2a$08$9zZPWo5Jou3Zdvnb.oUTxOprm6k1cGKC./2B.tO3K9s9hQ1lKgTCa';


    	if(Hash::check($password2, $passwordHash2)){
    		return 'yes';
    	}else{
            $gen = Hash::make('12345678');
    		return 'no '.$gen;
    	}

    }
}
