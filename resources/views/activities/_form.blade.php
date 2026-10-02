<!-- Kategori -->
<div style="margin-bottom: 1rem;">
    <label for="category_id">Kategori Kegiatan:</label><br>
    <select name="category_id" id="category_id" style="width: 100%; padding: 8px;" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $activity->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<!-- Kode Kegiatan -->
<div style="margin-bottom: 1rem;">
    <label for="code">Kode Kegiatan (Unik):</label><br>
    <input type="text" name="code" id="code" value="{{ old('code', $activity->code ?? '') }}" style="width: 100%; padding: 8px;" placeholder="Contoh: ACT-001">
    @error('code')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<!-- Judul -->
<div style="margin-bottom: 1rem;">
    <label for="title">Judul Kegiatan:</label><br>
    <input type="text" name="title" id="title" value="{{ old('title', $activity->title ?? '') }}" style="width: 100%; padding: 8px;">
    @error('title')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<!-- Deskripsi -->
<div style="margin-bottom: 1rem;">
    <label for="description">Deskripsi:</label><br>
    <textarea name="description" id="description" rows="3" style="width: 100%; padding: 8px;">{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<!-- Lokasi -->
<div style="margin-bottom: 1rem;">
    <label for="location">Lokasi:</label><br>
    <input type="text" name="location" id="location" value="{{ old('location', $activity->location ?? '') }}" style="width: 100%; padding: 8px;">
    @error('location')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<!-- Tanggal Mulai -->
<div style="margin-bottom: 1rem;">
    <label for="start_at">Tanggal Mulai:</label><br>
    <input type="datetime-local" name="start_at" id="start_at" 
        value="{{ old('start_at', isset($activity->start_at) ? \Carbon\Carbon::parse($activity->start_at)->format('Y-m-d\TH:i') : '') }}" 
        style="width: 100%; padding: 8px;">
    @error('start_at')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<!-- Tanggal Selesai -->
<div style="margin-bottom: 1rem;">
    <label for="end_at">Tanggal Selesai:</label><br>
    <input type="datetime-local" name="end_at" id="end_at" 
        value="{{ old('end_at', isset($activity->end_at) ? \Carbon\Carbon::parse($activity->end_at)->format('Y-m-d\TH:i') : '') }}" 
        style="width: 100%; padding: 8px;">
    @error('end_at')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<!-- Kapasitas -->
<div style="margin-bottom: 1rem;">
    <label for="capacity">Kapasitas Peserta (Maks 500):</label><br>
    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $activity->capacity ?? '') }}" style="width: 100%; padding: 8px;">
    @error('capacity')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<!-- Status -->
<div style="margin-bottom: 1rem;">
    <label for="status">Status:</label><br>
    <select name="status" id="status" style="width: 100%; padding: 8px;">
        <option value="Planned" {{ old('status', $activity->status ?? '') == 'Planned' ? 'selected' : '' }}>Planned</option>
        <option value="Ongoing" {{ old('status', $activity->status ?? '') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
        <option value="Done" {{ old('status', $activity->status ?? '') == 'Done' ? 'selected' : '' }}>Done</option>
    </select>
    @error('status')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label for="poster" class="form-label">Poster Kegiatan (Opsional, Max 2MB)</label>
    <input type="file" name="poster" id="poster" class="form-control @error('poster') is-invalid @enderror" accept="image/*">
    @error('poster')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if(isset($activity) && $activity->poster_path)
    <div class="mb-3">
        <p class="text-muted mb-1">Poster saat ini:</p>
        <img src="{{ asset('storage/' . $activity->poster_path) }}" alt="Poster" class="img-thumbnail" style="max-height: 150px;">
    </div>
@endif

<button type="submit" style="padding: 8px 16px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">Simpan</button>
<a href="{{ route('activities.index') }}" style="margin-left: 10px;">Batal</a>