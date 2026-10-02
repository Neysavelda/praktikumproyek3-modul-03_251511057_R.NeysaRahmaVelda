@extends('layouts.app')

@section('content')
    <a href="{{ route('activities.index') }}">Kembali ke daftar</a>
    
    <h1>{{ $activity->title }}</h1>

    {{-- Alert Error jika transisi status gagal / data tidak lengkap --}}
    @if ($errors->any())
        <div style="background-color: #ffebee; color: red; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Alert Sukses jika transisi berhasil --}}
    @if(session('success'))
        <div style="background-color: #e8f5e9; color: green; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <p>Tanggal: {{ \Carbon\Carbon::parse($activity->activity_date)->format('d M Y') }}</p>    <p>Kategori: {{ $activity->category->name ?? $activity->category }}</p>
    <p>Status: <strong>{{ ucfirst($activity->status) }}</strong></p>
    <p>{{ $activity->description }}</p>

    <div style="margin-top: 15px;">
        <!-- Tombol Publish (Khusus Draft) -->
        @if($activity->status === 'draft')
            <form action="{{ route('activities.publish', $activity) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" style="background: blue; color: white; padding: 6px 12px; border: none; cursor: pointer; border-radius: 4px;">Publish</button>
            </form>
        @endif

        <!-- Tombol Complete (Khusus Published) -->
        @if($activity->status === 'published')
            <form action="{{ route('activities.complete', $activity) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" style="background: green; color: white; padding: 6px 12px; border: none; cursor: pointer; border-radius: 4px;">Complete</button>
            </form>
        @endif
    </div>
@endsection