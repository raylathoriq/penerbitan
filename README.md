# UPNVJ Press - Sistem Informasi Pengajuan & Penerbitan Naskah Buku

Aplikasi berbasis web untuk mengelola siklus hidup penerbitan naskah buku secara transparan dan digital. Aplikasi ini mengintegrasikan peran Penulis (Author), Penelaah (Reviewer), Penyunting (Editor), dan Redaksi (Admin) dalam satu platform terpadu.

## Fitur Utama

- **Panel Author**:
  - Pengajuan naskah baru dengan informasi kategori, paket penerbitan, deskripsi, berkas naskah, dan daftar penulis pendamping.
  - Pengunggahan berkas revisi berdasarkan umpan balik reviewer.
  - Pembatalan pengajuan naskah (status berubah menjadi 'Dibatalkan' tanpa menghapus berkas/data).
  - Pemantauan progres naskah secara kronologis dan interaktif.

- **Panel Reviewer (Pakar)**:
  - Melihat daftar naskah yang ditugaskan untuk direview.
  - Form evaluasi berupa pilihan rekomendasi (Diterima / Revisi / Ditolak), catatan evaluasi, dan pengunggahan berkas coretan koreksi.

- **Panel Editor (Penyunting)**:
  - Mengunduh naskah terbaru milik penulis (baik orisinil maupun revisi).
  - Mengunggah draf penyuntingan dan berkas cover buku.
  - Mengirimkan permintaan klarifikasi / catatan revisi ke penulis.

- **Panel Admin (Redaksi)**:
  - Dashboard statistik naskah (Total, Dalam Review, Sedang Disunting, Diterima, Ditolak).
  - Manajemen master Kategori dan Paket Penerbitan (CRUD).
  - Manajemen Pengguna (CRUD).
  - Penugasan Reviewer dan Editor untuk setiap naskah yang diajukan.

## Teknologi yang Digunakan

- **Backend**: Laravel 11.x (PHP 8.x)
- **Frontend**: Tailwind CSS & Alpine.js
- **Database**: MySQL

## Kebutuhan Sistem (Prerequisites)

Sebelum menjalankan aplikasi, pastikan laptop Anda sudah terinstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / Laragon / XAMPP

## Langkah Instalasi & Menjalankan di Lokal

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/raylathoriq/penerbitan.git
   cd penerbitan
   ```

2. **Install Dependensi PHP**:
   ```bash
   composer install
   ```

3. **Install Dependensi Frontend (JS/CSS)**:
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**:
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` baru tersebut, lalu sesuaikan koneksi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=penerbitan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database & Seeding Data Awal**:
   Perintah ini akan membuat semua tabel dan memasukkan akun demo pengguna bawaan:
   ```bash
   php artisan migrate --seed
   ```

7. **Hubungkan Storage Link (untuk unggah file naskah & cover)**:
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Server Lokal**:
   Jalankan kedua perintah di bawah ini secara bersamaan di terminal terpisah:
   - **Terminal 1** (untuk server PHP):
     ```bash
     php artisan serve
     ```
   - **Terminal 2** (untuk compiler Tailwind CSS):
     ```bash
     npm run dev
     ```

Aplikasi dapat diakses melalui browser di alamat: `http://127.0.0.1:8000`

---

## Akun Demo Default (Seeder)

Anda dapat menggunakan akun-akun di bawah ini untuk menguji fungsionalitas aplikasi:

| Peran (Role) | Email | Password |
|---|---|---|
| **Admin (Redaksi)** | `admin@upnvj.ac.id` | `password` |
| **Author (Penulis)** | `author@upnvj.ac.id` | `password` |
| **Reviewer (Pakar)** | `reviewer@upnvj.ac.id` | `password` |
| **Editor (Penyunting)** | `editor@upnvj.ac.id` | `password` |
