@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Specializations Show Page</h1>
@stop

@section("content")

<div class=text-center>@if(session('error')) <h4>{{session('error')}}</h4> @endif </div>

<div class=text-center>@if(session('added')) <h4>{{session('added')}}</h4> @endif </div>

<div class="row">
    <div class="col-md-12">
  
            <div class="card-body">
                <div class="text-center mb-3">
                    <a href="{{route('specializations.create')}}" class="btn btn-success">Create Specialization</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($specializations as $specialization)
                        <tr>
                            <td>{{$specialization->name}}</td>
                            <td>
                                <a href="{{route('specializations.edit',$specialization->id)}}" class="btn btn-dark">Edit</a>
                                <!--<form style="display:inline;" method="POST" action="{{route('specializations.delete',$specialization->id)}}"
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
                    {{ $specializations->links() }}
                 </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this specialization?');
    }
</script>

@stop