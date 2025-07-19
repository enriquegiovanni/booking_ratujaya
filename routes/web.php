<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lapangan/{id}', [HomeController::class, 'detail'])->name('lapangan.detail');
