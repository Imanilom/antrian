@extends('layouts.app')

@section('content')
<section id="queue-ticket" class="section">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h3 class="mb-0">Queue Ticket</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Loket: <span class="text-primary">{{ $queue->loket }}</span></h5>
                        <p class="card-text">Number: <span class="font-weight-bold">{{ $queue->number }}</span></p>
                        <p class="card-text">Code: <span class="font-weight-bold">{{ $queue->code }}</span></p>
                        <p class="card-text">Status: <span class="text-success">{{ $queue->status }}</span></p>
                    </div>
                    <!-- Tombol kembali disembunyikan saat mencetak -->
                    <div class="card-footer text-center print-hidden">
                        <a href="{{ route('home') }}" class="btn btn-primary">Back to Loket Selection</a>
                        <a href="{{ route('queue.printTiket', ['queueId' => $queue->id]) }}" class="btn btn-primary">Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('css')
<style>
    /* Menyembunyikan tombol kembali saat mencetak */
    @media print {
        .print-hidden {
            display: none;
        }
    }
</style>
@endsection
