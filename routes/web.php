<?php

use App\Http\Controllers\Admin\NaskahController;
use App\Http\Controllers\Author\NaskahController as AuthorNaskahController;
use App\Http\Controllers\Reviewer\NaskahController as ReviewerNaskahController;
use App\Http\Controllers\Editor\NaskahController as EditorNaskahController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (DUMMY FRONTEND RENDERING)
|--------------------------------------------------------------------------
*/

// Public
Route::view('/', 'public.landing');
Route::view('/persyaratan', 'public.requirements');

// Auth
Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Auth
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLogin']);
});

// Editor Auth
Route::prefix('editor')->group(function () {
    Route::get('/', [AuthController::class, 'editorRedirect']);
    Route::get('/login', [AuthController::class, 'showEditorLogin'])->name('editor.login');
    Route::post('/login', [AuthController::class, 'editorLogin']);
});

// Editor Protected Panel
Route::prefix('editor')->middleware('auth')->group(function () {
    Route::get('/dashboard', [EditorNaskahController::class, 'dashboard'])->name('editor.dashboard');
    Route::get('/naskah', [EditorNaskahController::class, 'index'])->name('editor.naskah.index');
    Route::get('/naskah/{id}', [EditorNaskahController::class, 'show'])->name('editor.naskah.show');
    Route::post('/naskah/{id}/submit-edit', [EditorNaskahController::class, 'submitEdit'])->name('editor.naskah.submitEdit');
});

// Admin Protected Panel
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/dashboard', [NaskahController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/naskah', [NaskahController::class, 'index'])->name('admin.naskah.index');
    Route::get('/naskah/{id}', [NaskahController::class, 'show'])->name('admin.naskah.show');
    Route::put('/naskah/{id}', [NaskahController::class, 'update'])->name('admin.naskah.update');
    Route::post('/naskah/{id}/assign-reviewer', [NaskahController::class, 'assignReviewer'])->name('admin.naskah.assignReviewer');
    Route::post('/naskah/{id}/assign-editor', [NaskahController::class, 'assignEditor'])->name('admin.naskah.assignEditor');
    Route::view('/publication', 'admin.publication.form');
    
    // Kategori
    Route::get('/kategori', [CategoryController::class, 'index'])->name('admin.kategori.index');
    Route::post('/kategori', [CategoryController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{category}', [CategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{category}', [CategoryController::class, 'destroy'])->name('kategori.destroy');
    
    // Paket
    Route::get('/paket', [PackageController::class, 'index'])->name('admin.paket.index');
    Route::post('/paket', [PackageController::class, 'store'])->name('paket.store');
    Route::put('/paket/{package}', [PackageController::class, 'update'])->name('paket.update');
    Route::delete('/paket/{package}', [PackageController::class, 'destroy'])->name('paket.destroy');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::view('/profil', 'admin.profil');
});

// Author Protected Panel
Route::prefix('author')->middleware('auth')->group(function () {
    Route::redirect('/', '/author/dashboard');
    Route::get('/dashboard', [AuthorNaskahController::class, 'dashboard'])->name('author.dashboard');
    Route::get('/naskah', [AuthorNaskahController::class, 'index'])->name('author.naskah.index');
    Route::get('/upload', [AuthorNaskahController::class, 'create'])->name('author.naskah.create');
    Route::post('/upload', [AuthorNaskahController::class, 'store'])->name('author.naskah.store');
    Route::get('/naskah/{id}', [AuthorNaskahController::class, 'show'])->name('author.naskah.show');
    Route::get('/revisi/{id}', [AuthorNaskahController::class, 'revisi'])->name('author.naskah.revisi');
    Route::post('/revisi/{id}', [AuthorNaskahController::class, 'storeRevisi'])->name('author.naskah.storeRevisi');
    Route::post('/naskah/{id}/confirm-editor', [AuthorNaskahController::class, 'confirmEditor'])->name('author.naskah.confirmEditor');
    Route::post('/naskah/{id}/cancel', [AuthorNaskahController::class, 'cancel'])->name('author.naskah.cancel');
    Route::view('/profil', 'author.profil');
});

// Reviewer Panel
Route::prefix('reviewer')->group(function () {
    Route::get('/login', [AuthController::class, 'showReviewerLogin'])->name('reviewer.login');
    Route::post('/login', [AuthController::class, 'reviewerLogin']);
});

Route::prefix('reviewer')->middleware('auth')->group(function () {
    Route::redirect('/', '/reviewer/dashboard');
    Route::get('/dashboard', [ReviewerNaskahController::class, 'dashboard'])->name('reviewer.dashboard');
    Route::get('/naskah', [ReviewerNaskahController::class, 'index'])->name('reviewer.naskah.index');
    Route::get('/naskah/{id}', [ReviewerNaskahController::class, 'show'])->name('reviewer.naskah.show');
    Route::post('/naskah/{id}/submit-review', [ReviewerNaskahController::class, 'submitReview'])->name('reviewer.naskah.submitReview');
});
