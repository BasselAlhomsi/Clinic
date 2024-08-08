@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dates Page</h1>
@stop

@section('content')

<div class=text-center>@if(session('close')) <h4>{{session('close')}}</h4>  @endif </div>

<div class=text-center>@if(session('failed')) <h4>{{session('failed')}}</h4> @endif </div>

<div class="text-center">@if(session('booking')) <h4>{{ session('booking') }}</h4> @endif </div>
    @if(session('conflictingDates'))
        <div class="text-center">
        <h4>Appointments for Doctor : {{session('doctor')}} on Date : {{session('datetime')->format('Y-m-d')}} </h4>
        <ul>
            @foreach(session('conflictingDates') as $appointment)
                @if($loop->iteration % 5 == 1 && $loop->iteration != 1)
                    <br>
                @endif
                {{ $loop->iteration }} ) {{$appointment->datetime}} 
            @endforeach
        </ul>
    </div>
@endif

<div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-6">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create</h3>
            </div>

            <form method="POST" action="{{ route('dates.store')}}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <div class="mb-3">
                            <label class="form-label">DateTime</label>
                            <input type="text" name="datetime" class="form-control" value="{{ old('datetime') }}">
                        </div>
                    </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label class="form-label">Patient</label>
                            <select name="patient" class="form-control">
                                @foreach($patients as $patient)
                                    <option value="{{$patient->id}}">{{$patient->name}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label class="form-label">Doctor</label>
                            <select name="doctor" class="form-control">
                                @foreach($doctors as $doctor)
                                    <option value="{{$doctor->id}}">Doctor : {{$doctor->name}} ,
                                        Specialization : {{$doctor->Specialization->name}} </option>
                                @endforeach
                            </select>
                        </div>
                </div>
            </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div> 
    </div>
</div>
@stop