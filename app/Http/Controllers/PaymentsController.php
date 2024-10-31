<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\User;
use App\Notifications\SendPaymentEmail;
use App\Http\Requests\StorePaymentsRequest;
use App\Http\Requests\UpdatePaymentsRequest;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments =payments::all ();
        return $payments;
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentsRequest $request)
    {
        
        $payments = new payments;

        $payments->user_id = $request->user_id;
        $payments->order_id = $request->order_id;
        $payments->amount = $request->amount;
        $payments->payment_type = $request->payment_type;
        $payments->payment_status = $request->payment_status;

        $payments->save();
           //update order status
           $order = Orders::where('id', $request->order_id)->first();
           $order->order_status = 'Preparing';
           $order->save();
   
        $user = User::find($request->user_id);
        $user->notify(new SendPaymentEmail($user, $payments));

        return $payments;
    }

    /**
     * Display the specified resource.
     */
    public function show(Payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentsRequest $request, Payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payments $payments)
    {
        //
    }
}
