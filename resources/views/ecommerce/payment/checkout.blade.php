@extends('layouts.ecommerce')
@section('content')
<checkout-component :products="{{$products}}" :total="{{$total_cart}}"></checkout-component>
@endsection
@section('myjsfile')
<script src="https://checkout.culqi.com/js/v3"></script>
@endsection
