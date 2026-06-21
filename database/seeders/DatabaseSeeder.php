<?php

namespace Database\Seeders;

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
        // Penulis / Author Default
        User::firstOrCreate([
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

        // Reviewer / Dosen Pakar Default
        User::firstOrCreate([
            'email' => 'reviewer@upnvj.ac.id',
        ], [
            'name' => 'Reviewer',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
            'afiliasi' => 'Ahli Komputer UPNVJ',
        ]);

        // Contoh Naskah untuk Manajemen Admin
        $author = User::where('role', 'author')->first();

        Naskah::create([
            'title' => 'Dasar Logika Matematika',
            'author_id' => $author->id,
            'author_name' => 'Dr. Budi Santoso',
            'status' => 'diajukan',
            'description' => 'Naskah ini membahas secara komprehensif terkait struktur dan dasar-dasar logika matematika untuk keperluan publikasi akademik.',
            'document_name' => 'Naskah_Logika_Final.pdf',
            'document_size' => '2.4 MB',
        ]);

        Naskah::create([
            'title' => 'Panduan Sistem Basis Data',
            'author_id' => $author->id,
            'author_name' => 'Dr. Rina Kurniawati',
            'status' => 'dalam review',
            'description' => 'Naskah panduan ini mengupas desain dan implementasi basis data dengan studi kasus dunia nyata.',
            'document_name' => 'Panduan_DB_2026.pdf',
            'document_size' => '3.1 MB',
        ]);
    }
}
