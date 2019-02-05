@extends('layouts.ecommerce')

@section('content')
<div class="container pb-5 pt-5">
    <div class="row pb-5">
        <div class="col-md-6">
            <img class="img-fluid" src="{{ url('img/about.jpg') }}" alt="img_sis">
        </div>
        <div class="col-md-6">
            <h1 class="text-center">Sis & Comp </h1>
            <p class="text-center">- Tienda en Linea</p>
            <hr>
            <div class="row pt-2">
                <div class="col-6">
                    <h2>Misión</h2>
                    <p>Somos una empresa dedicada a la comercialización y distribución de productos informáticos, soluciones en Internet
                        ,servicio técnico y mantenimiento de equipos y sistemas informáticos Ofreciendo una solución e empresas,profesionales y usuarios particulares.
                    </p>
                </div>
                <div class="col-6">
                    <h2>Visión</h2>
                    <p>Pretendemos ser un referente en el mercado nacional en el sector de las TIC, y para ello abarcaremos todos los servicios que ofrecemos actualmente incrementando los que vayan
                        surgiendo debido a la necesidad de cambio provocado por los avances tecnológicos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
