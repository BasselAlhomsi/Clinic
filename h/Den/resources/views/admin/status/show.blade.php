@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Statuses Show Page</h1>
@stop

@section("content")

<div class=text-center>@if(session('success')) <h4>{{session('success')}}</h4>  @endif </div>

<div class=text-center>@if(session('failed')) <h4>{{session('failed')}}</h4>  @endif </div>

<div class=text-center>@if(session('not found')) <h4>{{session('not found')}}</h4>  @endif </div>


<div class=text-center>@if(session('error')) <h4>{{session('error')}}</h4> @endif </div>

<div class="row">
    <div class="col-md-12">
  
            <div class="card-body">
                <div class="text-center mb-3">
                    <a href="{{route('status.create')}}" class="btn btn-success">Create Status</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Condition</th>
                        <th scope="col">Test</th>
                        <th scope="col">Drugs</th>
                        <th scope="col">DateTime</th>
                        <th scope="col">User</th>
                        <th scope="col">Doctor</th>
                        <th scope="col">Specialization</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statuses as $status)
                        <tr>
                            <td>{{$status->condition_name}}</td>
                            <td>{{$status->test}}</td>
                            <td>{{$status->drugs}}</td>
                            <td>{{$status->date->datetime}}</td>
                            <td>{{$status->date->patient->name}}</td>
                            <td>{{$status->date->doctor->name}}</td>
                            <td>{{$status->date->doctor->specialization->name}}</td>
                            <td>
                                <a href="{{route('status.edit',$status->id)}}" class="btn btn-dark">Edit</a>
                                <!-- <form style="display:inline;" method="POST" action="{{route('status.delete',$status->id)}}"
                                onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $statuses->links() }}
                 </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this status?');
    }
</script>

@stop