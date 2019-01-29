@extends('ecommerce.profile.layout')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h5 class="my-3"><b>Cliente</b></h5>
            <div class="media">
                <div class="col-md-4 col-4">
                    <img class="img-fluid rounded-circle" src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png" alt="Generic placeholder image">
                </div>
                <div class="media-body">
                    <h5 class="mt-0 text-capitalize">{{ $order->customer->name }} <small><i>{{ $order->customer->phone }}</i></small></h5>
                    {{ $order->customer->email }}<br>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="checkout-review-order">
                <table class="table_ch cl5">
                    <thead>
                        <tr>
                            <th>PRODUCTO</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $product)
                        <tr class="cart_items">
                            <td class="text_comer_h">{{ $product->name . ' x ' .$product->pivot->quantity }}</td>
                            <td class="text-right">S/. {{ "S/. $product->price"}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="cart-subtotal">
                            <th>SUBTOTAL</th>
                            <td>
                                <b class="amount">
                                    S/{{$order->amount}}
                                </b>
                            </td>
                        </tr>
                        <tr class="order-total">
                            <th>TOTAL</th>
                            <td>
                                <span class="amount">
                                    S/.{{$order->amount}}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <a href="/profile/orders" class="d-flex align-items-center"><i class="material-icons">navigate_before</i><span>Atras</span></a>
    </div>
</div>
@endsection
