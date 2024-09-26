<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tiket Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .ticket {
            margin-top: 100px;
            text-align: center;
        }
        .ticket h1 {
            font-size: 5rem;
        }
    </style>
</head>
<body>
<div class="container ticket">
    <h1>{{ $code }}</h1>
    <p>Silakan menunggu panggilan.</p>
    <button onclick="window.print()" class="btn btn-secondary">Cetak Tiket</button>
</div>
</body>
</html>
