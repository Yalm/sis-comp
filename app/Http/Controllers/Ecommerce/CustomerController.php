<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Document;
use App\Customer;
use Hash;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    public function account()
    {
        $customer = Auth()->user();
        $documents = Document::all();

        return view('ecommerce.profile.edit_profile',[
            'customer' => $customer,
            'documents' => $documents
        ]);
    }

    public  function home()
    {
        $customer = Auth()->user();
        return view('ecommerce.profile.home',[
            'customer' => $customer
        ]);
    }

    public  function completeProfile()
    {
        $customer =  Auth()->user();
        $documents = Document::all();
        return view('ecommerce.payment.data_user',[
            'customer' => $customer,
            'documents' => $documents
        ]);
    }
    public  function completeProfilePayment(Request $request)
    {
        $customer = Auth()->user();
        $customer->surnames = $request->surnames;
        $customer->document_id = $request->type_document;
        $customer->document_number = $request->document_number;
        $customer->phone = $request->phone;

        $customer->save();

        return redirect('/checkout');
    }

    public function changeDataCustomer(CustomerRequest $request)
    {
        $customer = Customer::findOrFail($request->id);
        $customer->name = $request->name;
        $customer->surnames = $request->surnames;
        $customer->document_id = $request->type_document;
        $customer->document_number = $request->document_number;
        $customer->phone = $request->phone;
        $customer->save();

        return redirect()->back()->with("successCustomer","Información cambiada con éxito!");
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        if (!(Hash::check($request->get('current-password'), Auth()->user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Su contraseña actual no coincide con la contraseña que proporcionó. Inténtalo de nuevo.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","La nueva contraseña no puede ser igual a su contraseña actual. Por favor, elija una contraseña diferente.");
        }

        //Change Password
        $user = Auth()->user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Contraseña cambiada con éxito !");
    }
}
