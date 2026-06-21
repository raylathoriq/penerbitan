<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Mengambil semua data pengguna untuk ditampilkan di view admin.users
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input dari request
        $validatedData = $request->validate([
            'role' => 'required|in:author,reviewer,editor,admin',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'afiliasi' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        
        $user->update($validatedData);

        
        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil dihapus.');
    }
}
