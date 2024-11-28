@extends('layouts.app')

@section('content')
<section id="loket-selection" class="section">
    <div class="container mt-5">
        <h3 class="text-center mb-4">Pilih Loket</h3>
        <div class="row">
            @foreach ($lokets as $loket)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="https://online.hbs.edu/Style%20Library/api/resize.aspx?imgpath=/online/PublishingImages/blog/health-care-economics.jpg&w=1200&h=630" class="card-img-top" alt="{{ $loket['name'] }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $loket['name'] }}</h5>
                            <p class="card-text">Deskripsi singkat tentang loket ini.</p>
                            <a href="#" onclick="ambilAntrian('{{ $loket['code'] }}')" class="btn btn-primary">Ambil Antrian</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    function ambilAntrian(loketCode) {
        // Mengarahkan ke rute ambil antrian
        window.location.href = "/ambil-antrian/" + loketCode;
    }
</script>
@endsection
