<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\State;
use App\Payment;
use App\Product;
use App\Voucher;
use GuzzleHttp\Client;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax() && $request->json)
        {
            $orders = Order::latest()->search($request->search)->paginate(7);
            $orders->each(function($order){
                $order->customer;
                $order->state;
                $order->payment;
                if($order->payment->amount == 0.00){
                    $order->payment->amount = $order->getTotal();
                }
                $order->date = $order->created_at->format('F d \,\ Y ');
            });
            return response()->json($orders,200);
        }else{
            return view('dashboard.order.index');
        }
    }

    public function edit($id)
    {
        $states = State::all();
        $order = Order::findOrFail($id);
        $order->customer;
        $order->products;
        $order->payment;
        $order->shipping;
        $order->voucher;
        $order->payment->paymentType;
        $order->payment->date = $order->payment->updated_at->format('F d \,\ Y ');
        if($order->payment->amount == 0.00){
            $order->total = $order->getTotal();
        }
        return view('dashboard.order.edit',['states' => $states,'order' => $order]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->plus_info = $request->plus_info;

        if($order->state_id != 2 && $request->state_id == '2')
        {
            $products = $order->products;
            foreach($products as $product)
            {
                if($product->pivot->quantity > $product->stock)
                {
                    return response()->json(['message' => "Producto: $product->name (stock:$product->stock) sobrepaso su stock"],409);
                }
            }
            foreach($products as $product)
            {
                $productUpdate = Product::findOrFail($product->id);
                $productUpdate->stock = $productUpdate->stock - $product->pivot->quantity;
                $productUpdate->save();
            }

            $payment = Payment::find($order->id);
            $total = $order->getTotal();
            if($order->shipping){
                $payment->amount = $total + $order->shipping->price;
            }else{
                $payment->amount = $total;
            }
            $payment->save();
            $this->createBoleta($products,$total,$order);
        }

        $order->state_id = $request->state_id;
        $order->save();
        $order->customer;
        $order->products;
        $order->payment;
        $order->shipping;
        $order->payment->paymentType;
        $order->payment->date = $order->payment->updated_at->format('F d \,\ Y ');
        $order->voucher;
        return response()->json($order);
    }
    private function createBoleta($cart,$totalOrder,$order){
        $collection = collect();
        $customer = $order->customer;
        $shipping = $order->shipping ? $order->shipping->price:0.00;

        foreach($cart as $product)
        {
            $valor_unitario = round(($product->price / 1.18),2);
            $total = $product->price * $product->pivot->quantity;

            $object = new \stdClass;
            $object->unidad_de_medida = 'NIU';
            $object->codigo = $product->id;
            $object->codigo_producto_sunat = '10000000';
            $object->descripcion = $product->name;
            $object->cantidad = $product->pivot->quantity;
            $object->valor_unitario = $valor_unitario;
            $object->precio_unitario = $product->price;
            $object->descuento = '';
            $object->subtotal = round(($total / 1.18),2);
            $object->tipo_de_igv = 1;
            $object->igv = round(($total - $valor_unitario),2);
            $object->total = $total;
            $object->anticipo_regularizacion = false;
            $object->anticipo_documento_serie = '';
            $object->anticipo_documento_numero = '';
            $collection->push($object);
        }

        $client = new Client();
        $res = $client->post(env('NUBEFACT_API_URL'), [
            'headers' => [
                'Authorization' => env('NUBEFACT_TOKEN'),
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                'operacion'           => 'generar_comprobante',
                'tipo_de_comprobante' => 2,
                'serie'               => 'BBB1',
                'numero'              => $order->id,
                'sunat_transaction'   => 12,
                'cliente_tipo_de_documento' => $customer->document_id,
                'cliente_numero_de_documento' => $customer->document_number,
                'cliente_denominacion' => "$customer->name $customer->surnames",
                'cliente_email' => $customer->email,
                'fecha_de_emision' => $order->payment->updated_at->format('Y-m-d'),
                'moneda' => 1,
                'porcentaje_de_igv' => 18,
                'total_igv' => round(($totalOrder - ($totalOrder / 1.18)),2),
                'total_gravada' => round(($totalOrder / 1.18),2),
                'total_otros_cargos' => $shipping == 0.00 ? '':$shipping,
                'total' => round(($totalOrder + $shipping),2),
                'enviar_automaticamente_a_la_sunat' => true,
                'enviar_automaticamente_al_cliente' => true,
                'items' => $collection->toArray()
            ]
        ]);

        $res = json_decode($res->getBody());

        $voucher = new Voucher;
        $voucher->order_id = $order->id;
        $voucher->payment_voucher_id = 2;
        $voucher->serie = $res->serie;
        $voucher->number = $res->numero;
        $voucher->link = $res->enlace_del_pdf;
        $voucher->save();

        return $res;
    }
}
