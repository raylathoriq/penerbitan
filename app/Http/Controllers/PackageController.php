<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::all();
        return view('admin.paket.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
        'nama_paket'=> 'required|string|max:255',
        'harga'=> 'required|integer',
        'deskripsi'=> 'required|string',
        'status'=> 'required|in:Aktif,Nonaktif',
        ],[
        'nama_paket' => 'Nama paket harus diisi',
        'harga' => 'Harga harus diisi',
        'deskripsi' => 'Deskripsi harus diisi',
        'status' => 'Status harus diisi',
        ]);

        Package::create($request->all());
        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        //
        $request->validate([
        'nama_paket'=> 'required|string|max:255',
        'harga'=> 'required|integer',
        'deskripsi'=> 'required|string',
        'status'=> 'required|in:Aktif,Nonaktif',
        ],[
        'nama_paket' => 'Nama paket harus diisi',
        'harga' => 'Harga harus diisi',
        'deskripsi' => 'Deskripsi harus diisi',
        'status' => 'Status harus diisi',
        ]);
        $package->update($request->all());
        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil diubah');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil dihapus');
    }
}
