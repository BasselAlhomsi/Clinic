@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1 style="text-align: center;">Patients Page</h1>
@stop

@section('content')

<div class=text-center>@if(session('success')) <h5>{{session('success')}}</h5> @endif </div>


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

            
        <form method="POST" action="{{route('patients.update',$patient->id)}}">
            @csrf
            <div class="card-body">
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="{{$patient->name}}">
                        </div>
                </div>
                <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Age</label>
                            <input type="text" name="age" class="form-control" id="exampleFormControlInput1" value="{{$patient->age}}">
                        </div>
                </div>
                <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" id="exampleFormControlInput1" value="{{$patient->email}}">
                        </div>
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