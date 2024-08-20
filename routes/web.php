<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PembacaController;
use App\Http\Controllers\MembacaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('beranda');
});
//Buku
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/tambahbuku', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.create');


//Pembaca
Route::get('/pembaca', [PembacaController::class, 'index'])->name('pembaca.index');
Route::get('/tambahpembaca', [PembacaController::class, 'create'])->name('pembaca.create');
Route::post('/pembaca', [PembacaController::class ])->name('pembaca.pembaca');


//Membaca
Route::get('/membaca', [MembacaController::class, 'index'])->name('membaca.index');
Route::get('/tambahmembaca', [MembacaController::class, 'create'])->name('membaca.create');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
