@extends('layouts.app')

@section('content')
    <h1>Tambah Kegiatan Baru</h1>

    <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('activities._form')
    </form>
@endsection