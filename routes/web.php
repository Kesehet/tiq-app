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


// Frontend
Route::get('/post-login', [AppController::class, 'postLoginRedirect'])->name('post-login');
Route::get('/home', [AppController::class, 'home'])->name('home');
Route::get('/settings', [AppController::class, 'settings'])->name('settings');
Route::get('/quiz/{id}', [AppController::class, 'quiz'])->name('quiz');
Route::get('/quiz-results/{quizId}', [AppController::class, 'quizResult'])->name('quiz-results');
Route::get('/search', [AppController::class, 'search'])->name('search');


// Backend
Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');

// Backend Users
Route::get('backend/user', [DashboardController::class, 'users'])->name('dashboard.users');
Route::post('backend/user/changeRole/{userId}', [DashboardController::class, 'changeRole'])->name('dashboard.user.changeRole');

// Backend Languages
Route::get('backend/languages', [DashboardController::class, 'languages'])->name('dashboard.languages');
Route::post('backend/languages/store', [DashboardController::class, 'languageStore'])->name('dashboard.languages.store');
Route::get('backend/languages/delete/{id}', [DashboardController::class, 'languageDelete'])->name('dashboard.languages.destroy');


// Backend Quizzes
Route::get('backend/quizzes', [DashboardController::class, 'quizzes'])->name('dashboard.quizzes');
Route::get('backend/quizzes/create', [DashboardController::class, 'quizCreate'])->name('dashboard.quiz.create');
Route::post('backend/quizzes/store', [DashboardController::class, 'quizStore'])->name('dashboard.quiz.store');
Route::get('backend/quizzes/delete/{id}', [DashboardController::class, 'quizDelete'])->name('dashboard.quiz.delete');


// Backend Questions
Route::get('backend/questions', [DashboardController::class, 'questions'])->name('dashboard.questions');
Route::get('backend/questions/create', [DashboardController::class, 'questionCreate'])->name('dashboard.question.create');
Route::get('backend/questions/delete/{id}', [DashboardController::class, 'questionDelete'])->name('dashboard.question.delete');
Route::post('backend/questions/store', [DashboardController::class, 'questionStore'])->name('dashboard.question.store');


// Combo
Route::get('backend/quizzes/combo', [DashboardController::class, 'combined'])->name('dashboard.question.combo');
Route::post('backend/quizzes/combo/store', [DashboardController::class, 'combinedStore'])->name('dashboard.question.combo.store');







// APIs
Route::post('/api/submit-quiz/{id}', [QuizController::class, 'submit'])->name('submit-quiz');
Route::post('/settings', [AppController::class, 'savePreferences'])->name('settings.save');
Route::post('/quizzes/{quiz}/tags', [QuizController::class, 'addTagToQuiz'])->name('quizzes.addTag');
Route::delete('/quizzes/{quiz}/tags/{tag}', [QuizController::class, 'removeTagFromQuiz'])->name('quizzes.removeTag');
Route::get('/tags/{tag}/quizzes', [QuizController::class, 'getQuizzesByTag'])->name('tags.quizzes');
