@extends('layouts.ecommerce')

@section('content')
<cart-component :cart="{{$cart}}" :total="{{$total}}" @count="count = $event"></cart-component>
@endsection
