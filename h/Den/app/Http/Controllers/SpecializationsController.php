<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialization;

class SpecializationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specializations = Specialization::paginate(6);
        return view('admin.specailzations.show',['specializations'=>$specializations]) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.specailzations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate(['name'=>['required','string','regex:/^[a-zA-Z\s\'\.]+$/','min:2','max:255','unique:specializations,name']]);

        Specialization::create(['name'=>request()->name]);

        return to_route('specializations.index')->with('added','you added data successfully');
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
        $specialization = Specialization::find($id);

        if (!$specialization) {
            // If the id does not exist, redirect back with an error message
            return to_route('specializations.index')->with('error','Specialization you want to edit not found');
        }

        // If the id exists, show the edit view with the date data
        return view('admin.specailzations.edit',['specialization'=>$specialization]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        request()->validate(['name'=>['required','string','regex:/^[a-zA-Z\s\'\.]+$/','min:2','max:255','unique:specializations,name,'.$id]]);

        $specialization=Specialization::find($id);

        $specialization->update(['name'=>request()->name]);

        return to_route('specializations.edit',$id)->with('success','you edited the data successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Specialization = Specialization::find($id);

        $Specialization->delete();
        
        return redirect()->back()->with('success','Specialization deleted successfully');
    }
}
