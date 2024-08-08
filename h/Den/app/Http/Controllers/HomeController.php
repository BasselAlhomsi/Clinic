<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\Rating;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  
       
        $doctors = Doctor::with(['dates.ratings'])->paginate(5);     
        foreach($doctors as $doctor)
        {
            $ratings=$doctor->dates->flatMap->ratings;
            $doctor->average_rating = $ratings->avg('rating');
        }
        return view('home',compact('doctors'));
    }
}
