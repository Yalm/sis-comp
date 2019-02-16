@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="page-titles d-flex justify-content-between align-items-center">
            <h5 class="page-title">Listado de usuarios</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-dark" href="/admin">Inicio</a></li>
                <li class="breadcrumb-item"><a class="text-dark">Listado de usuarios</a></li>
            </ul>
        </div>
        <md-card class="col-12">
            <user-component :data="{{$users}}"></user-component>
        </md-card>
    </div>
</div>
@endsection
