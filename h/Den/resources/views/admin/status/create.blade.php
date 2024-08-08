@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 style="text-align: center;">Statuses Page</h1>
@stop

@section('content')

<div class=text-center>@if(session('close')) <h4>{{session('close')}}</h4>  @endif </div>

<div class=text-center>@if(session('failed')) <h4>{{session('failed')}}</h4> @endif </div>

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
                <h3 class="card-title">Create</h3>
            </div>

            <form method="POST" action="{{ route('status.store')}}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <div class="mb-3">
                            <label class="form-label">Condition</label>
                            <input type="text" name="condition" class="form-control" value="{{ old('condition') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label class="form-label">Test</label>
                            <input type="text" name="test" class="form-control" value="{{ old('test') }}">
                        </div>
                    </div>   
                    <div class="form-group">
                        <div class="mb-3">
                            <label class="form-label">Drugs</label>
                            <input type="text" name="drugs" class="form-control" value="{{ old('drugs') }}">
                        </div>
                    </div> 
                <div class="form-group">
                    <div class="mb-3">
                        <label class="form-label">DateTime</label>
                            <select name="datetime" class="form-control">
                                @foreach($dates as $date)
                                <option value='{{$date->id}}'>{{$date->datetime}} 
                                , User : {{$date->patient->name}}
                                , Doctor : {{$date->doctor->name}}  
                                , Special : {{ $date->doctor->specialization->name}} 
                                </option>
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