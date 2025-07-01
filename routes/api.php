<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/', function(){
//     return 'API';
// });

//iniciamos con las rutas para la api de autentificacion 


Route::post('/v1/auth/login', [AuthController::class, "funIngresar"]);
Route::post('/v1/auth/register', [AuthController::class, "funRegistro"]);


Route::get('/v1/auth/profile', [AuthController::class, "funPerfil"])->middleware('auth:sanctum');
Route::post('/v1/auth/logout', [AuthController::class, "funSalir"])->middleware('auth:sanctum');
