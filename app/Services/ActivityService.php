<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ActivityService
{
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

            $activity->increment('registered_count');

            return $registration;
        });
    }

    public function createActivity(array $data)
    {
        // Set activity_date otomatis dari start_at jika belum ada
        if (!isset($data['activity_date']) && isset($data['start_at'])) {
            $data['activity_date'] = Carbon::parse($data['start_at'])->toDateString();
        }

        if (isset($data['poster'])) {
            // Simpan file poster ke storage
            $data['poster_path'] = $data['poster']->store('posters', 'public');
            
            // Hapus key 'poster' agar tidak di-insert ke database
            unset($data['poster']);
        }

        return Activity::create($data);
    }

    public function updateActivity(Activity $activity, array $data)
    {
        // Update activity_date jika start_at berubah
        if (isset($data['start_at'])) {
            $data['activity_date'] = Carbon::parse($data['start_at'])->toDateString();
        }

        if (isset($data['poster'])) {
            // Hapus poster lama dari disk public jika ada
            if ($activity->poster_path && Storage::disk('public')->exists($activity->poster_path)) {
                Storage::disk('public')->delete($activity->poster_path);
            }

            // Simpan poster baru
            $data['poster_path'] = $data['poster']->store('posters', 'public');
            
            // Hapus key 'poster' agar tidak di-update ke database
            unset($data['poster']);
        }

        $activity->update($data);

        return $activity;
    }

    public function restore($id)
    {
        return Activity::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete($id)
    {
        return Activity::onlyTrashed()->findOrFail($id)->forceDelete();
    }
}