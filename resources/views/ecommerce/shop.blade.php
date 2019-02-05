@extends('layouts.ecommerce')

@section('content')
<shop-component :maxp="{{$max}}" @count="count = $event" :categories="{{$providerCategories}}"></shop-component>
@endsection
