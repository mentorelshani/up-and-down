<?php

namespace App\Http\Controllers;

use App\Http\Requests\addPaymentRequest;
use App\Http\Requests\updatePaymentRequest;
use App\Http\Services\PaymentService;
use App\Models\Apartment;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    private $paymentService;

    public function __construct(PaymentService $paymentService){

        $this->paymentService = $paymentService;
    }

    public function getPayment($id){

        return Payment::whereId($id)->with('product','client')->first();
    }

    public function getPaymentsByEntryId($entry_id){

        $apartment_ids = Apartment::where('entry_id',$entry_id)->select('id')->get();
        $client_ids = Client::whereIn('id',$apartment_ids)->select('id')->get();

        return Payment::whereIn('client_id',$client_ids)->with('product','client')->get();
    }

    public function add(addPaymentRequest $request){

        $payment = new Payment();

        $this->paymentService->add($request, $payment);

        return $payment;
    }

    public function update(updatePaymentRequest $request){

        $payment = Payment::find($request->id);

        $this->paymentService->update($request, $payment);

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
