@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Info About Us</h1>
@stop

@section("content")

<div class="row">
    <div class="col-md-12">
  
            <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Doctor</th>
                        <th scope="col">Specialization</th>
                        <th scope="col">Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                    <tr>
                        <td>{{$doctor->name}}</td>
                        <td>{{$doctor->specialization->name}}</td>
                        <td>{{ $doctor->average_rating ?? 'no ratings' }}<td>
                    </tr>
                    @endforeach
                </tbody>
            </table> 
            <div class="d-flex justify-content-center">
                {{ $doctors->links() }}
            </div>
        </div>
    </div>
</div>

@stop