@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 style="text-align: center;">Ratings Page</h1>
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

            <form method="POST" action="{{ route('ratings.store')}}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <input type="text" name="rating" class="form-control" value="{{ old('rating') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" value="{{ old('description') }}">
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