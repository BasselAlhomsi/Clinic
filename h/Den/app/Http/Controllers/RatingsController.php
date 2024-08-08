<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rating;
use App\Models\Date;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;


class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ratings=Rating::paginate(6);
        return view("admin.ratings.show",["ratings"=>$ratings]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dates = Date::all();
        return view("admin.ratings.create",["dates"=>$dates]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // كل الكود فكرته مشان يشوف اذا الموعد الي عم يجي من الفورم اول موعد او لا 

        request()->validate(['rating'=>['required','integer','min:1','max:5'],
        'description'=>['required','string','regex:/^[a-zA-Z\s\'\.]+$/','min:3','max:100']]);

        $rating=request()->rating;
        $description=request()->description;
        $datetime=request()->datetime;

        // الموجود بجدول المواعيد مع ال id  هون بطابق ال 
        // الي اجا من الفورم الاضافة و بطابق مشان جيب الموعد الي قاصده مشان قيمه  id 

        $NewElement = Date::where('id',$datetime)->first();
        
        // هون بجيب كل شي مواعيد للشخص و الدكتور الي بدي ياهن و برتب المواعيد بشكل تصاعدي و باخد اول موعد 

       $First_Datetime = Date::where('patient_id',$NewElement->patient_id)
                            ->where('doctor_id',$NewElement->doctor_id)
                            ->orderBy('datetime','asc')
                            ->first();
                

        // هون بشوف إذا اول موعد موجود عندي بالداتا و لا لا 
        // بتحقق اذا كان ما موجود اول موعد و كان المتحولين بيساووا بعض  بينضاف الموعد الي هو أول واحد بيكون غير هيك ما بضيف
        //   للمواعيد فنحن ما بيصير نرجع نحدث او نضيف مواعيد قديمة و هاد الكود بوضح هاد الشي عن طريق مقارنة اول موعد باخده بكل التقييمات  edit اذا عملنا 
        // عن طريق الربط
        $exists=Rating::where('date_id',$First_Datetime->id)->exists();

        if( ($datetime==$First_Datetime->id) && (!$exists) )
        {
            $ratings=Rating::all();
            foreach($ratings as $ratingg)
            {
               if(($First_Datetime->patient->name==$ratingg->date->patient->name) && ($First_Datetime->doctor->name==$ratingg->date->doctor->name)
                   && ($First_Datetime->datetime <= $ratingg->date->datetime))
               {
                    return to_route('ratings.create')->
                    with('failed','you cannot Rating Past Dates');
                }
            }
            Rating::create(['rating'=>$rating,'description'=>$description,'date_id'=>$datetime]);
            return to_route('ratings.index')->with('success','Rating Added Successfully');
        } 
        else
        {
            return to_route('ratings.create')->
            with('failed','Rating did not Add because not the first datetime or exist in database');
        }
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
        $rating = Rating::find($id);
        
        if (!$rating) 
        {
            return to_route('ratings.index')->with('error','Date you want to edit not found');
        }

        $date = Date::find($rating->date_id);

        $first_Datetime = Date::where('patient_id',$date->patient_id)
        ->where('doctor_id',$date->doctor_id)
        ->orderBy('datetime', 'asc')
        ->get();


        foreach($first_Datetime as $first_Datetimee)
        {
            if($first_Datetimee->datetime > $date->datetime)
            {
                return view("admin.ratings.edit",['rating'=>$rating,'date'=>$first_Datetimee]);
            }
        } 
        return to_route("ratings.index")->with('not found','No More Appointments To Update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        request()->validate(['rating'=>['required','integer','min:1','max:5'],
        'description'=>['required','string','regex:/^[a-zA-Z\s\'\.]+$/','min:3','max:100']]);

        $rating=request()->rating;
        $description=request()->description;
        $datetime=request()->datetime;

        $ratingg=Rating::find($id);

       $ratingg->update(['rating'=>$rating,'description'=>$description,'date_id'=>$datetime]);
        return to_route('ratings.edit',$id)->with('success','Rating Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rating = Rating::find($id);

        $rating->delete();
            
        return redirect()->back()->with('success','Rating deleted successfully');
      }
}
