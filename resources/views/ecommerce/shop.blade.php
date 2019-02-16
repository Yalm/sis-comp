@extends('layouts.ecommerce')

@section('content')
<shop-component :maxp="{{$max ? $max:100}}" @count="count = $event" :categories="{{$providerCategories}}"></shop-component>
@endsection
