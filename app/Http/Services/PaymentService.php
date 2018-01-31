<?php
/**
 * Created by PhpStorm.
 * User: Mentori
 * Date: 1/29/2018
 * Time: 9:46 AM
 */

namespace App\Http\Services;


class PaymentService
{
    public function add($request, $payment){

        $payment->product_id = $request->product_id;
        $payment->client_id = $request->client_id;
        $payment->price = $request->price;
        $payment->save();
    }

    public function update($request, $payment){

        $payment->product_id = $request->product_id;
        $payment->client_id = $request->client_id;
        $payment->price = $request->price;
        $payment->update();
    }
}