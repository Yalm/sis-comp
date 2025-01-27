@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="page-titles d-flex justify-content-between align-items-center">
            <h5 class="page-title">Listado de pedidos</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-dark" href="/admin">Inicio</a></li>
                <li class="breadcrumb-item"><a class="text-dark">Listado de pedidos</a></li>
            </ul>
        </div>
        <order-table-component name="pedido" link="orders"></order-table-component>
    </div>
</div>
@endsection
