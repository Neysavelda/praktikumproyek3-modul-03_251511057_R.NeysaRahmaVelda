<div style="margin-bottom: 1rem;">
    <label for="title">Judul Kegiatan:</label><br>
    <input type="text" name="title" id="title" value="{{ old('title', $activity->title ?? '') }}" style="width: 100%; padding: 8px;">
    @error('title')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<div style="margin-bottom: 1rem;">
    <label for="description">Deskripsi:</label><br>
    <textarea name="description" id="description" rows="3" style="width: 100%; padding: 8px;">{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<div style="margin-bottom: 1rem;">
    <label for="activity_date">Tanggal Kegiatan:</label><br>
    <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date', isset($activity->activity_date) ? \Carbon\Carbon::parse($activity->activity_date)->format('Y-m-d') : '') }}" style="width: 100%; padding: 8px;">
    @error('activity_date')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<div style="margin-bottom: 1rem;">
    <label for="category">Kategori:</label><br>
    <input type="text" name="category" id="category" value="{{ old('category', $activity->category ?? '') }}" style="width: 100%; padding: 8px;">
    @error('category')
        <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

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

<button type="submit" style="padding: 8px 16px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">Simpan</button>
<a href="{{ route('activities.index') }}" style="margin-left: 10px;">Batal</a>
