@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="page-titles d-flex justify-content-between align-items-center">
            <h5 class="page-title">Listado de productos</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-dark" href="/admin">Inicio</a></li>
                <li class="breadcrumb-item"><a class="text-dark" href="admin">Listado de productos</a></li>
            </ul>
        </div>
        <table-component :data="{{$products}}" name="producto" link="products"></table-component>
    </div>
</div>
@endsection
