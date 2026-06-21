<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Naskah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NaskahController extends Controller
{
    public function index()
    {
        $naskahs = Naskah::where('author_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('author.list-naskah', compact('naskahs'));
    }

    public function create()
    {
        return view('author.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $documentName = null;
        $documentPath = null;
        $documentSize = null;

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('naskah', 'public');
            $documentName = basename($path);
            $documentPath = $path;
            $documentSize = round($file->getSize() / 1024, 1) . ' KB';
        }

        $naskah = Naskah::create([
            'title' => $request->title,
            'category' => $request->category,
            'author_id' => Auth::id(),
            'author_name' => Auth::user()->name,
            'status' => 'diajukan',
            'submitted_at' => now(),
            'description' => $request->description,
            'document_name' => $documentName,
            'document_path' => $documentPath,
            'document_size' => $documentSize,
        ]);

        return redirect()->route('author.naskah.show', $naskah)
            ->with('success', 'Naskah berhasil diajukan.');
    }

    public function show(int $id)
    {
        $naskah = Naskah::where('author_id', Auth::id())->findOrFail($id);

        return view('author.detail-naskah', compact('naskah'));
    }
}
