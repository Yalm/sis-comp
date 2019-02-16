@extends('layouts.login')
@section('content')
<div class="container">
    <form class="row d-flex justify-content-center pt-5" method="POST" action="{{ route('user.login.submit') }}">
        @csrf
        <md-card class="col-lg-5 col-md-6 mt-5 col-11">
            <md-card-header>
                <div class="md-title">INGRESE A SU CUENTA</div>
            </md-card-header>
            <md-card-content>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
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
                    @if ($errors->has('email'))
                        <span class="md-error">{{ $errors->first('email') }}</span>
                    @endif
                </md-field>
                <a href="{{ route('user.password.request') }}">¿Olvidaste tu contraseña?</a>
            </md-card-content>
            <md-card-actions>
                <md-button class="md-raised md-primary" type="submit">Iniciar Sesión</md-button>
            </md-card-actions>
        </md-card>
    </form>
</div>
@endsection


