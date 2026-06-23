<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package;
use App\Models\Naskah;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Kategori Seeding
        $cat1 = Category::firstOrCreate(['nama_kategori' => 'Buku Ajar']);
        $cat2 = Category::firstOrCreate(['nama_kategori' => 'Buku Referensi']);
        $cat3 = Category::firstOrCreate(['nama_kategori' => 'Monograf']);

        // Paket Seeding
        $pkg1 = Package::firstOrCreate([
            'nama_paket' => 'Paket Reguler',
        ], [
            'harga' => 2000000,
            'deskripsi' => 'Pengurusan ISBN dan Layout Standard',
            'status' => 'Aktif',
        ]);

        $pkg2 = Package::firstOrCreate([
            'nama_paket' => 'Paket Premium',
        ], [
            'harga' => 5000000,
            'deskripsi' => 'Pengurusan ISBN, Layout, Desain Cover, dan Editing Bahasa',
            'status' => 'Aktif',
        ]);

        // Penulis / Author Default
        $author = User::firstOrCreate([
            'email' => 'author@upnvj.ac.id',
        ], [
            'name' => 'Penulis UPNVJ',
            'password' => bcrypt('password'),
            'role' => 'author',
            'afiliasi' => 'FIK UPNVJ',
        ]);

        // Admin / Redaksi Default
        User::firstOrCreate([
            'email' => 'admin@upnvj.ac.id',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Editor / Penyunting Naskah Default
        User::firstOrCreate([
            'email' => 'editor@upnvj.ac.id',
        ], [
            'name' => 'Editor LPPM',
            'password' => bcrypt('password'),
            'role' => 'editor',
            'afiliasi' => 'LPPM UPNVJ Press',
        ]);

        // Reviewer / Dosen Pakar Default
        User::firstOrCreate([
            'email' => 'reviewer@upnvj.ac.id',
        ], [
            'name' => 'Reviewer',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
            'afiliasi' => 'Ahli Komputer UPNVJ',
        ]);

    }
}
