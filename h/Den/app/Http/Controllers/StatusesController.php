<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Date;


class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = Status::paginate(4);
        return view('admin.status.show',['statuses'=>$statuses]) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dates = Date::all();
        return view('admin.status.create',['dates'=>$dates]) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate(['condition'=>['required','string','regex:/^[a-zA-Z0-9\s\'\,\.]+$/','max:255'],
        'test'=>['required','string','regex:/^[a-zA-Z\s\'\,\.]+$/','max:255'],
        'drugs'=>['required','string','regex:/^[a-zA-Z\s\'\,\.]+$/','max:255']]);

        $condition=request()->condition;
        $test=request()->test;
        $drugs=request()->drugs;
        $datetime=request()->datetime;

        $exists=Status::where('date_id',$datetime)->exists();


        if($exists)
        {
            return to_route('status.create')->with('failed','Condition did not Add');
        }
        
        Status::create(['condition_name'=>$condition,'test'=>$test,'drugs'=>$drugs,'date_id'=>$datetime]);
        return to_route('status.index')->with('success','Condition Added Successfully');
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
        $status = Status::find($id);
        
        if (!$status) 
        {
            return to_route('status.index')->with('error','Status you want to edit not found');
        }
        return view("admin.status.edit",['status'=>$status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        request()->validate(['condition'=>['required','string','regex:/^[a-zA-Z0-9\s\'\,\.]+$/','max:255'],
        'test'=>['required','string','regex:/^[a-zA-Z\s\'\,\.]+$/','max:255'],
        'drugs'=>['required','string','regex:/^[a-zA-Z\s\'\,\.]+$/','max:255']]);

        $condition=request()->condition;
        $test=request()->test;
        $drugs=request()->drugs;

        $status=Status::find($id);

        $status->update(['condition_name'=>$condition,'test'=>$test,'drugs'=>$drugs]);
        return to_route('status.edit',$id)->with('success','Status Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = Status::find($id);

        $status->delete();
        
        return redirect()->back()->with('success','Status deleted successfully');
    }
}
