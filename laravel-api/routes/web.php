<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CategoryController as CategoryController;
use App\Http\Controllers\Admin\ContactLeadController as ContactLeadController;
use App\Http\Controllers\Admin\DashboardController as DashboardController;
use App\Http\Controllers\Admin\PostController as PostController;
use App\Http\Controllers\Admin\TagController as TagController;
use App\Models\Category;

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
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', PostController::class)->parameters(['posts' => 'post:slug']);
    Route::resource('/categories', CategoryController::class)->parameters(['categories' => 'category:slug']);
    Route::resource('/tags', TagController::class)->parameters(['tags' => 'tag:slug']);
    Route::get('/contacts', [ContactLeadController::class, 'index'])->name('contact');
    Route::post('/contacts/send_email', [ContactLeadController::class, 'send_email'])->name('send_email');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
