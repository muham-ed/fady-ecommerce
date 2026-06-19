<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        return response()->json($products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with(['images','variants'])->firstOrFail();
        return response()->json($product);
    }
}
