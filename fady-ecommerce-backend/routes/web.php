<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('store');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/product/{slug}', function ($slug) {
    return view('product', ['slug' => $slug]);
});

Route::get('/cart/view', function () {
    return view('cart');
});
