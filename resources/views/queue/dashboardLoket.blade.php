<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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

    @if($queue['current'])
        <div class="alert alert-info">
            <p>Antrian Saat Ini:</p>
            <p class="current-number">{{ $queue['current']['code'] }}</p>
            <p>Status: <span class="status-called">{{ $queue['current']['status'] }}</span></p>

            <audio id="audio" autoplay>
                <source src="{{ asset('audio/' . strtolower($queue['current']['code']) . '.mp3') }}" type="audio/mpeg">
            </audio>

            <form action="{{ route('queue.doneQueue', ['loket' => $loket, 'number' => $queue['current']['number']]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Selesai</button>
            </form>
        </div>
    @else
        <div class="alert alert-secondary">Belum ada antrian yang dipanggil.</div>
    @endif

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

    <form action="{{ route('queue.callQueue', ['loket' => $loket]) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Panggil Antrian Berikutnya</button>
        
    </form>
    <audio id="audio" autoplay>
        @if(session('audioFiles'))
            @foreach(session('audioFiles') as $audio)
                <source src="{{ $audio }}" type="audio/wav">
            @endforeach
        @endif
    </audio>

</div>
</body>
<script>
    const audioSources = {!! json_encode(session('audioFiles', [])) !!};
    let audioIndex = 0;

    function playAudio() {
        if (audioIndex < audioSources.length) {
            let audioElement = new Audio(audioSources[audioIndex]);
            audioElement.play();
            audioElement.onended = function() {
                audioIndex++;
                playAudio();
            };
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        if (audioSources.length > 0) {
            playAudio();
        }
    });
</script>

</html>
