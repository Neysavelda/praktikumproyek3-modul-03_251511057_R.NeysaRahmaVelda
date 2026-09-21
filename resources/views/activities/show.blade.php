   @extends('layouts.app')

   @section('content')
       <a href="{{ route('activities.index') }}">Kembali ke daftar</a>
       <h1>{{ $activity->title }}</h1>
       <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
       <p>Kategori: {{ $activity->category }}</p>
       <p>Status: {{ $activity->status }}</p>
       <p>{{ $activity->description }}</p>
   @endsection