@extends('layouts.app')

@section('content')
<section id="queue-ticket" class="section">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm print-area" id="ticket">
                    <div class="card-header text-center">
                        <img src="{{ asset('assets/img/logo ITB.png') }}" alt="Logo ITB" class="logo-print mb-2" style="width: 100px; height: auto;">
                        <h3 class="mb-0" style="font-weight: bold;"><strong>UPT Klinik Bumi Medika ITB</strong></h3>
                        <h4 class="mb-0" style="font-size: 12px;">Jl. Gelap Nyawang No.2, Lb. Siliwangi</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 1.5rem;">Poli: <span class="font-weight-vold">{{ $loketName }}</span></h5>
                        <p class="card-text" style="font-size: 1.5rem;">Nomor Antrian: <span class="font-weight-bold">{{ $queue->number }}</span></p>
                        <p class="card-text" style="font-size: 1.5rem;">Kode: <span class="font-weight-bold">{{ $queue->code }}</span></p>
                        <p class="card-text" style="font-size: 1.5rem;">Status: <span class="{{ $queue->status == 'waiting' ? 'text-warning' : 'text-success' }}">
                            {{ ucfirst($queue->status) }}</span></p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('home') }}" class="btn btn-secondary" id="back-button">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 0;
        padding: 0;
    }

    /* Style untuk cetakan */
    @media print {
        body {
            margin: 0; /* Menghilangkan margin body saat cetak */
            padding: 0; /* Menghilangkan padding body saat cetak */
        }

        body * {
            visibility: hidden; /* Sembunyikan semua elemen */
        }

        #ticket, #ticket * {
            visibility: visible; /* Tampilkan hanya elemen tiket */
        }

        #ticket {
            position: absolute; /* Mengatur posisi tiket untuk cetak */
            left: 0;
            top: 0;
            width: 7cm; /* Pastikan lebar tiket sesuai ukuran kertas */
            height: 16cm; /* Pastikan tinggi tiket sesuai ukuran kertas */
            margin: 0; /* Tanpa margin */
        }

        #back-button {
            display: none; /* Sembunyikan tombol "Kembali" saat mencetak */
        }

        @page {
            size: 7cm 16cm; /* Ukuran kertas: 7 cm lebar, 16 cm tinggi */
            margin: 0; /* Tanpa margin */
        }
    }
</style>

<script>
    // Fungsi untuk mencetak tiket secara otomatis
    function autoPrint() {
        window.print(); // Panggil fungsi print
        setTimeout(() => {
            window.close(); // Tutup jendela setelah 1 detik
        }, 1000);
    }

    // Panggil fungsi autoPrint saat halaman dimuat
    window.onload = autoPrint;
</script>

@endsection