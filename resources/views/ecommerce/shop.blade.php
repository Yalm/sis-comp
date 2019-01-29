@extends('layouts.ecommerce')

@section('content')
<shop-component :categories="{{$providerCategories}}"  {{ $categorySearch ? (":categoryse=$categorySearch") :'' }}  {{ $search ? (":search='$search'"):'' }} ></shop-component>
@endsection
