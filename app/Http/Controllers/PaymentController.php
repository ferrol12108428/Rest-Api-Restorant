<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $payment = Payment::all();
            
            if ($payment) {
                return ApiFormatter::createApi(200, 'success', $payment);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(500, 'error', $error->getMessage());
        }
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
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'amount' => 'required',
                'currency' => 'required',
                'payment_method_id' => 'required',
                'description' => 'required',
            ]);

            $payment = Payment::create([
                'user_id' => $request->user_id,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'payment_method_id' => $request->payment_method_id,
                'description' => $request->description,
            ]);

            $data = Payment::where('id', $payment->id)->first();

            if ($data) {
                return ApiFormatter::createApi(200, 'success', $data);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(500, 'error', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $payment = Payment::find($id);

            if ($payment) {
                return ApiFormatter::createApi(200, 'success', $payment);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(500, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'amount' => 'required',
                'currency' => 'required',
                'payment_method_id' => 'required',
                'description' => 'required',
            ]);

            $payment = Payment::find($id);

            $payment->update([
                'user_id' => $request->user_id,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'payment_method_id' => $request->payment_method_id,
                'description' => $request->description,
            ]);

            $data = Payment::where('id', $payment->id)->first();

            if ($data) {
                return ApiFormatter::createApi(200, 'success', $data);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(500, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $payment = Payment::find($id);
            $payment->delete();

            if ($payment) {
                return ApiFormatter::createApi(200, 'success', 'data deleted successfully');
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(500, 'error', $error->getMessage());
        }
    }
}
