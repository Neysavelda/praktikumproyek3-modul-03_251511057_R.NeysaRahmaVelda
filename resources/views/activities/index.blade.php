@extends('layouts.app')

@section('content')

    <h1>Daftar Kegiatan</h1>

    <!-- Tombol Tambah Kegiatan -->
    <a href="{{ route('activities.create') }}" style="display:inline-block; margin-bottom: 15px; padding: 8px 12px; background: green; color: white; text-decoration: none; border-radius: 4px;">+ Tambah Kegiatan</a>

    <!-- Form Search, Filter Kategori, Filter Status, & Sort -->
    <form method="GET" action="{{ route('activities.index') }}" style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
        
        <!-- Input Search -->
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan..." style="padding: 6px 10px;">

        <!-- Dropdown Kategori -->
        <select name="category_id" style="padding: 6px 10px;">
            <option value="">-- Semua Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <!-- Dropdown Status (Sudah Menggunakan status baru: draft, published, completed) -->
        <select name="status" style="padding: 6px 10px;">
            <option value="">-- Semua Status --</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <!-- Dropdown Sorting -->
        <select name="sort" style="padding: 6px 10px;">
            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
        </select>

        <button type="submit" style="padding: 6px 12px; background: #2196F3; color: white; border: none; cursor: pointer; border-radius: 4px;">Filter</button>
        <a href="{{ route('activities.index') }}" style="padding: 6px 12px; background: #777; color: white; text-decoration: none; border-radius: 4px;">Reset</a>
    </form>

    <!-- Daftar Kegiatan -->
    @forelse ($activities as $activity)
        <article style="border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom: 10px;">
            <h2>
                <a href="{{ route('activities.show', $activity) }}">
                    {{ $activity->title }}
                </a>
            </h2>
            <p><strong>Kategori:</strong> {{ $activity->category->name ?? 'Tanpa Kategori' }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($activity->start_at ?? $activity->activity_date)->format('d M Y') }}</p>
            <p><strong>Status:</strong> <span style="text-transform: capitalize;">{{ $activity->status }}</span></p>

            <!-- Tombol Edit & Delete -->
            <a href="{{ route('activities.edit', $activity) }}">Edit</a> |
            <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="color: red; border: none; background: none; cursor: pointer; text-decoration: underline;">Hapus</button>
            </form>
        </article>
    @empty
        <p>Belum ada kegiatan.</p>
    @endforelse

    <!-- Link Pagination -->
    <div style="margin-top: 20px;">
        {{ $activities->links() }}
    </div>

@endsection