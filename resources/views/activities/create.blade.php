<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kegiatan Baru</title>
</head>
<body>
    <h1>Tambah Kegiatan Baru</h1>

    <form action="{{ route('activities.store') }}" method="POST">
        @csrf
        @include('activities._form')
    </form>
</body>
</html>