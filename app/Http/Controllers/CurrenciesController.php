<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use App\Models\Currencies;

use Session;
class CurrenciesController extends Controller
{
    //
   

    public function listAll()
    {
        
        $currencies = Currencies::where('deleted', '=', 0)->get();

        //$countries = Countries::get();
        return View('currencies_display')->with(array(
            'currencies' => $currencies
        ));
    }
    public function create(Request $request)
    {
       $data = $request->all();
       $currencyCode=$data['currency_code'];
       $currencyName=$data['currency_name'];
       $currencySymbol=$data['currency_symbol'];
       

       $newCurrency=Currencies::create(array(
        'currency_code' => $currencyCode,
        'currency_name' => $currencyName,
         'currency_symbol' =>$currencySymbol)
       );

       Session::flash('status' ,'Currency Created Successfully' );
       return redirect ('currencies');

    }

     public function edit(Request $request)
    {
        $data = $request->all();
        if(isset($data['Edit']))
        {
            $currencySid=$data['currency_sid'];
            $currency = Currencies::where('currency_sid', $currencySid)->first();

            return View('currencies_edit')->with(array(
                'currency' => $currency
            ));        
        }
        elseif(isset($data['Delete']))
        {
            $data = $request->all();
            $currencySid=$data['currency_sid'];
            
            $deletedCurrency = Currencies::where('currency_sid', $currencySid)->update(array(
                    
                   'deleted' => 1
                ));

           Session::flash('status' ,'Currency Deleted Successfully' );
           return redirect ('currencies');       
        }

        
    }
    public function Save(Request $request)
    {
       
        $data = $request->all();

        $currencySid=$data['currency_sid'];

        $currencyCode=$data['currency_code'];
        $currencyName=$data['currency_name'];
        $birthdate=$data['currency_symbol'];

        $updatedCurrency = Currencies::where('currency_sid', $currencySid)->update(array(
              
              'currency_code' => $data['currency_code'],  
              'currency_name' => $data['currency_name'],
                'currency_symbol' => $data['currency_symbol']
        ));

        Session::flash('status' ,'Currency Updated Successfully' );
        return redirect ('currencies');

    }
    public function activate(Request $request)
    {
       
        
        $data = $request->all();
        $currencySid=$data['currency_sid'];

        $activatedCurrency = Currencies::where('currency_sid', $currencySid)->update(array(
                
               'deleted' => 0
            ));

       Session::flash('status' ,'Currency Activated Successfully' );
       return redirect ('currencies');

    }
    
}
