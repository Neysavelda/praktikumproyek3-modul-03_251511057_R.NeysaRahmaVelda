<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Validation\ValidationException;

class ActivityService
{
    public function update(Activity $activity, array $data): Activity
    {
        $activity->update($data);
        return $activity;
    }

    public function publish(Activity $activity): Activity
    {
        if ($activity->status !== 'draft') {
            throw ValidationException::withMessages([
                'publish' => 'Hanya kegiatan berstatus draft yang dapat dipublikasikan.'
            ]);
        }

        $requiredFields = [
            'category_id' => 'Kategori',
            'code'        => 'Kode Kegiatan',
            'title'       => 'Judul Kegiatan',
            'location'    => 'Lokasi',
            'start_at'    => 'Waktu Mulai',
            'end_at'      => 'Waktu Selesai',
            'capacity'    => 'Kapasitas',
        ];

        $missingFields = [];
        foreach ($requiredFields as $field => $label) {
            if (empty($activity->{$field})) {
                $missingFields[] = $label;
            }
        }

        if (!empty($missingFields)) {
            $fieldsList = implode(', ', $missingFields);
            throw ValidationException::withMessages([
                'publish' => "Gagal mempublikasikan kegiatan. Field berikut harus diisi terlebih dahulu: {$fieldsList}."
            ]);
        }

        $activity->update(['status' => 'published']);

        return $activity;
    }

    public function complete(Activity $activity): Activity
    {
        if ($activity->status !== 'published') {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan berstatus published yang dapat diselesaikan.'
            ]);
        }

        $activity->update(['status' => 'completed']);

        return $activity;
    }
}