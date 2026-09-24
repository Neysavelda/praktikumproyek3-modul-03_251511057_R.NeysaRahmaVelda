# Activity Manager

Aplikasi manajemen kegiatan berbasis Laravel yang dikembangkan sebagai bagian dari mata kuliah Proyek 3, Modul 3 (Frameworks in Programming – Laravel Basic).

**Mahasiswa:** R. Neysa Rahma Velda
**NIM:** 251511057
**Kelas:** D3 - 2B

---

## Tentang Aplikasi

Activity Manager v1 adalah aplikasi CRUD sederhana untuk mengelola data kegiatan kampus. Aplikasi ini dibangun menggunakan Laravel 13 dengan menerapkan pemisahan tanggung jawab antara route, controller, Form Request, dan Blade view sesuai prinsip yang diajarkan pada Modul 3.

## Teknologi yang Digunakan

- **Laravel 13**
- **PHP 8.3**
- **SQLite** sebagai database
- **Blade** sebagai templating engine

## Cara Menjalankan Proyek

1. Clone repository ini:
```bash
   git clone https://github.com/Neysavelda/praktikumproyek3-modul-03_251511057_R.NeysaRahmaVelda
   cd praktikumproyek3-modul-03_251511057_R.NeysaRahmaVelda
```

2. Install dependency PHP melalui Composer:
```bash
   composer install
```

3. Salin file environment:
```bash
   copy .env.example .env
```

4. Generate application key:
```bash
   php artisan key:generate
```

5. Buat file database SQLite kosong:
```bash
   type nul > database\database.sqlite
```

6. Jalankan migration untuk membuat struktur tabel:
```bash
   php artisan migrate
```

7. Jalankan seeder untuk mengisi data kegiatan awal:
```bash
   php artisan db:seed --class=ActivitySeeder
```

8. Jalankan server pengembangan:
```bash
   php artisan serve
```

9. Buka browser dan akses:
http://127.0.0.1:8000/activities


## Route Utama

| Method | URL                      | Fungsi                              |
|--------|--------------------------|--------------------------------------|
| GET    | `/activities`            | Daftar kegiatan (mendukung filter `?status=Planned`) |
| GET    | `/activities/create`     | Form tambah kegiatan                |
| POST   | `/activities`            | Menyimpan kegiatan baru             |
| GET    | `/activities/{id}`       | Detail satu kegiatan                |
| GET    | `/activities/{id}/edit`  | Form ubah kegiatan                  |
| PUT    | `/activities/{id}`       | Menyimpan perubahan kegiatan        |
| DELETE | `/activities/{id}`       | Menghapus kegiatan                  |

## Fitur

- CRUD kegiatan lengkap (tambah, lihat daftar, lihat detail, ubah, hapus)
- Filter daftar kegiatan berdasarkan status melalui query string (`?status=Planned`)
- Validasi input menggunakan Form Request (`StoreActivityRequest`, `UpdateActivityRequest`)
- Layout Blade terpusat (`layouts.app`) digunakan secara konsisten di seluruh halaman
- Struktur data kegiatan: judul, deskripsi, tanggal, kategori, dan status (Planned/Ongoing/Done)

## Struktur Folder Penting
app/
├── Http/
│ ├── Controllers/ActivityController.php
│ └── Requests/
│ ├── StoreActivityRequest.php
│ └── UpdateActivityRequest.php
└── Models/Activity.php

database/
├── migrations/..._create_activities_table.php
└── seeders/ActivitySeeder.php

resources/views/
├── layouts/app.blade.php
└── activities/
├── index.blade.php
├── show.blade.php
├── create.blade.php
├── edit.blade.php
└── _form.blade.php
routes/web.php


## Business Rules

| ID | Aturan |
|----|--------|
| BR-01 | Judul kegiatan wajib diisi, 5–100 karakter |
| BR-02 | Tanggal kegiatan wajib diisi dan valid |
| BR-03 | Status hanya boleh bernilai Planned, Ongoing, atau Done |