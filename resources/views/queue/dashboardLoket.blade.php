<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Loket {{ $loket }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .current-number {
            font-size: 4rem;
            font-weight: bold;
        }
        .status-called {
            color: green;
        }
        .status-waiting {
            color: orange;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Dashboard Loket {{ $loket }}</h1>

    <!-- Current Queue -->
    @if($queue['current'])
        <div class="alert alert-info">
            <p>Antrian Saat Ini:</p>
            <p class="current-number">{{ $queue['current']['code'] }}</p>
            <p>Status: <span class="status-called">{{ $queue['current']['status'] }}</span></p>

            <form action="{{ route('queue.doneQueue', ['loket' => $loket, 'number' => $queue['current']['number']]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Selesai</button>
            </form>
        </div>
    @else
        <div class="alert alert-secondary">Belum ada antrian yang dipanggil.</div>
    @endif

    <!-- Waiting Queues -->
    <h2>Antrian Menunggu</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Kode Antrian</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($queue['waiting'] as $q)
                <tr>
                    <td>{{ $q['code'] }}</td>
                    <td>{{ $q['time'] }}</td>
                    <td><span class="status-waiting">{{ $q['status'] }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Call Next Queue -->
    <form action="{{ route('queue.callQueue', ['loket' => $loket]) }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-primary">Panggil Antrian Berikutnya</button>
    </form>
</div>

<!-- Audio Playback -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const audioSources = {!! json_encode(session('audioFiles', [])) !!};
    let audioIndex = 0;

    function playAudio() {
        if (audioIndex < audioSources.length) {
            const audioElement = new Audio(audioSources[audioIndex]);
            audioElement.play();
            audioElement.addEventListener("ended", function () {
                audioIndex++;
                playAudio();
            });
        }
    }

    if (audioSources.length > 0) {
        playAudio();
    }
});

</script>
</body>
</html>
