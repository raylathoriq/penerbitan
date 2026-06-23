<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Naskah;
use App\Models\Review;
use Illuminate\Http\Request;

class NaskahController extends Controller
{
    /**
     * Display the Reviewer's dashboard with statistics and recent assignments.
     */
    public function dashboard()
    {
        $user = auth()->user();
        $assignedCount = Review::where('id_user', $user->id)->whereNull('reviewed_at')->count();
        $completedCount = Review::where('id_user', $user->id)->whereNotNull('reviewed_at')->count();

        $recent = Naskah::where('reviewer_id', $user->id)
            ->with(['user', 'reviews' => function($q) use ($user) {
                $q->where('id_user', $user->id);
            }])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('reviewer.dashboard', compact('assignedCount', 'completedCount', 'recent'));
    }

    /**
     * Display a listing of all reviewer assignments.
     */
    public function index()
    {
        $user = auth()->user();
        $assignments = Naskah::where('reviewer_id', $user->id)
            ->with(['user', 'category', 'package', 'reviews' => function($q) use ($user) {
                $q->where('id_user', $user->id);
            }])
            ->orderByDesc('created_at')
            ->get();

        return view('reviewer.naskah.index', compact('assignments'));
    }

    /**
     * Display the specified review assignment details.
     */
    public function show(int $id)
    {
        $naskah = Naskah::with(['user', 'category', 'package', 'reviews' => function($q) {
            $q->where('id_user', auth()->id());
        }])->findOrFail($id);

        abort_unless($naskah->reviewer_id === auth()->id(), 403);

        return view('reviewer.naskah.detail', compact('naskah'));
    }

    /**
     * Submit reviewer evaluation, recommendation, comments, and corrections file.
     */
    public function submitReview(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,revisi,ditolak',
            'reviewer_notes' => 'required|string|min:10',
            'file-upload' => 'nullable|file|mimes:pdf,docx,doc|max:10240',
        ]);

        $naskah = Naskah::findOrFail($id);
        abort_unless($naskah->reviewer_id === auth()->id(), 403);

        // Update naskah status
        $naskah->status = $request->status;
        $naskah->save();

        // Update review record
        $review = $naskah->reviews()->where('id_user', auth()->id())->latest()->first();
        if ($review) {
            $review->comments = $request->reviewer_notes;
            $review->decision = $request->status;
            $review->reviewed_at = now();
            $review->save();
        }

        // Handle uploaded reviewer file coretan
        if ($request->hasFile('file-upload')) {
            $file = $request->file('file-upload');
            $path = $file->store('naskah', 'public');
            
            // Get last version for reviewer file coretan or default to 0
            $lastVersion = $naskah->files()
                ->where('jenis_file', 'reviewer_coretan')
                ->max('version') ?? 0;

            $naskah->files()->create([
                'jenis_file' => 'reviewer_coretan',
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'version' => $lastVersion + 1,
                'uploaded_at' => now(),
            ]);
        }

        return redirect()->route('reviewer.naskah.index')
            ->with('success', 'Hasil review berhasil dikirim ke redaksi.');
    }
}
