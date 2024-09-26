<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pilih Loket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Pilih Loket</h1>
    <div class="row">
        @foreach($lokets as $loket)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('images/' . $loket['image']) }}" class="card-img-top" alt="{{ $loket['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $loket['name'] }}</h5>
                        <form action="{{ route('queue.ambilAntrian', ['loket' => $loket['code']]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Ambil Antrian</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
