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

        $documentName = null;
        $documentPath = null;
        $documentSize = null;

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('naskah', 'public');
            $documentName = $file->getClientOriginalName();
            $documentPath = $path;
            $documentSize = round($file->getSize() / 1024, 1) . ' KB';
        }

        Naskah::create([
            'author_id' => Auth::id(),
            'category_id' => $request->category_id,
            'package_id' => $request->package_id,
            'title' => $request->title,
            'description' => $request->description,
            'co_author' => $request->co_authors,
            'document_name' => $documentName,
            'document_path' => $documentPath,
            'document_size' => $documentSize,
            'status' => 'diajukan',
            'submitted_at' => now(),
        ]);

        return redirect()->route('author.naskah.index')
            ->with('success', 'Naskah berhasil diajukan.');
    }

    /**
     * Display the specified submission detail for Author.
     */
    public function show(int $id)
    {
        $naskah = Naskah::where('author_id', Auth::id())
            ->with(['category', 'package', 'user'])
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
}
