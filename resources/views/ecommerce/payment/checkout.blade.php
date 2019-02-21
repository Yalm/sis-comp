@extends('layouts.ecommerce')
@section('content')

<checkout-component @count="count = $event" culqui="{{$culqi_pk_public}}" :products="{{$products}}" :total="{{$total_cart}}" :token="tokenCulqui" :payments="{{$payments}}"></checkout-component>
@endsection
@section('myjsfile')
<script src="https://checkout.culqi.com/js/v3"></script>
@endsection
