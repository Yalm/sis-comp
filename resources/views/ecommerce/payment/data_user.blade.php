@extends('layouts.ecommerce')
@section('content')
<div class="container pb-5 pt-5">
    <form action="{{ url('/account/complete-profile') }}" class="row" method="POST">
        @csrf
        <div class="col-12">
            <h2 class="section-title-3"><i class="ti-user"></i> COMPLETA TU INFORMACIÓN</h2><hr>
            <p>Antes de empezar, necesitamos que nos ayudes proporcionando información necesaria para que puedas completar tus compras.</p>
        </div>
        <div class="col-md-6">
            <div class="form-group from-siscom">
                <input type="text" class="input-siscom form-control"
                    name="name" aria-label="Nombre" required placeholder="Nombre*"  v-validate="'required|min:3|alpha_spaces'" value="{{$customer->name}}"
                    autofocus>
                <span class="focus-border" v-show="!errors.first('name')">
                    <i></i>
                </span>
                <span class="invalid-feedback" role="alert" v-show="errors.has('name')">
                    <strong>@{{ errors.first('name') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group from-siscom">
                <input type="text" class="input-siscom form-control" v-validate="'required|min:3|alpha_spaces'" value="{{$customer->surnames}}"
                    name="surnames" aria-label="Apellidos" placeholder="Apellidos*">
                <span class="focus-border" v-show="!errors.first('surnames')">
                    <i></i>
                </span>
                <span class="invalid-feedback" role="alert" v-show="errors.has('surnames')">
                    <strong>@{{ errors.first('surnames') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group from-siscom">
                <input type="text" class="input-siscom form-control"
                    name="phone" aria-label="TELEFONO/CELULAR*"  v-validate="{ required: true, regex:/^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g }" placeholder="TELEFONO/CELULAR*" value="{{$customer->phone}}">
                <span class="focus-border" v-show="!errors.first('phone')">
                    <i></i>
                </span>
                <span class="invalid-feedback" role="alert" v-show="errors.has('phone')">
                    <strong>@{{ errors.first('phone') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group from-siscom">
                <select class="form-control input-siscom select" placeholder="DOCUMENTO DE IDENTIDAD*" name="type_document" v-validate="'required'">
                    @foreach ($documents as $document)
                        @if ($customer->document_id == $document->id)
                            <option selected="true" value="{{ $document->id }}">{{ $document->name}}</option>
                        @else
                            <option value="{{ $document->id }}">{{ $document->name}}</option>
                        @endif
                    @endforeach
                </select>
                <span class="focus-border" v-show="!errors.first('type_document')">
                    <i></i>
                </span>
                <span class="invalid-feedback" role="alert" v-show="errors.has('type_document')">
                    <strong>@{{ errors.first('type_document') }}</strong>
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group from-siscom">
                <input type="text" class="input-siscom form-control"
                    name="document_number" aria-label="NUMERO DE DOCUMENTO" required placeholder="NUMERO DE DOCUMENTO*" v-validate="'required|alpha_num|min:8'">
                <span class="focus-border" v-show="!errors.first('document_number')">
                    <i></i>
                </span>
                <span class="invalid-feedback" role="alert" v-show="errors.has('document_number')">
                    <strong>@{{ errors.first('document_number') }}</strong>
                </span>
            </div>
        </div>
        <input name="_method" type="hidden" value="PUT">
        <div class="col-12 pb-5">
            <button type="submit" :disabled="errors.any()" class="btn-siscom">Iniciar Sesión</button>
        </div>
    </form>
</div>
@endsection
