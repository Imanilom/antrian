@extends('layouts.app')

@section('content')
<section id="queue-ticket" class="section">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <!-- Tambahkan logo klinik -->
                        <img src="{{ asset('assets/img/logo ITB.png') }}" alt="Logo ITB" class="logo-print mb-2" style="width: 100px; height: auto;">
                        <h3 class="mb-0" style="font-weight: bold;"><strong>UPT Klinik Bumi Medika ITB</strong></h3>
                        <h4 class="mb-0" style="font-size: 12px;">Jl. Gelap Nyawang No.2, Lb. Siliwangi</h4>

                        
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1.5rem;">Loket: <span class="text-primary">{{ $queue->loket }}</span></h5>
                        <p class="card-text" style="font-size: 1.5rem;">Nomor Antrian: <span class="font-weight-bold">{{ $queue->number }}</span></p>
                        <p class="card-text" style="font-size: 3.0rem;">Kode: <span class="font-weight-bold">{{ $queue->code }}</span></p>
                        <p class="card-text" style="font-size: 1.5rem;">Status: <span class="{{ $queue->status == 'waiting' ? 'text-warning' : 'text-success' }}">
                            {{ ucfirst($queue->status) }}</span></p>
                    </div>
                    
                    <!-- Tombol kembali disembunyikan saat mencetak -->
                    <div class="card-footer text-center print-hidden">
                        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
                        <button onclick="window.print()" class="btn btn-primary">Cetak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 0;
        padding: 0;
    }
    .ticket-container {
        border: 2px dashed #000;
        padding: 20px;
        width: 300px;
        margin: 50px auto;
    }
    .queue-number {
        font-size: 50px;
        font-weight: bold;
        margin: 10px 0;
    }
    .loket {
        font-size: 20px;
        margin-top: 10px;
    }
</style>

@section('css')
<style>
    /* Menyesuaikan ukuran untuk cetakan termal */
    @media print {
        .print-area {
            width: 7cm;
            height: 16cm;
            font-size: 12px; /* Sesuaikan ukuran font jika diperlukan */
        }
        body {
            margin: 0;
            font-size: 12px;
        }
        .card {
            width: 80mm; /* Ukuran standar thermal printer */
            border: none;
            margin: 0 auto;
        }
        .card-header {
            font-size: 16px;
            font-weight: bold;
            padding: 5px;
            text-align: center;
        }
        .card-body {
            text-align: center;
            padding: 5px;
        }
        .card-title {
            font-size: 14px;
        }
        .card-text {
            margin: 3px 0;
            font-size: 12px;
        }
        .logo-print {
            display: block;
            margin: 0 auto;
            width: 5cm; /* Atur lebar logo */
            height: auto; /* Otomatis menjaga proporsi */
        }
        .print-hidden {
            display: none;
        }
    }

</style>

@endsection
