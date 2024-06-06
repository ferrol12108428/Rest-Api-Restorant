<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();

        if ($product) {
            return ApiFormatter::createApi(200, 'success', $product);
        } else {
            return ApiFormatter::createApi(400, 'failed');
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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'stock' => 'required',
                'price' => 'required',
                'description' => 'required',
                'prodcut_category_id' => 'required',
            ]);

            $image = $request->file('image');
            $imgName = rand() . '.' . $image->extension();
            $path = public_path('assets/img/product/');
            $image->move($path, $imgName);

            $slug = Str::lower($request->name);
            $slug = str_replace(' ', '-', $slug);

            $product = Product::create([
                'name' => $request->name,
                'slug' => strtolower($slug),
                'image' => $imgName,
                'stock' => $request->stock,
                'price' => $request->price,
                'description' => $request->description,
                'prodcut_category_id' => $request->prodcut_category_id,
            ]);

            $getDataSaved = Product::where('id', $product->id)->first();

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
            $prodcut = Product::find($id);

            if ($prodcut) {
                return ApiFormatter::createApi(200, 'success', $prodcut);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'stock' => 'required',
                'price' => 'required',
                'description' => 'required',
                'prodcut_category_id' => 'required',
            ]);

            if (is_null($request->file('image'))) {
                $imgName = $request->file('image');
            } else {
                $image = $request->file('image');
                $imgName = rand() . '.' . $image->extension();
                $path = public_path('assets/img/product/');
                $image->move($path, $imgName);
            }

            $product = Product::find($id);

            $slug = Str::lower($request->name);
            $slug = str_replace(' ', '-', $slug);

            $product->update([
                'name' => $request->name,
                'slug' => strtolower($slug),
                'image' => $imgName,
                'stock' => $request->stock,
                'price' => $request->price,
                'description' => $request->description,
                'prodcut_category_id' => $request->prodcut_category_id,
            ]);

            $getDataSaved = Product::where('id', $product->id)->first();
            
            if ($getDataSaved) {
                return ApiFormatter::createApi(200, 'success' , $getDataSaved);
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
            $prodcut = Product::find($id);
            $data = $prodcut->delete();

            if ($data) {
                return ApiFormatter::createApi(200, 'success', 'Data deleted successfully');
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(500, 'error', $error->getMessage());
        }
    }
}
