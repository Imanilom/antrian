@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>Tambah Poli</h3>
        <form action="{{ route('polis.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Poli</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="code">Kode Poli</label>
                <input type="text" name="code" id="code" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="officer">Petugas</label>
                <input type="text" name="officer" id="officer" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="queue_limit">Batas Antrian (Opsional)</label>
                <input type="number" name="queue_limit" id="queue_limit" class="form-control">
            </div>
            <div class="form-group">
                <label for="start_time">Jam Buka</label>
                <input type="time" name="start_time" id="start_time" class="form-control">
            </div>
            <div class="form-group">
                <label for="end_time">Jam Tutup</label>
                <input type="time" name="end_time" id="end_time" class="form-control">
            </div>
            
            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                <label for="is_active" class="form-check-label">Aktif</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
@endsection
