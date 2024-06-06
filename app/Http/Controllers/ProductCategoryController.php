<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = ProductCategory::all();

        if ($category) {
            return ApiFormatter::createApi(200, 'success', $category);
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
                'description' => 'required',
            ]);

            $slug = Str::lower($request->name);
            $slug = str_replace(' ', '-', $slug);

            $category = ProductCategory::create([
                'name' => $request->name,
                'slug' => strtolower($slug),
                'description' => $request->description,
            ]);

            $getDataSaved = ProductCategory::where('id', $category->id)->first();

            if ($getDataSaved) {
                return ApiFormatter::createApi(200, 'success', $getDataSaved);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $category = ProductCategory::find($id);

            if ($category) {
                return ApiFormatter::createApi(200, 'success', $category);
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
    public function edit(ProductCategory $productCategory)
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

            $slug = Str::lower($request->name);
            $slug = str_replace(' ', '-', $slug);

            $category = ProductCategory::find($id);
            $category->update([
                'name' => $request->name,
                'slug' => strtolower($slug),
                'description' => $request->description,
            ]);

            $getDataSaved = ProductCategory::where('id', $category->id)->first();

            if ($getDataSaved) {
                return ApiFormatter::createApi(200, 'success', $getDataSaved);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = ProductCategory::find($id);
            $data = $category->delete();
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
