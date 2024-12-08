@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>Tambah Poli</h3>
        <form action="{{ route('polis.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Poli</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="code">Kode Poli</label>
                <select id="alphabet" name="alphabet" class="form-select" required>
                    <!-- Opsi huruf A-Z tanpa opsi kosong -->
                </select>
                <input type="hidden" name="code" id="code">
            </div>

            <div class="form-group">
                <label for="officer">Petugas</label>
                <input type="text" name="officer" id="officer" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="queue_limit">Batas Antrian (Opsional)</label>
                <input type="number" name="queue_limit" id="queue_limit" class="form-control">
            </div>

            <div class="form-group">
                <label for="start_time">Jam Buka</label>
                <input type="time" name="start_time" id="start_time" class="form-control">
            </div>

            <div class="form-group">
                <label for="end_time">Jam Tutup</label>
                <input type="time" name="end_time" id="end_time" class="form-control">
            </div>

            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                    {{ old('is_active', $poli->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>

    <script>
        // Membuat array huruf A sampai Z
        const letters = Array.from(Array(26), (e, i) => String.fromCharCode(i + 65));

        // Menggunakan forEach untuk menambahkan huruf ke dalam elemen select
        letters.forEach(letter => {
            const option = document.createElement('option');
            option.value = letter;
            option.textContent = letter;
            document.getElementById('alphabet').appendChild(option);
        });

        // Mengatur event listener untuk dropdown
        document.getElementById('alphabet').addEventListener('change', function() {
            const selectedLetter = this.value;
            document.getElementById('code').value = selectedLetter; // Simpan huruf yang dipilih ke input tersembunyi
        });

        // Fungsi untuk memeriksa huruf yang sudah ada
        function checkExistingCodes(existingCodes) {
            const select = document.getElementById('alphabet');
            for (let i = 0; i < select.options.length; i++) {
                const optionValue = select.options[i].value;
                if (existingCodes.includes(optionValue)) {
                    select.options[i].disabled = true; // Nonaktifkan opsi yang sudah ada
                }
            }
        }

        // Ambil daftar kode yang sudah ada, misalnya dari server
        const existingCodes = @json($existingCodes ?? []); // Pastikan $existingCodes didefinisikan di controller
        checkExistingCodes(existingCodes);
    </script>
@endsection