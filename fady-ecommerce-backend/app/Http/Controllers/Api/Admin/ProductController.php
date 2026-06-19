<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category')->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'sku' => 'nullable|string',
            'stock' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', ['disk' => config('filesystems.default')]);
            $data['image'] = $path;
        }

        $product = Product::create($data);
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return $product->load('category');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|exists:categories,id',
            'price' => 'sometimes|numeric',
            'sku' => 'nullable|string',
            'stock' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($product->image) {
                try { Storage::delete($product->image); } catch (\Throwable $e) { }
            }
            $path = $request->file('image')->store('products', ['disk' => config('filesystems.default')]);
            $data['image'] = $path;
        }

        $product->update($data);
        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            try { Storage::delete($product->image); } catch (\Throwable $e) { }
        }
        $product->delete();
        return response()->noContent();
    }
}
