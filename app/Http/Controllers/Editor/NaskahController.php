<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Naskah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NaskahController extends Controller
{
    /**
     * Display the Editor dashboard with statistics.
     */
    public function dashboard()
    {
        $editorId = Auth::id();
        $waitingCount = Naskah::where('editor_id', $editorId)->where('status', 'perlu_edit')->count();
        $editingCount = Naskah::where('editor_id', $editorId)->where('status', 'editing')->count();
        $completedCount = Naskah::where('editor_id', $editorId)->where('status', 'selesai')->count();

        $recent = Naskah::where('editor_id', $editorId)
            ->whereIn('status', ['perlu_edit', 'editing'])
            ->with(['user', 'category', 'package'])
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();

        return view('editor.dashboard', compact('waitingCount', 'editingCount', 'completedCount', 'recent'));
    }

    /**
     * Display a listing of manuscripts for Editor.
     */
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'antrean');

        $query = Naskah::where('editor_id', Auth::id())->with(['user', 'category', 'package']);

        if ($tab === 'riwayat') {
            // Naskah yang pernah diedit oleh editor yang sedang login
            $query->whereHas('editorLogs', function ($q) {
                $q->where('id_user', Auth::id());
            });
        } else {
            // Naskah yang masuk antrean editor
            $query->whereIn('status', ['perlu_edit', 'editing', 'selesai']);
        }

        // Search filter
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
        if ($request->filled('status') && $request->status !== 'Semua status edit') {
            $statusMap = [
                'Menunggu Edit' => 'perlu_edit',
                'Sedang Disunting' => 'editing',
                'Selesai Disunting' => 'selesai',
            ];
            if (isset($statusMap[$request->status])) {
                $query->where('status', $statusMap[$request->status]);
            }
        }

        $naskahs = $query->orderByDesc('updated_at')->get();

        return view('editor.naskah.index', compact('naskahs', 'tab'));
    }

    /**
     * Display the specified manuscript details for Editor.
     */
    public function show(int $id)
    {
        $naskah = Naskah::with(['user', 'category', 'package', 'reviews.reviewer', 'editorLogs.editor', 'files'])->findOrFail($id);

        abort_unless($naskah->editor_id === Auth::id(), 403);

        return view('editor.naskah.detail', compact('naskah'));
    }

    /**
     * Submit editor updates, notes, and edited manuscript.
     */
    public function submitEdit(Request $request, int $id)
    {
        $request->validate([
            'editing_status' => 'required|in:draft,perlu_cek,siap_dikirim',
            'editor_notes' => 'required|string|min:10',
            'edited_file' => 'nullable|file|mimes:pdf,docx,doc|max:10240', // max 10MB
            'cover_file' => 'nullable|file|image|mimes:jpeg,png,jpg|max:5120', // max 5MB image
        ]);

        $naskah = Naskah::findOrFail($id);

        abort_unless($naskah->editor_id === Auth::id(), 403);

        // Map form decision status to database status
        // - draft / perlu_cek -> keep status as 'editing'
        // - siap_dikirim -> change status to 'selesai'
        $dbStatus = 'editing';
        if ($request->editing_status === 'siap_dikirim') {
            $dbStatus = 'selesai';
        }

        $naskah->status = $dbStatus;
        $naskah->save();

        // Save editor comments/notes in editor_log table
        $naskah->editorLogs()->create([
            'id_user' => Auth::id(), // Editor User ID
            'comments' => $request->editor_notes,
            'decision' => $request->editing_status,
            'tanggal_edit' => now(),
        ]);

        // Handle uploaded edited file
        if ($request->hasFile('edited_file')) {
            $file = $request->file('edited_file');
            $path = $file->store('naskah', 'public');

            // Calculate next version
            $lastVersion = $naskah->files()
                ->where('jenis_file', 'editor_editing')
                ->max('version') ?? 0;

            $naskah->files()->create([
                'jenis_file' => 'editor_editing',
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'version' => $lastVersion + 1,
                'uploaded_at' => now(),
            ]);
        }

        // Handle uploaded cover file
        if ($request->hasFile('cover_file')) {
            $file = $request->file('cover_file');
            $path = $file->store('naskah/cover', 'public');

            // Calculate next version
            $lastVersion = $naskah->files()
                ->where('jenis_file', 'cover')
                ->max('version') ?? 0;

            $naskah->files()->create([
                'jenis_file' => 'cover',
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'version' => $lastVersion + 1,
                'uploaded_at' => now(),
            ]);
        }

        return redirect()->route('editor.naskah.index')
            ->with('success', 'Hasil suntingan berhasil disimpan.');
    }
}
