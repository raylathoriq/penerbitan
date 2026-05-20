<?php

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
Route::get('/auth/login', function () { return view('auth.login'); });
Route::get('/auth/register', function () { return view('auth.register'); });

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); });
    Route::get('/naskah', function () { return view('admin.naskah.index'); });
    Route::get('/naskah/{id}', function () { return view('admin.naskah.detail'); });
    Route::get('/publication', function () { return view('admin.publication.form'); });
    Route::get('/users', function () { return view('admin.users'); });
    Route::get('/profil', function () { return view('admin.profil'); });
});

// Author
Route::prefix('author')->group(function () {
    Route::get('/dashboard', function () { return view('author.dashboard'); });
    Route::get('/naskah', function () { return view('author.list-naskah'); });
    Route::get('/upload', function () { return view('author.upload'); });
    Route::get('/naskah/{id}', function () { return view('author.detail-naskah'); });
    Route::get('/revisi/{id}', function () { return view('author.revisi'); });
    Route::get('/profil', function () { return view('author.profil'); });
});
