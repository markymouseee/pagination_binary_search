<?php

use App\Http\Controllers\BinarySearchTreeController;
use App\Http\Controllers\UsersInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/bst/insert', [BinarySearchTreeController::class, 'insert']);
Route::get('/search-users', [UsersInfoController::class, 'search']);
