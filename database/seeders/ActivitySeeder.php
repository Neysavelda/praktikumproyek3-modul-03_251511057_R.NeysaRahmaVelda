<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Activity::query()->insert([
            [
                'category_id' => 1,
                'title' => 'Workshop Git Dasar',
                'description' => 'Latihan kolaborasi repository.',
                'activity_date' => '2026-10-05',
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'title' => 'Seminar Web Quality',
                'description' => 'Pengenalan maintainability dan testing.',
                'activity_date' => '2026-10-12',
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'title' => 'Pelatihan Laravel Basic',
                'description' => 'Sesi praktik membangun CRUD sederhana.',
                'activity_date' => '2026-09-28',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'title' => 'Diskusi Business Logic',
                'description' => 'Membahas pemisahan tanggung jawab controller dan service.',
                'activity_date' => '2026-09-20',
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'title' => 'Onboarding Mahasiswa Baru',
                'description' => 'Pengenalan alur kerja praktikum Proyek 3.',
                'activity_date' => '2026-09-01',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}