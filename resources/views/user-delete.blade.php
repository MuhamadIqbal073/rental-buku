@extends('layouts.mainlayout')

@section('title', 'Delete Category')

    
@section('content')
    <h2>Are you sure to delete user? {{$user->username}} ?</h2>
    <div class="mt-5">
        <a href="/user-destroy/{{$user->slug}}" class="btn btn-danger me-5">Yes</a>
        <a href="/users" class="btn btn-warning">No</a>
    </div>
    
@endsection 