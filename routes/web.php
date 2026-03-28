<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

//ANOTACION: "get/post" indica a qué tipo de solicitud responde la ruta
//           "view" es para rutas estáticas
//           "/..." indica la ruta que parecerá en el navegador
//           "[PruebaController::class, 'metodo']" indica a qué metodo de qué controlador se llama
//           "name('prueba')" indica el nombre o alias a usar

// Ruta principal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');

// Registro
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'createUserAccount'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Legal
Route::view('/about-us', 'legal.about-us')->name('about-us');
Route::view('/privacy', 'legal.privacy')->name('privacy');
Route::view('/contact', 'legal.contact')->name('contact');
Route::view('/cookies', 'legal.cookies')->name('cookies');

// // Usuarios (solo si estás logueado)
// Route::middleware('auth')->group(function () {
//     Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
// });