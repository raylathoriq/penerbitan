<?php

namespace Database\Seeders;

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
        User::create([
            'name' => 'Penulis UPNVJ',
            'email' => 'author@upnvj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'author',
            'afiliasi' => 'FIK UPNVJ',
        ]);

        // Admin / Redaksi Default
        User::create([
            'name' => 'Admin',
            'email' => 'admin@upnvj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Editor / Penyunting Naskah Default
        User::create([
            'name' => 'Editor LPPM',
            'email' => 'editor@upnvj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'editor',
            'afiliasi' => 'LPPM UPNVJ Press',
        ]);

        // Reviewer / Dosen Pakar Default
        User::create([
            'name' => 'Reviewer',
            'email' => 'reviewer@upnvj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
            'afiliasi' => 'Ahli Komputer UPNVJ',
        ]);
    }
}
