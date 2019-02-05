@extends('layouts.login')
@section('content')
<div class="container">
    <form class="row d-flex justify-content-center pt-5" method="POST" action="{{ route('user.password.request') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <md-card class="col-lg-5 col-md-6 mt-5 col-11">
            <md-card-header>
                <div class="md-title">Restablecer contraseña</div>
            </md-card-header>
            <md-card-content>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <md-field class="{{ $errors->has('email') ? 'md-invalid' : '' }}">
                    <md-icon>email</md-icon>
                    <label>Dirección de correo electrónico</label>
                    <md-input type='email' name="email" value="{{ old('email') }}" required autofocus></md-input>
                    @if ($errors->has('email'))
                        <span class="md-error">{{ $errors->first('email') }}</span>
                     @endif
                </md-field>
                <md-field class="{{ $errors->has('password') ? 'md-invalid' : '' }}">
                    <md-icon>lock</md-icon>
                    <label>Contraseña </label>
                    <md-input type="password" name="password" required></md-input>
                    @if ($errors->has('password'))
                        <span class="md-error">{{ $errors->first('password') }}</span>
                    @endif
                </md-field>
                <md-field >
                    <md-icon>lock</md-icon>
                    <label>Confirmar Contraseña </label>
                    <md-input type="password" name="password_confirmation" required></md-input>
                </md-field>
                <p>¿Recuerdas tu contraseña? <a href="{{ route('user.login') }}">Iniciar Sesión</a></p>
            </md-card-content>
            <md-card-actions>
                <md-button class="md-raised md-primary" type="submit">Restablecer contraseña</md-button>
            </md-card-actions>
        </md-card>
    </form>
</div>
@endsection


