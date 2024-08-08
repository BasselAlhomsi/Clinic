@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1 style="text-align: center;">Ratings Page</h1>
@stop

@section('content')

<div class=text-center>@if(session('failed')) <h5>{{session('failed')}}</h5> @endif </div>


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

            
        <form method="POST" action="{{route('ratings.update',$rating->id)}}">
            @csrf
            <div class="card-body">
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Rating</label>
                            <input type="text" name="rating" class="form-control" id="exampleFormControlInput1" value="{{$rating->rating}}">
                        </div>
                </div>

                <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" id="exampleFormControlInput1" value="{{$rating->description}}">
                        </div>
                </div>

                <div class="form-group">
                    <div class="mb-3">
                        <label class="form-label">DateTime</labe>
                            <select name="datetime" class="form-control">
                                <option value="{{$date->id}}">{{$date->datetime}}</option>
                            </select>
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