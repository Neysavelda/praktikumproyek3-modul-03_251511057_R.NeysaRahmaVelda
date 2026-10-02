<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class ActivityService
{
    // ... method kamu yang sudah ada sebelumnya ...

    public function registerParticipant(Activity $activity, array $data)
    {
        // 1. Validasi aturan bisnis sebelum transaksi
        if ($activity->status !== 'published') {
            throw new \Exception('Pendaftaran hanya untuk kegiatan yang published.');
        }
        if ($activity->start_at && $activity->start_at->isPast()) {
            throw new \Exception('Pendaftaran ditolak karena kegiatan sudah lewat.');
        }
        if ($activity->registered_count >= $activity->capacity) {
            throw new \Exception('Kapasitas kegiatan sudah penuh.');
        }

        // 2. Transaksi atomic
        return DB::transaction(function () use ($activity, $data) {
            $registration = Registration::create([
                'activity_id'      => $activity->id,
                'participant_name' => $data['participant_name'],
                'email'            => $data['email'],
                'registered_at'    => now(),
            ]);

            throw new \Exception('Simulasi error');
            $activity->increment('registered_count');

            return $registration;
        });
    }
}