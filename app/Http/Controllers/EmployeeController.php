<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\employee;
use App\Mail\Confirmation;
use App\Mail\update;

use Illuminate\Support\Facades\Mail;




class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = employee::orderBy('id','asc')->get();
        return view('viewemployee')->with('employees', $employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
                
             $employee = new employee;
            
             $employee->email = $request->input('email');
             $employee->save();
             \Mail::to($employee->email)->send(new Confirmation);
      
             return redirect('/')->with('success', 'New Email Has Been Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employees = employee::find($id);
        return  view('show')->with('employees', $employees);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employees = employee::find($id);
        
        return  view('edit')->with('employees', $employees);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {           
             $employee = employee::find($request->id);
             $employee->firstname = $request->input('firstname');
             $employee->lastname = $request->input('lastname');
             $employee->email = $request->input('email');
             $employee->department = $request->input('department');
             $employee->save();

             \Mail::to($employee->email)->send(new update);
      
             return redirect('/viewemployee')->with('success', 'Employee record has just been updateed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = employee::find($id);   
        $employee->delete();
        return redirect('viewemployee')->with('success','Employee has been deleted successfully');
    }



    public function sendemail()
    {



        $user = employee::all();
        foreach ($user as $all)
        {
         Mail::raw("Good morning to you and have a productive day ahead. Reply to c.awuloy@yahoo.com .", function($message) use ($all)
        {
          $message->from('winner@lottery.com');
          $message->to($all->email)->subject('Winner');
           });
           }
         //  $this->info('Daily message sent');


         
            $employees = employee::all();

         //  \Mail::to($employees->email)->send(new Confirmation);
      
            return view('viewallemployee')->with('employees', $employees);
             
            
    }



}
