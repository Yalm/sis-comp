@extends('ecommerce.profile.layout')
@section('main')
<div class="form-row p-tb-10">
    @if($orders->isEmpty())
    <a href="{{ url('shop') }}"class="btn-siscom">IR A LA TIENDA</a>
    <h2 class="col-md-9 stext-101 p-t-10">No se ha hecho ningún pedido todavía.</h2>
    @else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Pedido #</th>
                    <th scope="col">Fecha de Pedido</th>
                    <th scope="col">Estado de su pedido</th>
                    <th scope="col">Monto de su Pedido</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="text-center">
                    <th scope="row" class="text-uppercase text-truncate" style="max-width: 280px;">#{{ $order->id }}</th>
                    <td class="text-capitalize">{{ $order->created_at->format('F d \,\ Y ')  }}</td>
                    <td class="text-capitalize {{ $order->getColorState() }}" id="tdstate{{$order->id}}" >{{ $order->state->name }}</td>
                    @if($order->payment->amount == 0.00)
                        <td>S/ {{$order->getTotal() }}</td>
                    @else
                        <td>S/ {{ $order->payment->amount }}</td>
                    @endif
                    <td>
                        <md-button class="md-icon-button" href="{{ url('profile/orders',$order->getIdFormat() ) }}">
                            <md-icon>remove_red_eye</md-icon>
                        </md-button>
                        @if($order->state_id == 4)
                        <md-button class="md-icon-button" @click="deleteOrder({{$order->id}})" id="btn{{$order->id}}">
                            <md-icon>delete</md-icon>
                        </md-button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <div class="col-12">
        @if(count($orders))
            <div class="d-flex justify-content-center">
                {{ $orders->links('pagination::bootstrap-4') }}
            </div>
        @endif
	</div>
</div>
@endsection
