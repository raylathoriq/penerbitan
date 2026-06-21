<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Naskah;
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

        return view('admin.naskah.detail', compact('naskah'));
    }
}
