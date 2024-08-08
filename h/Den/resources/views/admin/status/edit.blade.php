@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1 style="text-align: center;">Status Page</h1>
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

            
        <form method="POST" action="{{route('status.update',$status->id)}}">
            @csrf
            <div class="card-body">
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Condition</label>
                            <input type="text" name="condition" class="form-control" id="exampleFormControlInput1" value="{{$status->condition_name}}">
                        </div>
                </div>

                <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Test</label>
                            <input type="text" name="test" class="form-control" id="exampleFormControlInput1" value="{{$status->test}}">
                        </div>
                </div>

                <div class="form-group">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Drugs</label>
                            <input type="text" name="drugs" class="form-control" id="exampleFormControlInput1" value="{{$status->drugs}}">
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