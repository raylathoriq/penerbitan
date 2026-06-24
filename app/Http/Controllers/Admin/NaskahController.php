<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Naskah;
use App\Models\User;
use Illuminate\Http\Request;

class NaskahController extends Controller
{
    /**
     * Display the Admin dashboard with statistics.
     */
    public function dashboard()
    {
        $total = Naskah::count();
        $inReview = Naskah::where('status', 'dalam review')->count();
        $published = Naskah::where('status', 'diterima')->count();
        $rejected = Naskah::where('status', 'ditolak')->count();
        $recent = Naskah::with('user')->orderByDesc('submitted_at')->limit(5)->get();

        return view('admin.dashboard', compact('total', 'inReview', 'published', 'rejected', 'recent'));
    }

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
        $naskah = Naskah::with(['user', 'category', 'package', 'reviewer', 'editor', 'reviews.reviewer', 'editorLogs.editor', 'files'])->findOrFail($id);
        $reviewers = User::where('role', 'reviewer')->get();
        $editors = User::where('role', 'editor')->get();

        return view('admin.naskah.detail', compact('naskah', 'reviewers', 'editors'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|string|in:diajukan,dalam review,revisi,diterima,ditolak,pengajuan_isbn,perlu_edit,editing,selesai',
            'note' => 'nullable|string',
        ]);

        $naskah = Naskah::findOrFail($id);
        $naskah->status = $request->status;
        $naskah->save();

        if ($request->filled('note')) {
            $naskah->reviews()->create([
                'id_user' => auth()->id(), // Admin's User ID
                'comments' => $request->note,
                'decision' => $request->status,
                'reviewed_at' => now(),
            ]);
        }

        return redirect()->route('admin.naskah.show', $naskah->id)
            ->with('success', 'Status naskah dan catatan berhasil disimpan.');
    }

    public function assignReviewer(Request $request, int $id)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
            'note' => 'nullable|string',
        ]);

        $naskah = Naskah::findOrFail($id);
        $reviewer = User::where('id', $request->reviewer_id)->where('role', 'reviewer')->firstOrFail();

        $naskah->reviewer_id = $reviewer->id;
        $naskah->status = 'dalam review';
        $naskah->save();

        // Create record in reviews table
        $naskah->reviews()->create([
            'id_user' => $reviewer->id,
            'assignment_note' => $request->note,
        ]);

        return redirect()->route('admin.naskah.show', $naskah->id)
            ->with('success', 'Naskah berhasil ditugaskan ke reviewer.');
    }

    public function assignEditor(Request $request, int $id)
    {
        $request->validate([
            'editor_id' => 'required|exists:users,id',
            'note' => 'nullable|string',
        ]);

        $naskah = Naskah::findOrFail($id);
        $editor = User::where('id', $request->editor_id)->where('role', 'editor')->firstOrFail();

        $naskah->editor_id = $editor->id;
        $naskah->status = 'perlu_edit';
        $naskah->save();

        // Create initial assignment record in editor_log table
        $naskah->editorLogs()->create([
            'id_user' => $editor->id,
            'comments' => $request->note,
            'decision' => 'perlu_edit', // Set as 'perlu_edit' to represent the assign event
            'tanggal_edit' => now(),
        ]);

        return redirect()->route('admin.naskah.show', $naskah->id)
            ->with('success', 'Naskah berhasil ditugaskan ke editor.');
    }
}
