<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\UsersController;

// User
Route::get('/login', [UsersController::class, 'login'])->name('login');
Route::post('/authenticate', [UsersController::class, 'authenticate']);
Route::get('/create', [UsersController::class, 'create'])->name('create');
Route::post('/store', [UsersController::class, 'store']);
Route::post('/logout', [UsersController::class, 'logout']);
Route::get('/guestLogin', [UsersController::class, 
'guestLogin']);

Route::get('/', [OpenAIController::class, 'index']);
Route::post('/speak', [OpenAIController::class, 'speak']);
Route::get('/voice', [OpenAIController::class, 'voice']);

Route::get('/image', [OpenAIController::class, 'image']);
Route::post('/generateImage', [OpenAIController::class, 'generateImage']);
Route::post('/getImage', [OpenAIController::class, 'getImage']);
