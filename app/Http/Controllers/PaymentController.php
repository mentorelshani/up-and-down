<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function getPayment($id){

        return Payment::whereId($id)->with('product','client')->first();
    }

    public function getPaymentsByEntryId($entry_id){

        $apartment_ids = Apartment::where('entry_id',$entry_id)->select('id')->get();
        $client_ids = Client::whereIn('id',$apartment_ids)->select('id')->get();

        return Payment::whereIn('client_id',$client_ids)->with('product','client')->get();
    }

    public function add(Request $request){

        $this->validate($request,[
            'product_id' => 'exists:products,id',
            'client_id' => 'exists:clients,id',
            'price' => 'required|numeric',
        ]);

        $product_id = $request->product_id;
        $client_id = $request->client_id;
        $price = $request->price;

        $payment = new Payment();
        $payment->product_id = $product_id;
        $payment->client_id = $client_id;
        $payment->price = $price;
        $payment->save();

        return $payment;
    }

    public function update(Request $request){

        $this->validate($request,[
            'id' => 'exists:payments',
            'product_id' => 'exists:products,id',
            'client_id' => 'exists:clients,id',
            'price' => 'required|numeric',
        ]);

        $id = $request->id;
        $product_id = $request->product_id;
        $client_id = $request->client_id;
        $price = $request->price;

        $payment = Payment::whereId($id)->first();
        $payment->product_id = $product_id;
        $payment->client_id = $client_id;
        $payment->price = $price;
        $payment->update();

        return $payment;
    }

    public function destroy($id){
        $a = Payment::find($id);

        if ($a != null) {
            $a->delete();
            return "u fshi";
        }
        return "Nuk ekziston";
    }
}
