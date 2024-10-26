<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReadingProficiencyLevelController;
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
    return view('home');
})->name('home');

//categories
Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('/category/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('category.add');
Route::post('/category', [\App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
Route::get('/category/{id}/edit', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy');

//books
Route::get('/books', [\App\Http\Controllers\BookController::class, 'index'])->name('books');
Route::get('/book/create', [\App\Http\Controllers\BookController::class, 'create'])->name('book.add');
Route::post('/book', [\App\Http\Controllers\BookController::class, 'store'])->name('book.store');
Route::get('/book/{id}/edit', [\App\Http\Controllers\BookController::class, 'edit'])->name('book.edit');
Route::put('/book/{id}', [\App\Http\Controllers\BookController::class, 'update'])->name('book.update');
Route::delete('/book/{id}', [\App\Http\Controllers\BookController::class, 'destroy'])->name('book.destroy');

//readers
Route::get('/readers', [\App\Http\Controllers\ReaderController::class, 'index'])->name('readers');
Route::get('/reader/create', [\App\Http\Controllers\ReaderController::class, 'create'])->name('reader.add');
Route::post('/reader', [\App\Http\Controllers\ReaderController::class, 'store'])->name('reader.store');
Route::get('/reader/{id}/edit', [\App\Http\Controllers\ReaderController::class, 'edit'])->name('reader.edit');
Route::put('/reader/{id}', [\App\Http\Controllers\ReaderController::class, 'update'])->name('reader.update');
Route::delete('/reader/{id}', [\App\Http\Controllers\ReaderController::class, 'destroy'])->name('reader.destroy');

//reading_activities
Route::get('/read-activity', [\App\Http\Controllers\ReadingActivityController::class, 'index'])->name('read.activity');
Route::get('/read-activity/create', [\App\Http\Controllers\ReadingActivityController::class, 'create'])->name('read.activity.add');
Route::post('/read-activity', [\App\Http\Controllers\ReadingActivityController::class, 'store'])->name('read.activity.store');
Route::post('/read-activity/{id}/update-duration', [\App\Http\Controllers\ReadingActivityController::class, 'update'])->name('read.activity.update.duration');
Route::delete('/read-activity/{id}', [\App\Http\Controllers\ReadingActivityController::class, 'destroy'])->name('read.activity.destroy');

// reading proficiency level
Route::get('/reading-statistics', [\App\Http\Controllers\ReadingProficiencyLevelController::class, 'readingStatistics'])->name('reading.statistic');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
