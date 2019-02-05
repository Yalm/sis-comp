@extends('layouts.ecommerce')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12  col-11 forgot-password">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <h2>Restablecer la contraseña</h2>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
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

                <md-field>
                    <md-icon>lock</md-icon>
                    <label>Confirmar Contraseña </label>
                    <md-input type="password" name="password_confirmation" required></md-input>
                </md-field>
                <md-button class="md-raised md-primary ml-0" type="submit">Restablecer la contraseña</md-button>
            </form>
        </div>
    </div>
</div>
@endsection
