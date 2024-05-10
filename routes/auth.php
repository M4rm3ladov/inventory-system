<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// only admin can view
Route::group(['middleware' => ['auth', 'can:admin']], function () {
    Route::get('/register', [UserController::class, 'register'])->name('register');

    Route::post('/register', [UserController::class, 'store']);

    Route::group(['prefix' => 'users', 'as' => 'users'], function () {
        Route::get('', [UserController::class, 'index'])->name('');

        Route::get('{user}/edit', [UserController::class, 'edit'])->name('.edit');

        Route::put('{user}', [UserController::class, 'update'])->name('.update');

        Route::get('credential/{user}/edit', [UserController::class, 'editCredential'])->name('.credential.edit');

        Route::put('credential/{user}', [UserController::class, 'updateCredential'])->name('.credential.update');
    });
});

// redirect to home when already logged in
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');

    Route::post('/login', [UserController::class, 'authenticate']);
});

Route::post('/logout', [UserController::class, 'logout'])->name('logout');
