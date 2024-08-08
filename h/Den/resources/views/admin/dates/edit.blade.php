@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1 style="text-align: center;">Dates Page</h1>
@stop

@section('content')

<div class=text-center>@if(session('failed')) <h5>{{session('failed')}}</h5> @endif </div>


<div class=text-center>@if(session('success')) <h5>{{session('success')}}</h5> @endif </div>


<div class="text-center">@if(session('booking')) <h4>{{ session('booking') }}</h4> @endif </div>
    @if(session('conflictingDates'))
        <div class="text-center">
        <h4>Appointments for Doctor : {{$date->doctor->name}}on Date : {{session('datetime')->format('Y-m-d')}} </h4>
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


<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
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
                <h3 class="card-title">Edit</h3>
            </div>

            
        <form method="POST" action="{{route('dates.update',$date->id)}}">
            @csrf
            <div class="card-body">
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" name="datetime" class="form-control" id="exampleFormControlInput1" value="{{$date->datetime}}">
                        </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop