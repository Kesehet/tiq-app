<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DashboardController;

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
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);


Route::get('/post-login', [AppController::class, 'postLoginRedirect'])->name('post-login');
Route::get('/home', [AppController::class, 'home'])->name('home');
Route::get('/quiz/{id}', [AppController::class, 'quiz'])->name('quiz');



Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');



Route::resource('quizzes', 'QuizController');
