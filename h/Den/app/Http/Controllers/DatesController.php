<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Date;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Specialization;

class DatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Dates=Date::paginate(6);
        return view("admin.dates.show",["dates"=>$Dates]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Patients=Patient::all();
        $Doctors=Doctor::all();
        return view("admin.dates.create",['patients'=>$Patients,'doctors'=>$Doctors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate(
            ['datetime'=>['required','date_format:Y-m-d H:i']
            ]);


        $datetime= Carbon::parse($request->datetime);
        $patient=request()->patient;
        $doctor=request()->doctor;

        // منتأكد إذا التاريخ الجديد بوقت اليوم الي عم نشتغل فيه و بالوقت الي نحن عم نضيف فيه 
        //و بعد يعني كل شي بأوقات او تواريخ مضيوا بيعطي إنه تاريخ أو وقت غير متاح لأنه مضي 

        if($datetime<Carbon::now())
        {
            return to_route('dates.create')->with('failed','this datetime was passed');
        }

        if ( ( $datetime->hour < 9) || ( $datetime->hour == 16 && $datetime->minute > 40 ) ) 
        {
            return to_route('dates.create')->with('close','The Clinic is Close in this time the Clinc open between 9 AM and 5 PM ');
        }

        if($datetime->hour >= 17)
        {
            return to_route('dates.create')->with('close','The Clinic is Close in this time the Clinc open between 9 AM and 5 PM ');
        }
        
        // تحقق من عدم تكرار اضافة أكثر  من موعد للمريض مع نفس الدكتور في نفس اليوم

        $existingDate = Date::whereDate('datetime',$datetime->toDateString())
        ->where('doctor_id', $doctor)
        ->where('patient_id', $patient)
        ->first();
        
        if ($existingDate) {
            return to_route('dates.create')->with('failed','Patient and Doctor cannot exist more than once in the same day');
        }

         // تحقق من وجود مواعيد للمريض مع دكاترة تانيين في نفس التاريخ والوقت

        $conflictingPatientDates = Date::whereDate('datetime', $datetime->toDateString())
        ->where('patient_id', $patient)
        ->where('doctor_id', '!=', $doctor)
        ->get();

        foreach ($conflictingPatientDates as $date) 
        {
             if(($datetime->diffInMinutes($date->datetime)) < 20)
             {
                return to_route('dates.create')->with('failed','you have appointment with another doctor');
             }    
         }

        $info = Date::whereDate('datetime',$datetime)
        ->where('doctor_id', $doctor)
        ->first();

        // هون يكون الموعد الي بدي ضيفه متاح بشوف بحال يكون الفرق بين موعد الزباين الحاجزة على مدار هاليوم
        //  و الي انا طالب حجزه 20 دقيقة إذا ما في شي مضارب بيحجز غير هيك ما رح يزبط حجزه و بيخليه يرجع يطلب موعد تاني

        $conflictingDates = Date::whereDate('datetime',$datetime->toDateString())
        ->where('doctor_id', $doctor)
        ->get();

        $c=0;

       foreach ($conflictingDates as $date) 
       {
            if(($datetime->diffInMinutes($date->datetime)) < 20)
            {
                $c++;   
            }
            $date->datetime=Carbon::parse($date->datetime)->format('H:i');             
        }

        if($c!=0)
        {
            return to_route('dates.create')->with(['booking'=>'Not Available Appointment','conflictingDates'=>$conflictingDates,
                'doctor'=>$info->doctor->name,'datetime'=>$datetime]);
        }

        Date::create([
            'datetime' => $datetime,
            'patient_id' => $patient,
            'doctor_id' => $doctor
        ]);
        
        return to_route('dates.index')->with('success','Date Added Successfully');
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
        $date = Date::find($id);
        
        if (!$date) 
        {
            return to_route('dates.index')->with('error','Date you want to edit not found');
        }

        $patients=Patient::all();
        $doctors=Doctor::all();

        return view("admin.dates.edit",['date'=>$date,'patients'=>$patients,'doctors'=>$doctors]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate(['datetime' => ['required','date_format:Y-m-d H:i']]);

        $newDateTime = Carbon::parse($request->datetime);
        
        $Date = Date::find($id);
        
        // منتأكد إذا التاريخ الجديد بوقت اليوم الي عم نشتغل فيه و بالوقت الي نحن عم نعدل فيه 
        //و بعد يعني كل شي بأوقات او تواريخ مضيوا بيعطي إنه تاريخ أو وقت غير متاح لأنه مضي 

        if($newDateTime<Carbon::now())
        {
            return to_route('dates.edit')->with('failed','this datetime was passed');
        }
        //  وفت فتح العيادة من الساعة 9 الصبح ل 5 المسا كل شي قبل 9 و بعد 5 ما بيزبط
        if ($newDateTime->hour < 9 || ( $newDateTime->hour == 16 && $newDateTime->minute > 40 ) )
        {
            return to_route('dates.edit',$id)->with('close','The Clinic is Close in this time the Clinc open between 9 AM , 5 PM ');
        }
    
         //  هون بشوف إذا المريض ما الو موعد مع الدكتور بنفس  اليوم الي عم اطلبه مشان عدل موعدي
         // إذا التقى موعد الي عنده ما بحجز أما اذا ما التقى بنزل عالحالة الي بعدها

        $my_appointemts_in_this_date = Date::whereDate('datetime',$newDateTime->toDateString())
            ->where('doctor_id', $Date->doctor_id)->where('patient_id',$Date->patient_id)
            ->where('id', '!=', $id)
            ->get();


        if(count($my_appointemts_in_this_date)!=0)
        {
            return to_route('dates.edit',$id)->with('failed','you have appointment in day you wanted, you cannot have more than once');
        }


        // التأكد من عدم وجود موعد آخر لنفس المريض مع أي طبيب آخر في نفس اليوم بفارق أقل من 20 دقيقة
 
        $otherDates = Date::whereDate('datetime', $newDateTime->toDateString())
       ->where('patient_id', $Date->patient_id)
        ->where('id', '!=', $id)
        ->get();

        foreach ($otherDates as $date) 
        {
            if ($newDateTime->diffInMinutes($date->datetime) < 20)
            {
                return to_route('dates.edit', $id)->with('failed', 'You have another appointment with another doctor that conflicts with this time.');
            }
        }

        //  هون بدل ما شوف كل شي مواعيد للدكتور الي بدي ياها باخد بس تواريخ اليوم
        // الي بدي عدل عليه لشوف هو فاضي بهل اليوم او لا بحال قرر زبون يعدل موعده


        $conflictingDates = Date::whereDate('datetime',$newDateTime->toDateString())
        ->where('doctor_id', $Date->doctor_id)
        ->where('id', '!=', $id)
        ->get();

        $c=0;

        foreach ($conflictingDates as $date)
        {
            if ($newDateTime->diffInMinutes($date->datetime) < 20) 
            {
                $c++;   
            }
            $date->datetime=Carbon::parse($date->datetime)->format('H:i');             
        }

        if($c!=0)
        {
            return to_route('dates.edit',$id)->with(['booking'=>'Not Available Appointment','conflictingDates'=>$conflictingDates,
                'datetime'=>$newDateTime]);
        }

        $Date->update(['datetime' => $newDateTime]);
    
        return to_route('dates.edit',$id)->with('success','Date Updated Successfully');

        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $date = Date::find($id);

        $date->delete();
        
        return redirect()->back()->with('success','Date deleted successfully');
    }
}
