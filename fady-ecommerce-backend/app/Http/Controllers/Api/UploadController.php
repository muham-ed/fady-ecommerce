<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp|max:5120'
        ]);

        $file = $request->file('file');
        $path = $file->store('products', ['disk' => config('filesystems.default')]);

        return response()->json(['path' => $path, 'url' => Storage::url($path)]);
    }
}
