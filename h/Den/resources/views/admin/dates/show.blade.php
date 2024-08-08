@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dates Show Page</h1>
@stop

@section("content")

<div class=text-center>@if(session('success')) <h4>{{session('success')}}</h4>  @endif </div>

<div class=text-center>@if(session('failed')) <h4>{{session('failed')}}</h4>  @endif </div>


<div class=text-center>@if(session('error')) <h4>{{session('error')}}</h4> @endif </div>

<div class="row">
    <div class="col-md-12">
  
            <div class="card-body">
                <div class="text-center mb-3">
                    <a href="{{route('dates.create')}}" class="btn btn-success">Create Date</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">DateTime</th>
                            <th scope="col">Patient</th>
                            <th scope="col">Doctor</th>
                            <th scope="col">Specialization</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dates as $date)
                        <tr>
                            <td>{{$date->datetime}}</td>
                            <td>{{$date->patient->name}}</td>
                            <td>{{$date->doctor->name}}</td>
                            <td>{{$date->doctor->specialization->name}}</td>
                            <td>
                                <a href="{{route('dates.edit',$date->id)}}" class="btn btn-dark">Edit</a>
                              <!--  <form style="display:inline;" method="POST" action="{{route('dates.delete',$date->id)}}"
                                onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $dates->links() }}
                 </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this date?');
    }
</script>

@stop