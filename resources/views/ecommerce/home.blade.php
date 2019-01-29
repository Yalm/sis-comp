@extends('layouts.ecommerce')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-3 col-md-4 categories-home">
            <h2 class="categorie-title">Categorías</h2>
            <ul class="categorie-list">
                @foreach ($providerCategories as $category)
                <li class="categorie-item d-flex justify-content-between">
                    <a href="/shop?category={{$category->id}}" class="">{{ $category->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-xl-9 col-md-8">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="https://firebasestorage.googleapis.com/v0/b/yalm-94feb.appspot.com/o/sliders%2FSin-t%C3%ADtulo-2.jpg?alt=media&token=5c5fc2cf-d276-46d3-980c-429a950a8d11"
                            alt="First slide">
                        <div class="carousel-caption">
                            <h3>Monitor Samsung "27" LED Curved</h3>
                            <p>Descubre una experiencia de visualización realmente envolvente con el monitor curvo de Samsung.</p>
                            <a routerLink="/">COMPRA AHORA</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://firebasestorage.googleapis.com/v0/b/yalm-94feb.appspot.com/o/sliders%2FSin-t%C3%ADtulo-1.jpg?alt=media&token=aaba7eb6-48bf-469d-bd2e-1818408c9b69"
                            alt="Second slide">
                        <div class="carousel-caption">
                            <h3>Monitor Samsung "27" LED Curved</h3>
                            <p>Descubre una experiencia de visualización realmente envolvente con el monitor curvo de Samsung.</p>
                            <a routerLink="/">COMPRA AHORA</a>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <h4 class="module-title text-center">
                        <span>Nuevos Productos</span>
                    </h4>
                </div>
                @foreach ($products as $product)
                <div class="col-xl-3 col-md-4 col-6">
                    <product-component :product="{{$product}}" @count="count = $event"></product-component>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
