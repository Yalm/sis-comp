@extends('ecommerce.profile.layout')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <md-list class="md-double-line">
                <md-subheader>Cliente</md-subheader>
                <md-list-item>
                    <md-avatar>
                        <img src="/img/default-avatar.png" alt="People">
                    </md-avatar>
                    <div class="md-list-item-text">
                        <span>{{$order->customer->name}}</span>
                        <span>{{$order->customer->email}}</span>
                    </div>
                </md-list-item
                @if($order->shipping)
                <md-divider></md-divider>
                <md-subheader >Dirección de envío</md-subheader>
                <md-list-item >
                    <md-icon class="md-primary">location_searching @{{getDistrict()}}</md-icon>
                    <div class="md-list-item-text">
                        <span id="district" data-value="{{$order->shipping->district_id}}" >Distrito: @{{ districtP }}</span>
                        <span>Dirección: {{$order->shipping->address}}</span>
                    </div>
                </md-list-item>
                @else
                    <md-divider></md-divider>
                    <md-subheader >Dirección de envío</md-subheader>
                    <md-list-item >
                        <md-icon class="md-primary">store</md-icon>
                        <div class="md-list-item-text">
                            <span >Recoger en tienda</span>
                        </div>
                    </md-list-item>
                @endif
                <md-divider></md-divider>
                <md-subheader >Metodo de Pago</md-subheader>
                <md-list-item >
                    <md-icon class="md-primary">{{$order->payment->paymentType->md_icon}}</md-icon>
                    <div class="md-list-item-text">
                        <span >{{$order->payment->paymentType->name}}</span>
                    </div>
                </md-list-item>
            </md-list>
            @if($order->voucher)
            <md-button class="md-raised md-accent mt-3" href="{{ $order->voucher->link }}" target="_blank">
                <md-icon>picture_as_pdf</md-icon>
                Ver Boleta
            </md-button>
            @endif
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
                            <td class="text-right">S/{{$product->price}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @if($order->payment->amount == 0.00)
                        <tr class="cart-subtotal">
                            <th>SUBTOTAL</th>
                            <td>
                                <b class="amount">
                                    S/{{$order->getTotal()}}
                                </b>
                            </td>
                        </tr>
                        @if($order->shipping)
                        <tr class="cart-subtotal">
                            <th>ENVIO</th>
                            <td>
                                <b class="amount">
                                    S/ {{$order->shipping->price}}
                                </b>
                            </td>
                        </tr>
                        @endif
                        <tr class="order-total">
                            <th>TOTAL</th>
                            <td>
                                <span class="amount">
                                    @if($order->shipping)
                                        S/.{{$order->getTotal() + $order->shipping->price }}
                                    @else
                                        S/{{$order->getTotal()}}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @else
                        <tr class="cart-subtotal">
                            <th>SUBTOTAL</th>
                            <td>
                                <b class="amount">
                                    @if($order->shipping)
                                        S/{{$order->payment->amount - $order->shipping->price }}
                                    @else
                                        S/{{$order->payment->amount}}
                                    @endif
                                </b>
                            </td>
                        </tr>
                        @if($order->shipping)
                        <tr class="cart-subtotal">
                            <th>ENVIO</th>
                            <td>
                                <b class="amount">
                                    S/ {{$order->shipping->price}}
                                </b>
                            </td>
                        </tr>
                        @endif
                        <tr class="order-total">
                            <th>TOTAL</th>
                            <td>
                                <span class="amount">
                                    S/.{{$order->payment->amount}}
                                </span>
                            </td>
                        </tr>
                        @endif
                    </tfoot>

                </table>
            </div>
        </div>
        <a href="/profile/orders" class="d-flex align-items-center pt-3"><i class="material-icons">navigate_before</i><span>Atras</span></a>
    </div>
</div>
@endsection
