<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/', function () {
    return view('store');
});

Route::get('/product/{slug}', function ($slug) {
    return view('product', ['slug' => $slug]);
});

Route::get('/cart/view', function () {
    return view('cart');
});
