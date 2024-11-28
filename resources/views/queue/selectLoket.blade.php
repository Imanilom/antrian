@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>Pilih Loket</h3>
        <div class="row">
            @foreach ($lokets as $loket)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="{{ asset('images/' . $loket['image']) }}" class="card-img-top" alt="{{ $loket['name'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $loket['name'] }}</h5>
                            <a href="{{ route('queue.ambilAntrian', $loket['code']) }}" class="btn btn-primary">Ambil Antrian</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
