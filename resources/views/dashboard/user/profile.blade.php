@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <profile-component :user="{{$user}}" ></profile-component>
</div>
@endsection
