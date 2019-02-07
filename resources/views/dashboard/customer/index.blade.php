@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="page-titles d-flex justify-content-between align-items-center">
            <h5 class="page-title">Listado de clientes</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-dark" href="/admin">Inicio</a></li>
                <li class="breadcrumb-item"><a class="text-dark" href="admin">Listado de clientes</a></li>
            </ul>
        </div>
        <div class="col-12 pl-0 pr-0">
            <customer-component :data="{{$customers}}"></customer-component>
        </div>
    </div>
</div>
@endsection
