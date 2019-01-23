@extends('layouts.ecommerce')

@section('content')
<cart-component :cart="{{$cart}}"></cart-component>
@endsection
