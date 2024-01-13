<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authcontroller;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/api/register', [Authcontroller::class, 'Register']);
Route::post('/api/login', [Authcontroller::class, 'login']);

Route::group(['middleware', ['auth:sanctum']],function(){
    Route::post('/api/logout', [Authcontroller::class, 'logout']);
});
