<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Culqi\Culqi;
use App\Order;
use App\Product;
use App\User;
use App\Payment;
use App\Voucher;
use GuzzleHttp\Client;
use App\PaymentType;
use App\Shipping;

class PaymentController extends Controller
{
    public function checkout()
	{
		$products = \Cart::getContent();
        $total_cart = \Cart::getTotal();
        $culqi_pk_public = env('CULQUI_PUBLIC_KEY');
        $payments = PaymentType::all();

		return view('ecommerce.payment.checkout',
		[
			'products' => $products,
            'total_cart' => $total_cart,
            'culqi_pk_public' => $culqi_pk_public,
            'payments' => $payments
		]);
    }

    public function success(Request $request)
	{
        switch ($request->method)
		{
			case '1':
                return $this->creditCard($request);
			break;
			case '2':
                return $this->paymentDelivey($request);
			break;
			default:
                return response()->json(['message' => 'not found method'],404);
        }
	}

    private function creditCard($request)
    {
        $total = \Cart::getTotal();

        $SECRET_KEY = env('CULQUI_SECRET_KEY');

        $culqi = new Culqi(array('api_key' => $SECRET_KEY));

        try{
            $culqiSuccess = $culqi->Charges->create(
                array(
                    "amount" => round(($total * 100),2),
                    "capture" => true,
                    "currency_code" => "PEN",
                    "description" => "Ventas En Línea Sis Comp",
                    "email" => Auth()->user()->email,
                    "installments" => 0,
                    "source_id" => $request->token
                )
            );
        }
        catch(\Exception $e){
            $message = json_decode($e->getMessage());
            return response()->json($message,422);
        }

        $order = Order::create([
            'customer_id' => Auth()->user()->id,
            'plus_info' => $request->plus_info,
            'state_id' => 2
        ]);

		$payment = new Payment;
        $payment->amount = $total;
        $payment->reference_code = $culqiSuccess->reference_code;
        $payment->payment_type_id = 1;
        $payment->order_id = $order->id;


        if($request->shipping)
        {
            $rest_shipping = json_decode(json_encode($request->shipping));
            Shipping::create([
                'order_id' => $order->id,
                'address' => $rest_shipping->address,
                'price' => 10,
                'district_id' => $rest_shipping->district->id
            ]);
            $payment->amount += 10;
        }
        $payment->save();
        $shippingAmount = $request->shipping ? 10.00:0.00;

        $cartContent = \Cart::getContent();
        $this->createBoleta($cartContent,$total,$order,$shippingAmount);
        foreach($cartContent as $product)
        {
            $productFind = Product::findOrFail($product->id);
            $productFind->stock = $productFind->stock - $product->quantity;
            $productFind->save();

            $order->products()->attach($product->id,['quantity' => $product->quantity]);
        }
        \Cart::clear();
        $this->sendOrderNotifications($order);
        $order->date = $order->created_at->format('F d \,\ Y ');
        return response()->json(['message' => 'success','data' => $order],200);
    }

    private function paymentDelivey($request){
        $order = Order::create([
            'customer_id' => Auth()->user()->id,
            'plus_info' => $request->plus_info,
            'state_id' => 4
        ]);

        $payment = new Payment;
        $payment->amount = 0;
        $payment->payment_type_id = 2;
        $payment->order_id = $order->id;
        $payment->save();

        if($request->shipping)
        {
            $rest_shipping = json_decode(json_encode($request->shipping));
            Shipping::create([
                'order_id' => $order->id,
                'address' => $rest_shipping->address,
                'price' => 10,
                'district_id' => $rest_shipping->district->id
            ]);
        }
        foreach(\Cart::getContent() as $product)
        {
            $order->products()->attach($product->id,['quantity' => $product->quantity]);
        }
        \Cart::clear();
        $this->sendOrderNotifications($order);
        $order->date = $order->created_at->format('F d \,\ Y ');
        return response()->json(['message' => 'success','data' => $order],200);
    }

    private function sendOrderNotifications($order)
    {
        Auth()->user()->sendOrderNotification($order);
        $users = User::where('actived',true)->get();
        foreach($users as &$user){
            $user->sendOrderNotification($order);
        }
    }

    private function createBoleta($cart,$totalOrder,$order,$shippingAmount){
        $collection = collect();
        $customer = Auth()->user();

        foreach($cart as $product)
        {
            $valor_unitario = round(($product->price / 1.18),2);
            $total = $product->price * $product->quantity;

            $object = new \stdClass;
            $object->unidad_de_medida = 'NIU';
            $object->codigo = $product->id;
            $object->codigo_producto_sunat = '10000000';
            $object->descripcion = $product->name;
            $object->cantidad = $product->quantity;
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
                'fecha_de_emision' => $order->updated_at->format('Y-m-d'),
                'moneda' => 1,
                'porcentaje_de_igv' => 18,
                'total_igv' => round(($totalOrder - ($totalOrder / 1.18)),2),
                'total_gravada' => round(($totalOrder / 1.18),2),
                'total_otros_cargos' => $shippingAmount == 0.00 ? '':$shippingAmount,
                'total' => round(($totalOrder + $shippingAmount),2),
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
