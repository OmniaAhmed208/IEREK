<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use App\Models\Staffs;

use Session;
class StaffsController extends Controller
{
    //
   

    public function listAll()
    {
        $description = ' This is my Second learning example. this example display my personal information defined in Staff table in ierek database';

       

        $staffs = Staffs::where('deleted', '=', 0)->get();

        //$countries = Countries::get();
        return View('staffs_display')->with(array(
            'description' => $description,
            'staffs' => $staffs
        ));
    }
    public function create(Request $request)
    {
       $data = $request->all();
       $name=$data['name'];
       $birthdate=$data['birthdate'];

       $newStaff=Staffs::create(array(
        'staff_name' => $name,
         'birth_date' =>$birthdate)
       );

       Session::flash('status' ,'Staff Created Successfully' );
       return redirect ('staffs');

    }

     public function edit(Request $request)
    {
        $data = $request->all();
        if(isset($data['Edit']))
        {
            $staff_id=$data['staff_id'];
            //$name=$data['name'];
            //$birthdate=$data['birth_date'];

            $staff = Staffs::where('staff_id', $staff_id)->first();

            return View('staffs_edit')->with(array(
                'staff' => $staff
            ));        
        }
        elseif(isset($data['Delete']))
        {
            $data = $request->all();
            $staff_id=$data['staff_id'];
            //$name=$data['name'];
            //$birthdate=$data['birth_date'];

            $deletedStaff = Staffs::where('staff_id', $staff_id)->update(array(
                    
                   'deleted' => 1
                ));

           Session::flash('status' ,'Staff Deleted Successfully' );
           return redirect ('staffs');       
        }

        
    }
    public function Save(Request $request)
    {
       
        $data = $request->all();
        $staff_id=$data['staff_id'];
        $name=$data['name'];
        $birthdate=$data['birthdate'];

        $updatedStaff = Staffs::where('staff_id', $staff_id)->update(array(
                
              'staff_name' => $data['name'],
                'birth_date' => $data['birthdate']
        ));

        Session::flash('status' ,'Staff Updated Successfully' );
        return redirect ('staffs');

    }
    public function activate(Request $request)
    {
       
        
        $data = $request->all();
        $staff_id=$data['staff_id'];
        $name=$data['name'];
        $birthdate=$data['birth_date'];

        $activatedStaff = Staffs::where('staff_id', $staff_id)->update(array(
                
               'deleted' => 0
            ));

       Session::flash('status' ,'Staff Activated Successfully' );
       return redirect ('staffs');

    }
    
}
