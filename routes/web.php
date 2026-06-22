<?php

use App\Http\Controllers\Admin\NaskahController;
use App\Http\Controllers\Author\NaskahController as AuthorNaskahController;
use App\Models\Naskah;
use Illuminate\Support\Facades\Auth;
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
Route::get('/', function () { return view('public.landing'); });
Route::get('/katalog', function () { return view('public.catalog'); });
Route::get('/persyaratan', function () { return view('public.requirements'); });
Route::get('/buku/{id}', function () { return view('public.detail-book'); });

// Auth
Route::get('/auth/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/auth/register', [\App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/auth/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/auth/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'adminLogin']);
});

// Editor
Route::prefix('editor')->group(function () {
    Route::get('/', function () {
        if (auth()->check() && auth()->user()->role === 'editor') {
            return redirect('/editor/dashboard');
        }

        return redirect('/editor/login');
    });
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showEditorLogin'])->name('editor.login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'editorLogin']);
});

Route::prefix('editor')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () { return view('editor.dashboard'); });
    Route::get('/naskah', function () { return view('editor.naskah.index'); });
    Route::get('/naskah/{id}', function () { return view('editor.naskah.detail'); });
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', function () { return redirect('/admin/dashboard'); });
    Route::get('/dashboard', function () {
        $total = Naskah::count();
        $inReview = Naskah::where('status', 'dalam review')->count();
        $published = Naskah::where('status', 'diterima')->count();
        $rejected = Naskah::where('status', 'ditolak')->count();
        $recent = Naskah::with('user')->orderByDesc('submitted_at')->limit(5)->get();

        return view('admin.dashboard', compact('total', 'inReview', 'published', 'rejected', 'recent'));
    });
    Route::get('/naskah', [NaskahController::class, 'index'])->name('admin.naskah.index');
    Route::get('/naskah/{id}', [NaskahController::class, 'show'])->name('admin.naskah.show');
    Route::get('/publication', function () { return view('admin.publication.form'); });
    
    // kategori
    Route::get('/kategori', [CategoryController::class, 'index'])->name('admin.kategori.index');
    Route::post('/kategori', [CategoryController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{category}', [CategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{category}', [CategoryController::class, 'destroy'])->name('kategori.destroy');
    
    // paket
    Route::get('/paket',[PackageController::class,'index'])->name('admin.paket.index');
    Route::post('/paket',[PackageController::class,'store'])->name('paket.store');
    Route::put('/paket/{package}', [PackageController::class, 'update'])->name('paket.update');
    Route::delete('/paket/{package}', [PackageController::class, 'destroy'])->name('paket.destroy');
    
    // users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/profil', function () { return view('admin.profil'); });
});

// Author
Route::prefix('author')->middleware('auth')->group(function () {
    Route::get('/', function () { return redirect('/author/dashboard'); });
    Route::get('/dashboard', [AuthorNaskahController::class, 'dashboard'])->name('author.dashboard');
    Route::get('/naskah', [AuthorNaskahController::class, 'index'])->name('author.naskah.index');
    Route::get('/upload', [AuthorNaskahController::class, 'create'])->name('author.naskah.create');
    Route::post('/upload', [AuthorNaskahController::class, 'store'])->name('author.naskah.store');
    Route::get('/naskah/{id}', [AuthorNaskahController::class, 'show'])->name('author.naskah.show');
    Route::get('/revisi/{id}', function () { return view('author.revisi'); });
    Route::get('/profil', function () { return view('author.profil'); });
});

// Reviewer
Route::prefix('reviewer')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showReviewerLogin'])->name('reviewer.login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'reviewerLogin']);
});

Route::prefix('reviewer')->middleware('auth')->group(function () {
    Route::get('/', function () { return redirect('/reviewer/dashboard'); });
    Route::get('/dashboard', function () { return view('reviewer.dashboard'); });
    Route::get('/naskah', function () { return view('reviewer.naskah.index'); });
    Route::get('/naskah/{id}', function () { return view('reviewer.naskah.detail'); });
});
