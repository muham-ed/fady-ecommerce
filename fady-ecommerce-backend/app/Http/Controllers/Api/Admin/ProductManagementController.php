<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductManagementController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::paginate(25);
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::create($request->only(['name','slug','price','description','is_active','category_id']));

        // handle uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $url = Storage::url($path);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $url,
                    'alt_text' => $product->name,
                    'is_primary' => 0,
                ]);
            }
        }

        return response()->json($product->load('images'), 201);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:products,slug,'.$product->id,
            'price' => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product->update($request->only(['name','slug','price','description','is_active','category_id']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $url = Storage::url($path);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $url,
                    'alt_text' => $product->name,
                    'is_primary' => 0,
                ]);
            }
        }

        return response()->json($product->load('images'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
