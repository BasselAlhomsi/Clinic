<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Models\Doctor;


class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::paginate(6);
        return view('admin.doctors.show',['doctors'=>$doctors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = Specialization::all() ;
        return view('admin.doctors.create',['specializations'=>$specializations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate(['name'=>['required','string','regex:/^[a-zA-Z\s\'\.]+$/','min:2','max:255'],
        'age'=>['required','integer','between:25,100'],
        'email'=>['required','email','unique:doctors,email']]);

                   
        Doctor::create(['name'=>$request->name,'age'=>$request->age,'email'=>$request->email,'specialization_id'=>$request->specialization]);

        return to_route('doctors.index')->with('added','you added data successfully');
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
        $doctor = Doctor::find($id);
        
        if (!$doctor) 
        {
            return to_route('doctors.index')->with('error','Doctor you want to edit not found');
        }

        $specializations=Specialization::all();
        return view("admin.doctors.edit",['doctor'=>$doctor,'specializations'=>$specializations]);
    }

     /**
     * Update the specified resource in storage.
 
 
     */ 
    
    public function update(Request $request,$id)
    {
        request()->validate(['name'=>['required','string','regex:/^[a-zA-Z\s\'\.]+$/','min:2','max:255'],
        'age'=>['required','integer','between:25,100'],
        'email'=>['required','email','unique:doctors,email,'.$id]]);

        $doctor=Doctor::find($id);
        
        $doctor->update(['name'=>$request->name,'age'=>$request->age,'email'=>$request->email,'specialization_id'=>$request->specialization]);

        return to_route('doctors.edit',$id)->with('success','you edited the data successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor = Doctor::find($id);

        $doctor->delete();
        
        return redirect()->back()->with('success','Doctor deleted successfully');
    }
   
}