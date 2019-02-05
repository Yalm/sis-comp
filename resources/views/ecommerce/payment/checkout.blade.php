@extends('layouts.ecommerce')
@section('content')

<checkout-component culqui="{{$culqi_pk_public}}" :products="{{$products}}" :total="{{$total_cart}}" :token="tokenCulqui"></checkout-component>
@endsection
@section('myjsfile')
<script src="https://checkout.culqi.com/js/v3"></script>
@endsection
