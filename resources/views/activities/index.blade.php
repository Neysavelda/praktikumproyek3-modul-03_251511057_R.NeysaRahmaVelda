@extends('layouts.app')

@section('content')
    <h1>Daftar Kegiatan</h1>

    <!-- Tombol Tambah Kegiatan -->
    <a href="{{ route('activities.create') }}" style="display:inline-block; margin-bottom: 10px; padding: 8px 12px; background: green; color: white; text-decoration: none;">+ Tambah Kegiatan</a>

    @forelse ($activities as $activity)
        <article style="border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom: 10px;">
            <h2>
                <a href="{{ route('activities.show', $activity) }}">
                    {{ $activity->title }}
                </a>
            </h2>
            <p>{{ \Carbon\Carbon::parse($activity->activity_date)->format('d M Y') }}</p>
            <p>Status: {{ $activity->status }}</p>

            <!-- Tombol Edit & Delete -->
            <a href="{{ route('activities.edit', $activity) }}">Edit</a> | 
            <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="color: red; border: none; background: none; cursor: pointer;">Hapus</button>
            </form>
        </article>
    @empty
        <p>Belum ada kegiatan.</p>
    @endforelse
@endsection