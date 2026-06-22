<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Naskah;
use Illuminate\Http\Request;

class NaskahController extends Controller
{
    /**
     * Display a listing of all submissions for Admin with search and status filtering.
     */
    public function index(Request $request)
    {
        $query = Naskah::with(['user', 'category', 'package']);

        // Search filter (by title or author name)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status);
        }

        $naskahs = $query->orderByDesc('created_at')->get();

        return view('admin.naskah.index', compact('naskahs'));
    }

    /**
     * Display the specified submission detail for Admin.
     */
    public function show(int $id)
    {
        $naskah = Naskah::with(['user', 'category', 'package'])->findOrFail($id);

        return view('admin.naskah.detail', compact('naskah'));
    }
}
