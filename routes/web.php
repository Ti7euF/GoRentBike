<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

// Ruta principal → HomeController@index
Route::get('/', [HomeController::class, 'index'])->name('home');

// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

// Registro
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// // Usuarios (solo si estás logueado)
// Route::middleware('auth')->group(function () {
//     Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
// });