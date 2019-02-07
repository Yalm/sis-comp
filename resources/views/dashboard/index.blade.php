@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-between">
        <md-card class="col-md-3">
            <md-card-header>
                <md-card-header-text>
                    <div class="md-title">Pedidos</div>
                    <div class="md-subhead">{{$orderCount}}</div>
                </md-card-header-text>

                <md-card-media>
                    <md-icon class="md-size-3x">shopping_basket</md-icon>
                </md-card-media>
            </md-card-header>
        </md-card>
        <md-card class="col-md-3">
            <md-card-header>
                <md-card-header-text>
                    <div class="md-title">Clientes</div>
                    <div class="md-subhead">{{$customersCount}}</div>
                </md-card-header-text>

                <md-card-media>
                    <md-icon class="md-size-3x">group</md-icon>
                </md-card-media>
            </md-card-header>
        </md-card>
        <md-card class="col-md-3">
            <md-card-header>
                <md-card-header-text>
                    <div class="md-title">Productos</div>
                    <div class="md-subhead">{{$productsCount}}</div>
                </md-card-header-text>

                <md-card-media>
                    <md-icon class="md-size-3x">archive</md-icon>
                </md-card-media>
            </md-card-header>
        </md-card>
    </div>
</div>
@endsection
