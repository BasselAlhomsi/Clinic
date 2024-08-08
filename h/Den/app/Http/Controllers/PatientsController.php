<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;


class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::paginate(6);
        return view('admin.patients.show',['patients'=>$patients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate(['name'=>['required','string','regex:/^[a-zA-Z\s\'\.]+$/','min:2','max:255'],
        'age'=>['required','integer','between:1,100'],
        'email'=>['required','email','unique:patients,email']]);
        
        Patient::create([
             'name'=>$request->name,
            'age'=>$request->age,
          'email'=>$request->email
        ]);

        return to_route('patients.index')->with('added','you added data successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $patient = Patient::find($id);

        if (!$patient) {
            // If the id does not exist, redirect back with an error message
            return to_route('patients.index')->with('error','Patient you want to edit not found');
        }

        // If the id exists, show the edit view with the date data
        return view('admin.patients.edit',['patient'=>$patient]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
    
        request()->validate(['name'=>['required','string','regex:/^[a-zA-Z\s\'\.]+$/','min:2','max:255'],
        'age'=>['required','integer','between:1,100'],
        'email'=>['required','email','unique:patients,email,'.$id]]);
   
        $patient=Patient::find($id);
        
        $patient->update(['name'=>request()->name,'age'=>request()->age,'email'=>request()->email]);

        return to_route('patients.edit',$id)->with('success','you edited the data successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);

        $patient->delete();
            
        return redirect()->back()->with('success','Patient deleted successfully');
      }
}
