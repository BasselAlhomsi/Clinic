@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Ratings Show Page</h1>
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
                    <a href="{{route('ratings.create')}}" class="btn btn-success">Create Rating</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Rate</th>
                            <th scope="col">Description</th>
                            <th scope="col">DateTime</th>
                            <th scope="col">Patient</th>
                            <th scope="col">Doctor</th>
                            <th scope="col">Specialization</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ratings as $rating)
                        <tr>
                            <td>{{$rating->rating}}</td>
                            <td>{{$rating->description}}</td>
                            <td>{{$rating->date->datetime}}</td>
                            <td>{{$rating->date->patient->name}}</td>
                            <td>{{$rating->date->doctor->name}}</td>
                            <td>{{$rating->date->doctor->specialization->name}}</td>
                            <td>
                                <a href="{{route('ratings.edit',$rating->id)}}" class="btn btn-dark">Edit</a>
                                <!-- <form style="display:inline;" method="POST" action="{{route('ratings.delete',$rating->id)}}"
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
                    {{ $ratings->links() }}
                 </div>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this rating?');
    }
</script>
@stop