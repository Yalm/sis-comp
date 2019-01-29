@extends('layouts.ecommerce')

@section('content')
<div class="container pb-5 pt-4 contact">
    <div class="row pb-5">
        <div class="col-12 pb-4">
            <ul class="breadcrumb d-flex justify-content-end">
                <li class="item_list">
                    <a href="/">Inicio</a>
                </li>
                <li class="item_list">
                    <span> Contáctanos</span>
                </li>
            </ul>
        </div>
        <form class="col-md-6 contact-form" action="{{ url('/contact') }}"    method="post" >
            @csrf
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
			@endif
            <h2 class="text-center pb-4">Envía tu mensaje</h2>
            <div class="form-group from-siscom">
                <input type="email" class="input-siscom form-control" v-validate="'required|email'"
                    name="email" aria-label="Email" placeholder="Tu Correo*">
                <span class="focus-border" v-show="!errors.first('surnames')">
                    <i></i>
                </span>
                <span class="invalid-feedback" role="alert" v-show="errors.has('surnames')">
                    <strong>@{{ errors.first('surnames') }}</strong>
                </span>
            </div>
            <div class="form-group from-siscom">
                <textarea class="form-control input-siscom" id="exampleFormControlTextarea1" rows="5" name="message" placeholder="¿Cómo podemos ayudar?"></textarea>
                <span class="focus-border" v-show="!errors.first('plus_info')">
                    <i></i>
                </span>
                <span class="invalid-feedback" role="alert" v-show="errors.has('plus_info')">
                    <strong>@{{ errors.first('plus_info') }}</strong>
                </span>
            </div>
            <button type="submit" class="btn-siscom text-center check">
                ENVIAR
            </button>
        </form>
        <div class="col-md-6 contact-info">
            <div class="pb-3">
                <h5 class="d-flex align-items-center"><i class="material-icons">location_on</i><span class="ml-2">Dirección</span></h5>
                <p class="pl-4">JR.Loreto #594 - Huancayo</p>
            </div>

            <div class="pb-3">
                <h5 class="d-flex align-items-center"><i class="material-icons">phone</i><span class="ml-2">Hablemos</span></h5>
                <p class="pl-4">(064) 782433</p>
            </div>
            <div class="pb-5">
                <h5 class="d-flex align-items-center"><i class="material-icons">email</i><span class="ml-2">Soporte de venta</span></h5>
                <a class="pl-4">soporte@tiendassiscomp.com</a>
            </div>
        </div>
    </div>
</div>
@endsection
