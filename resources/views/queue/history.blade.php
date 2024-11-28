@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Riwayat Antrian</h2>

        @if($queues->isEmpty())
            <p>Belum ada antrian yang dipanggil atau selesai.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Antrian</th>
                        <th>Loket</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($queues as $queue)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $queue->code }}</td>
                            <td>{{ $queue->loket }}</td>
                            <td>{{ ucfirst($queue->status) }}</td>
                            <td>{{ \Carbon\Carbon::parse($queue->updated_at)->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
