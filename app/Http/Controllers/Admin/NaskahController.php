<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Naskah;
use App\Models\User;
use Illuminate\Http\Request;

class NaskahController extends Controller
{
    public function index()
    {
        $naskahs = Naskah::orderByDesc('created_at')->get();

        return view('admin.naskah.index', compact('naskahs'));
    }

    public function show(int $id)
    {
        $naskah = Naskah::findOrFail($id);
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
