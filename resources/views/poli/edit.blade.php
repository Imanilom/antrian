@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>Edit Poli</h3>
        <form action="{{ route('polis.update', $poli) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama Poli</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $poli->name }}" required>
            </div>
            <div class="form-group">
                <label for="code">Kode Poli</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ $poli->code }}" required>
            </div>
            <div class="form-group">
                <label for="officer">Petugas</label>
                <input type="text" name="officer" id="officer" class="form-control" value="{{ $poli->officer }}" required>
            </div>
            <div class="form-group">
                <label for="queue_limit">Batas Antrian (Opsional)</label>
                <input type="number" name="queue_limit" id="queue_limit" class="form-control" value="{{ $poli->queue_limit }}">
            </div>
            <div class="form-group">
                <label for="start_time">Jam Buka</label>
                <input type="time" name="start_time" id="start_time" class="form-control" value="{{ $poli->start_time }}">
            </div>
            <div class="form-group">
                <label for="end_time">Jam Tutup</label>
                <input type="time" name="end_time" id="end_time" class="form-control" value="{{ $poli->end_time }}">
            </div>
            
            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ $poli->is_active ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Aktif</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
@endsection
