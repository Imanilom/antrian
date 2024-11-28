@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>Daftar Poli</h3>
        <a href="{{ route('polis.create') }}" class="btn btn-primary mb-3">Tambah Poli</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kode</th>
                    <th>Petugas</th>
                    <th>Status</th>
                    <th>Batas Antrian</th>
                    <th>Jam Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($polis as $poli)
                    <tr>
                        <td>{{ $poli->name }}</td>
                        <td>{{ $poli->code }}</td>
                        <td>{{ $poli->officer }}</td>
                        <td>{{ $poli->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>{{ $poli->queue_limit ?? 'Tidak terbatas' }}</td>
                        <td>
                            {{ $poli->start_time ? date('H:i', strtotime($poli->start_time)) : '-' }} 
                            - 
                            {{ $poli->end_time ? date('H:i', strtotime($poli->end_time)) : '-' }}
                        </td>
                        <td>
                            <a href="{{ route('polis.edit', $poli) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('polis.destroy', $poli) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            <a href="{{ route('queue.dashboardLoket', $poli->code) }}" class="btn btn-info btn-sm">Dashboard</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>
@endsection
