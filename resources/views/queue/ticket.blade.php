@extends('layouts.app')

@section('content')
    <div class="container mt-5 text-center">
        <h3>Nomor Antrian Anda</h3>
        <div class="alert alert-success">
            <h1>{{ $code }}</h1>
        </div>
        <a href="{{ route('queue.selectLoket') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
