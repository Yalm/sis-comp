@extends('layouts.ecommerce')
@section('content')
<div class="container profile">
    <div class="row">
        <div class="col-md-3">
            <ul class="list-link-profile">
                <li><a href="{{ url('profile') }}">Inicio</a></li>
                <li><a href="{{ url('profile/orders') }}">Pedidos</a></li>
                <li><a href="{{ url('profile/account') }}" >Detalles de la cuenta</a></li>
                <li><a  href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Cerrar Sesión</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            @yield('main')
        </div>
    </div>
</div>
@endsection
