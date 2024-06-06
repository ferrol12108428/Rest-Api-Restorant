<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $method = PaymentMethod::all();

            if ($method) {
                return ApiFormatter::createApi(200, 'success', $method);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
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
                'name' => 'required',
                'description' => 'required',
            ]);

            $slug = Str::lower($request->name);
            $slug = str_replace(' ', '-', $slug);

            $method = PaymentMethod::create([
                'name' => $request->name,
                'slug' =>  $slug,
                'description' => $request->description,
            ]);

            $getDataSaved = PaymentMethod::where('id', $method->id)->first();

            if ($getDataSaved) {
                return ApiFormatter::createApi(200, 'success', $getDataSaved);
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
            $method = PaymentMethod::find($id);

            if ($method) {
                return ApiFormatter::createApi(200, 'success', $method);
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
    public function edit(PaymentMethod $paymentMethod)
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
                'name' => 'required',
                'description' => 'required',
            ]);

            $method = PaymentMethod::find($id);

            $slug = Str::lower($request->name);
            $slug = str_replace(' ', '-', $slug);

            $method->update([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
            ]);

            $data = PaymentMethod::where('id', $method->id)->first();

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
            $method = PaymentMethod::find($id);
            $method->delete();
            
            if ($method) {
                return ApiFormatter::createApi(200, 'success', 'Data deleted successfully');
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }
}
