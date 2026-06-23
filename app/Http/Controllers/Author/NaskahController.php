<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\Naskah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NaskahController extends Controller
{
    /**
     * Display a listing of submissions for the authenticated Author.
     */
    public function index()
    {
        $naskahs = Naskah::where('author_id', Auth::id())
            ->with(['category', 'package'])
            ->orderByDesc('created_at')
            ->get();

        return view('author.list-naskah', compact('naskahs'));
    }

    /**
     * Show the form for creating a new submission.
     */
    public function create()
    {
        $categories = Category::all();
        $packages = Package::where('status', 'Aktif')->get();

        return view('author.upload', compact('categories', 'packages'));
    }

    /**
     * Store a newly created submission in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'package_id' => 'required|exists:packages,id',
            'description' => 'required|string',
            'document' => 'required|file|mimes:pdf,docx,doc|max:10240', // max 10MB
            'co_authors' => 'nullable|array',
            'co_authors.*.name' => 'required_with:co_authors|string|max:255',
            'co_authors.*.email' => 'required_with:co_authors|email|max:255',
            'co_authors.*.affiliation' => 'required_with:co_authors|string|max:255',
        ]);

        $naskah = Naskah::create([
            'author_id' => Auth::id(),
            'category_id' => $request->category_id,
            'package_id' => $request->package_id,
            'title' => $request->title,
            'description' => $request->description,
            'co_author' => $request->co_authors,
            'status' => 'diajukan',
            'submitted_at' => now(),
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('naskah', 'public');
            
            $naskah->files()->create([
                'jenis_file' => 'original',
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'version' => 1,
                'uploaded_at' => now(),
            ]);
        }

        return redirect()->route('author.naskah.index')
            ->with('success', 'Naskah berhasil diajukan.');
    }

    public function show(int $id)
    {
        $naskah = Naskah::where('author_id', Auth::id())
            ->with(['category', 'package', 'user', 'reviews.reviewer', 'files'])
            ->findOrFail($id);

        return view('author.detail-naskah', compact('naskah'));
    }

    /**
     * Display the Author's dashboard with real-time statistics and activity log.
     */
    public function dashboard()
    {
        $userId = Auth::id();
        $total = Naskah::where('author_id', $userId)->count();
        $inReview = Naskah::where('author_id', $userId)
            ->whereIn('status', ['dalam review', 'revisi'])
            ->count();
        $published = Naskah::where('author_id', $userId)
            ->where('status', 'diterima')
            ->count();
        $recent = Naskah::where('author_id', $userId)
            ->orderByDesc('submitted_at')
            ->limit(5)
            ->get();

        return view('author.dashboard', compact('total', 'inReview', 'published', 'recent'));
    }

    /**
     * Show revision upload page for Author.
     */
    public function revisi(int $id)
    {
        $naskah = Naskah::where('author_id', Auth::id())
            ->with(['reviews' => function($q) {
                $q->whereNotNull('reviewed_at')->latest();
            }])
            ->findOrFail($id);

        return view('author.revisi', compact('naskah'));
    }

    /**
     * Store the submitted revision file and note.
     */
    public function storeRevisi(Request $request, int $id)
    {
        $request->validate([
            'jurnal_revisi' => 'nullable|string',
            'document_revisi' => 'required|file|mimes:pdf,docx,doc|max:10240', // max 10MB
        ]);

        $naskah = Naskah::where('author_id', Auth::id())->findOrFail($id);

        if ($request->hasFile('document_revisi')) {
            $file = $request->file('document_revisi');
            $path = $file->store('naskah', 'public');
            
            // Calculate next version
            $lastVersion = $naskah->files()->max('version') ?? 1;
            $nextVersion = $lastVersion + 1;

            $naskah->files()->create([
                'jenis_file' => 'revisi',
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'version' => $nextVersion,
                'uploaded_at' => now(),
            ]);
        }

        // Update review record to reset reviewed_at and save the revision journal
        $review = $naskah->reviews()->where('id_user', $naskah->reviewer_id)->latest()->first();
        if ($review) {
            $review->revision_note = $request->jurnal_revisi;
            $review->decision = null;
            $review->reviewed_at = null;
            $review->save();
        }

        // Change manuscript status back to 'dalam review' so reviewer can re-evaluate
        $naskah->status = 'dalam review';
        $naskah->save();

        return redirect()->route('author.naskah.index')
            ->with('success', 'Naskah revisi berhasil dikirim ke reviewer.');
    }
}
