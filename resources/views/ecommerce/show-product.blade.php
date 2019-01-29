@extends('layouts.ecommerce')

@section('content')
<div class="container">
    <div class="row product-info-section d-flex justify-content-center">
        <div class="col-12">
            <ul class="breadcrumb d-flex justify-content-end">
                <li class="item_list">
                    <a routerLink="/">Inicio</a>
                </li>
                <li class="item_list">
                    <a href="/shop?category={{$product->category->id}}">{{ $product->category->name  }}</a>
                </li>
                <li class="item_list">
                    <span> {{ $product->name  }}</span>
                </li>
            </ul>
        </div>
        <div class="col-lg-6">
            <img src="{{ $product->cover }}" class="img-fluid" alt="{{ $product->name }}">
        </div>
        <div class="col-lg-6 product-info-cotent">
            <a class="product-brand" href="/shop?category={{$product->category->id}}">{{ $product->category->name }}</a>
            <h1>{{ $product->name }}</h1>
            <div class="current-price">
                <span class="price">S/ {{ $product->price  }}</span>
            </div>
            <div class="description">
                <p>{{ $product->short_description }}</p>
            </div>
            <qty-component :product="{{$product}}" @add="count = $event"></qty-component>
        </div>
    </div>
</div>
<div class="tabs-container">
    <div class="page-width">
    <span class="tab-link">Descripción</span>
    <p class="text-center">{!! $product->description !!}</p>
    </div>
</div>
@endsection
