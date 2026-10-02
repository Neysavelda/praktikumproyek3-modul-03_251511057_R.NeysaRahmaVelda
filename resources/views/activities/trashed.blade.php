<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sampah Kegiatan (Trash)</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">

    <h2>Daftar Kegiatan Terhapus (Trash)</h2>

    <a href="{{ route('activities.index') }}" style="margin-bottom: 15px; display: inline-block;">&laquo; Kembali ke Daftar Utama</a>

    @if(session('success'))
        <div style="background-color: #e8f5e9; color: green; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tanggal Dihapus</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $activity)
                <tr>
                    <td>{{ $activity->title }}</td>
                    <td>{{ $activity->category->name ?? '-' }}</td>
                    <td>{{ $activity->deleted_at->format('d M Y H:i') }}</td>
                    <td>
                        <!-- Tombol Restore -->
                        <form action="{{ route('activities.restore', $activity->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background: green; color: white; border: none; padding: 5px 10px; cursor: pointer;">Restore</button>
                        </form>

                        <!-- Tombol Delete Permanen -->
                        <form action="{{ route('activities.force-delete', $activity->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus permanen kegiatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: red; color: white; border: none; padding: 5px 10px; cursor: pointer;">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada kegiatan di dalam sampah.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 15px;">
        {{ $activities->links() }}
    </div>

</body>
</html>