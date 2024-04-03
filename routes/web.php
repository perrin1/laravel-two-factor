<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\CodeSecret;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MessageNotifControtroller;

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

Route::get('/dashboard', function () {
    $data = CodeSecret::where('user_id', Auth::user()->id)->first();
    return view('dashboard',compact('data'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/code', [MessageNotifControtroller::class, 'edit'])->name('code.edit');
    Route::get('/regenere', [MessageNotifControtroller::class, 'regenere'])->name('code.regenere');
    Route::post('/send', [MessageNotifControtroller::class, 'send'])->name('code.send');
});




require __DIR__.'/auth.php';
