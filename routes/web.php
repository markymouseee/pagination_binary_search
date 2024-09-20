<?php

use App\Http\Controllers\UsersInfoController;
use Illuminate\Support\Facades\Route;

Route::get('/bst/insert', function () {
    return view('insert');
});


Route::get('/', [UsersInfoController::class, 'index'])->name('home');
