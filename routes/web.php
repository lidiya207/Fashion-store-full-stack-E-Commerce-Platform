<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

// SPA catch-all (let Vue Router handle it)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api\/).*$');
