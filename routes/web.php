<?php

use App\Http\Controllers\Admin\NaskahController;
use App\Http\Controllers\Author\NaskahController as AuthorNaskahController;
use App\Models\Naskah;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageController;
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
        $recent = Naskah::orderByDesc('submitted_at')->limit(5)->get();

        return view('admin.dashboard', compact('total', 'inReview', 'published', 'rejected', 'recent'));
    });
    Route::get('/naskah', [NaskahController::class, 'index'])->name('admin.naskah.index');
    Route::get('/naskah/{id}', [NaskahController::class, 'show'])->name('admin.naskah.show');
    Route::put('/naskah/{id}', [NaskahController::class, 'update'])->name('admin.naskah.update');
    Route::post('/naskah/{id}/assign-reviewer', [NaskahController::class, 'assignReviewer'])->name('admin.naskah.assignReviewer');
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
    Route::get('/users', function () { return view('admin.users'); });
    Route::get('/profil', function () { return view('admin.profil'); });
});

// Author
Route::prefix('author')->middleware('auth')->group(function () {
    Route::get('/', function () { return redirect('/author/dashboard'); });
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $total = Naskah::where('author_id', $user->id)->count();
        $inReview = Naskah::where('author_id', $user->id)->where('status', 'dalam review')->count();
        $published = Naskah::where('author_id', $user->id)->where('status', 'diterima')->count();
        $recent = Naskah::where('author_id', $user->id)->orderByDesc('submitted_at')->limit(5)->get();

        return view('author.dashboard', compact('total', 'inReview', 'published', 'recent'));
    })->name('author.dashboard');
    Route::get('/naskah', [AuthorNaskahController::class, 'index'])->name('author.naskah.index');
    Route::get('/upload', [AuthorNaskahController::class, 'create'])->name('author.naskah.create');
    Route::post('/naskah', [AuthorNaskahController::class, 'store'])->name('author.naskah.store');
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
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $assignedCount = \App\Models\Naskah::where('reviewer_id', $user->id)->count();
        $completedCount = \App\Models\Naskah::where('reviewer_id', $user->id)->where('status', '<>', 'dalam review')->count();

        return view('reviewer.dashboard', compact('assignedCount', 'completedCount'));
    });

    Route::get('/naskah', function () {
        $user = auth()->user();
        $assignments = \App\Models\Naskah::where('reviewer_id', $user->id)->orderByDesc('created_at')->get();

        return view('reviewer.naskah.index', compact('assignments'));
    })->name('reviewer.naskah.index');

    Route::get('/naskah/{id}', function ($id) {
        $naskah = \App\Models\Naskah::findOrFail($id);
        abort_unless($naskah->reviewer_id === auth()->id(), 403);

        return view('reviewer.naskah.detail', compact('naskah'));
    });

    Route::post('/naskah/{id}/submit-review', function ($id) {
        $request = request();
        $request->validate([
            'status' => 'required|in:diterima,revisi,ditolak',
            'reviewer_notes' => 'required|string|min:10',
        ]);

        $naskah = \App\Models\Naskah::findOrFail($id);
        abort_unless($naskah->reviewer_id === auth()->id(), 403);

        $naskah->status = $request->status;
        $naskah->save();

        return redirect()->route('reviewer.naskah.index')
            ->with('success', 'Hasil review berhasil dikirim ke redaksi.');
    })->name('reviewer.naskah.submitReview');
});
