@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="page-titles d-flex justify-content-between align-items-center">
            <h5 class="page-title">Crear Nuevo Producto</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-dark" href="/admin">Inicio</a></li>
                <li class="breadcrumb-item"><a class="text-dark" href="/admin/products">Listado de productos</a></li>
                <li class="breadcrumb-item"><span class="text-dark">Crear Nuevo Producto</span></li>
            </ul>
        </div>
        <div class="col-12 p-0">
            <div class="container-fluid">
                <product-component :categoriesp="{{$categories}}"></product-component>
            </div>
        </div>
    </div>
</div>
@endsection
