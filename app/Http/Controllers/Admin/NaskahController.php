<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Naskah;
use App\Models\User;
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

    public function show(int $id)
    {
        $naskah = Naskah::with(['user', 'category', 'package', 'reviewer'])->findOrFail($id);
        $reviewers = User::where('role', 'reviewer')->get();

        return view('admin.naskah.detail', compact('naskah', 'reviewers'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|string|in:diajukan,dalam review,revisi,diterima,ditolak',
        ]);

        $naskah = Naskah::findOrFail($id);
        $naskah->status = $request->status;
        $naskah->save();

        return redirect()->route('admin.naskah.show', $naskah->id)
            ->with('success', 'Status naskah berhasil diubah.');
    }

    public function assignReviewer(Request $request, int $id)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
        ]);

        $naskah = Naskah::findOrFail($id);
        $reviewer = User::where('id', $request->reviewer_id)->where('role', 'reviewer')->firstOrFail();

        $naskah->reviewer_id = $reviewer->id;
        $naskah->reviewer_name = $reviewer->name;
        $naskah->status = 'dalam review';
        $naskah->save();

        return redirect()->route('admin.naskah.show', $naskah->id)
            ->with('success', 'Naskah berhasil ditugaskan ke reviewer.');
    }
}
