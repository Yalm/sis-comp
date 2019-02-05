@extends('ecommerce.profile.layout')
@section('main')
<div class="container-fluid">
    <form action="{{ route('changeDataCustomer') }}" class="row" method="POST">
        @csrf
        @if (session('successCustomer'))
        <div class="alert alert-success col-md-12">
            {{ session('successCustomer') }}
        </div>
        @endif
        <input type="hidden" name="email" value="{{ $customer->email }}">
        <input type="hidden" name="id" value="{{ $customer->id }}">
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
                    name="phone" aria-label="TELEFONO/CELULAR*"  v-validate="{ required: true,max:20, regex:/^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g }" placeholder="TELEFONO/CELULAR*" value="{{$customer->phone}}">
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
                    name="document_number" aria-label="NUMERO DE DOCUMENTO" required placeholder="NUMERO DE DOCUMENTO*" value="{{ $customer->document_number }}" v-validate="'required|alpha_num|min:8'">
                <span class="focus-border" v-show="!errors.first('document_number')">
                    <i></i>
                </span>
                <span class="invalid-feedback" role="alert" v-show="errors.has('document_number')">
                    <strong>@{{ errors.first('document_number') }}</strong>
                </span>
            </div>
        </div>
        <input name="_method" type="hidden" value="PUT">
        <div class="col-12">
            <button type="submit" :disabled="errors.any()" class="btn-siscom">Actualizar datos</button>
        </div>
    </form>
    <form method="POST" action="{{ route('changePassword') }}">
    @csrf
        <h1 class="title-change-password">CAMBIO DE CONTRASEÑA</h1>
        @if (session('error'))
        <div class="alert alert-danger col-12">
            {{ session('error') }}
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success col-12">
            {{ session('success') }}
        </div>
        @endif
        <div class="form-group from-siscom">
            <input type="password" class="input-siscom form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}"
                name="current-password" placeholder="CONTRASEÑA ACTUAL" aria-label="CONTRASEÑA ACTUAL" required>
            @if ($errors->has('current-password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('current-password') }}</strong>
            </span>
            @else
            <span class="focus-border">
                <i></i>
            </span>
            @endif
        </div>
        <div class="form-group from-siscom">
            <input type="password" class="input-siscom form-control{{ $errors->has('new-password') ? ' is-invalid' : '' }}"
                name="new-password" placeholder="NUEVA CONTRASEÑA" aria-label="NUEVA CONTRASEÑA" required>
            @if ($errors->has('new-password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('new-password') }}</strong>
            </span>
            @else
            <span class="focus-border">
                <i></i>
            </span>
            @endif
        </div>
        <div class="form-group from-siscom">
            <input type="password" class="input-siscom form-control{{ $errors->has('new-password_confirmation') ? ' is-invalid' : '' }}"
                name="new-password_confirmation" placeholder="NUEVA CONTRASEÑA" aria-label="CONFIRMAR NUEVA CONTRASEÑA" required>
            @if ($errors->has('new-password_confirmation'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('new-password_confirmation') }}</strong>
            </span>
            @else
            <span class="focus-border">
                <i></i>
            </span>
            @endif
        </div>
        <button type="submit" :disabled="errors.any()" class="btn-siscom">Actualizar contraseña</button>

    </form>
</div>
@endsection
