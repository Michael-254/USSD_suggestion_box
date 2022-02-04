<?php

use App\Models\Department;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

//Users
Route::get('/users',[\App\Http\Controllers\DepartmentController::class,'index'])->name('users');
Route::get('/edit/{id}',[\App\Http\Controllers\DepartmentController::class,'edit'])->name('edit.user');
Route::patch('/update/{id}',[\App\Http\Controllers\DepartmentController::class,'update'])->name('update.user');
Route::delete('/destroy/{id}',[\App\Http\Controllers\DepartmentController::class,'destroy'])->name('user.destroy');

//Messages
Route::get('/messages',[\App\Http\Controllers\ResponseController::class,'messages'])->name('messages');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
