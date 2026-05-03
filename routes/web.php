<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BikeController;

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

//Carrito
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::view('/cart/reservation', 'cart.reservation')->name('reservation');

//Reservas
Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.index');
Route::post('/reservation/checkout', [ReservationController::class, 'checkout'])->name('reservation.checkout');
Route::post('/reservation/cancel', [ReservationController::class, 'cancelReservation'])->name('reservation.cancel');
Route::post('/reservation/confirm', [ReservationController::class, 'confirmReservation'])->name('reservation.confirm');
Route::post('/reservation/receive', [ReservationController::class, 'receive'])->name('reservation.receive');
Route::get('/reservation/supervising', [ReservationController::class, 'supervisingView'])->name('reservation.supervising');
Route::post('/reservation/supervising', [ReservationController::class, 'supervising'])->name('reservation.supervising.post');

//Usuarios
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/update', [UserController::class, 'userUpdateForm'])->name('user.form');
Route::post('/user/update', [UserController::class, 'userUpdate'])->name('user.form.post');
Route::post('/user/delete', [UserController::class, 'userDelete'])->name('user.delete');

//Bicicletas
Route::get('/bike', [BikeController::class, 'index'])->name('bike.index');
Route::get('/bike/add', [BikeController::class, 'bikeAddForm'])->name('bike.addForm');
Route::post('/bike/add', [BikeController::class, 'bikeAdd'])->name('bike.addForm.post');
Route::get('/bike/update', [BikeController::class, 'bikeUpdateForm'])->name('bike.updateForm');
Route::post('/bike/update', [BikeController::class, 'bikeUpdate'])->name('bike.updateForm.post');

//Mantenimiento
Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
Route::get('/maintenance/add', [MaintenanceController::class, 'maintenanceForm'])->name('maintenance.form');
Route::post('/maintenance/add', [MaintenanceController::class, 'maintenance'])->name('maintenance.form.post');

//Facturación
Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');




// // Usuarios (solo si estás logueado)
// Route::middleware('auth')->group(function () {
//     Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
// });