<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\Document;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::where('actived',true)->get();
        $customers->each(function($customer)
		{
            $customer->shop = $customer->orders->count();
		});
        return view('dashboard.customer.index',['customers' => $customers]);
    }
    public function show(Request $request,$id){
        $customer = Customer::findOrFail($id);
        $documents = Document::all();
        $customer->orders;
        $customer->orders->each(function($order)
		{
            $order->state;
            $order->payment;
            $order->date = $order->created_at->format('F d \,\ Y ');
        });

        if($request->ajax() && $request->json){
            return response()->json(['documents' => $documents,'customer' => $customer],200);
        }else{
            return view('dashboard.customer.show',['documents' => $documents,'customer' => $customer,'orderRequest' => $request->order]);
        }
    }
    public function update(CustomerRequest $request,$id){
        $customer = Customer::findOrFail($id);

        $customer->name = $request->name;
        $customer->surnames = $request->surnames;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->document_number = $request->document_number;
        $customer->document_id = $request->document_id;

        if($request->password)
		{
            $customer->password = Hash::make($request->password);
        }
        $customer->save();
        return response()->json($customer,200);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->actived = false;
        $customer->save();
		return response()->json($customer);
    }
}
