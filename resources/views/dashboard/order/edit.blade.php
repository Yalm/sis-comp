@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <order-component :states="{{$states}}" :orderp="{{$order}}"></order-component>
</div>
@endsection
