<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Display a listing of all submissions for Admin.
     */
    public function adminIndex(Request $request)
    {
        $query = Submission::with(['user', 'category', 'package']);

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

        $submissions = $query->latest()->get();

        return view('admin.naskah.index', compact('submissions'));
    }

    /**
     * Display a listing of submissions for the authenticated Author.
     */
    public function authorIndex()
    {
        $submissions = Submission::where('user_id', auth()->id())
            ->with(['category', 'package'])
            ->latest()
            ->get();

        return view('author.list-naskah', compact('submissions'));
    }

    /**
     * Show the form for creating a new submission.
     */
    public function authorCreate()
    {
        $categories = Category::all();
        $packages = Package::where('status', 'Aktif')->get();

        return view('author.upload', compact('categories', 'packages'));
    }

    /**
     * Store a newly created submission in database.
     */
    public function authorStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'package_id' => 'required|exists:packages,id',
            'sinopsis' => 'required|string',
            'file_naskah' => 'required|file|mimes:pdf,docx,doc|max:10240', // max 10MB
            'co_authors' => 'nullable|array',
            'co_authors.*.name' => 'required_with:co_authors|string|max:255',
            'co_authors.*.email' => 'required_with:co_authors|email|max:255',
            'co_authors.*.affiliation' => 'required_with:co_authors|string|max:255',
        ]);

        // Upload the file to public storage
        $path = $request->file('file_naskah')->store('submissions', 'public');

        // Create the submission record
        Submission::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'package_id' => $request->package_id,
            'title' => $request->title,
            'sinopsis' => $request->sinopsis,
            'co_author' => $request->co_authors, // automatically serialized to JSON
            'file_path' => $path,
            'status' => 'Diajukan',
        ]);

        return redirect()->route('author.naskah.index')->with('success', 'Naskah berhasil diajukan!');
    }

    /**
     * Display the specified submission detail for Author.
     */
    public function authorShow($id)
    {
        $submission = Submission::where('user_id', auth()->id())
            ->where('id', $id)
            ->with(['category', 'package', 'user'])
            ->firstOrFail();

        return view('author.detail-naskah', compact('submission'));
    }

    /**
     * Display the Author's dashboard with real-time statistics and activity log.
     */
    public function authorDashboard()
    {
        $userId = auth()->id();
        
        $totalSubmissions = Submission::where('user_id', $userId)->count();
        
        $inReview = Submission::where('user_id', $userId)
            ->whereIn('status', ['Dalam Review', 'Revisi'])
            ->count();
            
        $published = Submission::where('user_id', $userId)
            ->where('status', 'Terbit')
            ->count();

        $activities = Submission::where('user_id', $userId)
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('author.dashboard', compact('totalSubmissions', 'inReview', 'published', 'activities'));
    }
}



