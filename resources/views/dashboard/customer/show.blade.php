@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="page-titles d-flex justify-content-between align-items-center">
            <h5 class="page-title">Ver datos del cliente</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-dark" href="/admin">Inicio</a></li>
                <li class="breadcrumb-item"><a class="text-dark">Ver datos del cliente</a></li>
            </ul>
        </div>
        <md-card class="col-12">
            <md-card-header>
                <div class="md-title">Datos del cliente</div>
            </md-card-header>
            <md-card-content class="form-row">
                <div class="col-md-6">
                    <md-field>
                        <md-icon>face</md-icon>
                        <label>Nombre</label>
                        <md-input :disabled="true" value="{{$customer->name}}" maxlength="191"></md-input>
                    </md-field>
                </div>
                <div class="col-md-6">
                    <md-field>
                        <md-icon>face</md-icon>
                        <label>Apellidos</label>
                        <md-input :disabled="true" value="{{$customer->surnames}}" maxlength="191"></md-input>

                    </md-field>
                </div>
                <md-field>
                    <md-icon>email</md-icon>
                    <label>Correo</label>
                    <md-input :disabled="true" value="{{$customer->email}}" maxlength="191"></md-input>
                </md-field>
                <div class="col-md-6">
                    <md-field>
                        <md-icon>account_box</md-icon>
                        <label>Documento</label>
                        <md-input :disabled="true" value="{{$customer->document->name}}"></md-input>
                    </md-field>
                </div>
                <div class="col-md-6">
                    <md-field>
                        <md-icon>ballot</md-icon>
                        <label>Numero de documento</label>
                        <md-input :disabled="true" value="{{$customer->document_number}}"></md-input>
                    </md-field>
                </div>
                <md-table class="w-100">
                    <md-table-toolbar class="pl-1">
                        <h1 class="md-title">Pedidos</h1>
                    </md-table-toolbar>

                    <md-table-row>
                        <md-table-head md-numeric>Numero de pedido</md-table-head>
                        <md-table-head>Estado</md-table-head>
                        <md-table-head >Fecha</md-table-head>
                        <md-table-head md-numeric>Monto</md-table-head>
                        <md-table-head>Acciones</md-table-head>
                    </md-table-row>
                    @foreach ($customer->orders as $order)
                        <md-table-row>
                            <md-table-cell md-numeric>{{$order->id}}</md-table-cell>
                            <md-table-cell class="let {{ $order->getColorState() }}">{{$order->state->name}}</md-table-cell>
                            <md-table-cell class="let">{{$order->date}}</md-table-cell>
                            <md-table-cell md-numeric>S/ {{$order->payment->amount}}</md-table-cell>
                            <md-table-cell>
                                <md-button  href="{{ url("/admin/orders/$order->id/edit") }}" class="md-icon-button"><md-icon>edit</md-icon></md-button>
                            </md-table-cell>
                        </md-table-row>
                    @endforeach
                </md-table>
            </md-card-content>
            <md-card-actions>
                <md-button href="{{$orderRequest ? "/admin/orders/$orderRequest/edit":'/admin/customers' }}">Atras</md-button>
            </md-card-actions>
        </md-card>
    </div>
</div>
@endsection
