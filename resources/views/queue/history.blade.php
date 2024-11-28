@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>Riwayat Panggilan Antrian</h3>
        
        @if ($queues->isEmpty())
            <div class="alert alert-info" role="alert">
                Tidak ada riwayat panggilan antrian.
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Loket</th>
                        <th>Nomor Antrian</th>
                        <th>Kode Antrian</th>
                        <th>Status</th>
                        <th>Waktu Panggilan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($queues as $queue)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $queue->loket }}</td>
                            <td>{{ $queue->number }}</td>
                            <td>{{ $queue->code }}</td>
                            <td>{{ ucfirst($queue->status) }}</td>
                            <td>{{ $queue->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
