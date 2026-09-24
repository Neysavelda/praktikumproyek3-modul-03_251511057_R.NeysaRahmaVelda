@extends('layouts.app')

@section('content')
    <h2>Edit Kegiatan</h2>

    <form action="{{ route('activities.update', $activity->id) }}" method="POST">
        @method('PUT')
        @include('activities._form')
    </form>
@endsection
