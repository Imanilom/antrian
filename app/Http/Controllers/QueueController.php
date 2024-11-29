<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Queue;
use App\Models\Poli;
use Barryvdh\DomPDF\Facade\Pdf;

class QueueController extends Controller
{


    public function printTicket($loket)
    {
        // Ambil data antrian yang baru saja dibuat
        $lastQueue = Queue::where('loket', $loket)->orderBy('id', 'desc')->first();

        // Pastikan antrian ditemukan
        if ($lastQueue) {
            // Muat view untuk tiket dan kirim data antrian
            $pdf = PDF::loadView('queue.ticket', compact('lastQueue'));

            // Simpan PDF atau langsung unduh
            return $pdf->download('ticket-' . $lastQueue->code . '.pdf');
        }

        // Jika antrian tidak ditemukan
        return redirect()->back()->with('error', 'Antrian tidak ditemukan.');
    }

    public function history()
    {
        // Ambil semua antrian yang sudah dipanggil atau selesai
        $queues = Queue::whereIn('status', ['called', 'done'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('queue.history', compact('queues'));
    }
    
    // Menampilkan halaman pemilihan loket
    public function selectLoket()
    {
        $lokets = Poli::where('is_active', true)->get();
        return view('queue.selectLoket', compact('lokets'));
    }

    // Ambil nomor antrian baru
    public function ambilAntrian($loket)
    {
        $lastQueue = Queue::where('loket', $loket)->orderBy('id', 'desc')->first();
        $nextNumber = $lastQueue ? intval($lastQueue->number) + 1 : 1;
        $nextCode = $loket . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $queue = Queue::create([
            'loket' => $loket,
            'number' => $nextNumber,
            'code' => $nextCode,
            'status' => 'waiting',
        ]);

        return view('queue.ticket', compact('queue'));
    }

    // Menampilkan dashboard loket
    public function dashboardLoket($loket)
    {
        $currentQueue = Queue::where('loket', $loket)->where('status', 'called')->orderBy('updated_at', 'desc')->first();
        $waitingQueues = Queue::where('loket', $loket)->where('status', 'waiting')->orderBy('created_at')->get();

        $queue = [
            'current' => $currentQueue,
            'waiting' => $waitingQueues->map(function ($queue) {
                return [
                    'code' => $queue->code,
                    'time' => $queue->created_at->format('H:i'),
                    'status' => $queue->status,
                ];
            }),
        ];

        return view('queue.dashboardLoket', compact('loket', 'queue'));
    }

    // Panggil antrian berikutnya
    public function callQueue(Request $request, $loket)
{
    // Ambil antrian pertama dengan status "waiting"
    $queue = Queue::where('loket', $loket)
        ->where('status', 'waiting')
        ->orderBy('created_at')
        ->first();

    if ($queue) {
        // Perbarui status antrian menjadi "called"
        $queue->update(['status' => 'called']);

        // Hasilkan daftar file audio berdasarkan kode antrian
        $audioFiles = $this->generateAudioFiles($queue->code);

        // Redirect ke dashboard dengan audio untuk diputar
        return redirect()->route('queue.dashboardLoket', ['loket' => $loket])
            ->with('audioFiles', $audioFiles);
    }

    return redirect()->route('queue.dashboardLoket', ['loket' => $loket])
        ->with('error', 'Tidak ada antrian menunggu.');
}


    private function generateAudioFiles($queueCode)
    {
        $audioFiles = [];

        // Bagian 1: Pecah kode menjadi bagian huruf dan angka
        $parts = explode('-', $queueCode);
        if (count($parts) == 2) {
            $loket = strtoupper($parts[0]); // Ambil huruf loket
            $number = intval($parts[1]);   // Ambil angka sebagai integer

            $audioFiles[] = asset("audio/simple_notification.wav");
            // Bagian 2: Tambahkan file audio untuk "Nomor Antrian"
            $audioFiles[] = asset("audio/antrian.wav");

            // Tambahkan file audio untuk huruf loket (contoh: "O")
            $audioFiles[] = asset("audio/{$loket}.wav");

            // Parse angka menjadi file audio (contoh: "002" → "dua")
            $audioFiles = array_merge($audioFiles, $this->parseNumberToAudio($number));

            // Tambahkan audio untuk "di konter"
            $audioFiles[] = asset("audio/counter.wav");

            // Tambahkan audio untuk huruf loket (contoh: "O")
            $audioFiles[] = asset("audio/{$loket}.wav");
            $audioFiles[] = asset("audio/simple_notification.wav");
        }

        return $audioFiles;
    }


    // Konversi angka ke file audio
    private function parseNumberToAudio($number)
{
    $audioFiles = [];

    if ($number >= 100) {
        $hundreds = intval($number / 100) * 100; // Ratusan (contoh: 100, 200)
        $audioFiles[] = asset("audio/{$hundreds}.wav");
        $number %= 100;
    }

    if ($number >= 10) {
        if ($number <= 20) { // Belasan atau angka spesial (contoh: 11, 12)
            $audioFiles[] = asset("audio/{$number}.wav");
        } else {
            $tens = intval($number / 10) * 10; // Puluhan (contoh: 30, 40)
            $audioFiles[] = asset("audio/{$tens}.wav");
            $number %= 10;
        }
    }

    if ($number > 0) {
        $audioFiles[] = asset("audio/{$number}.wav"); // Satuan (contoh: 1, 2)
    }

    return $audioFiles;
}


    // Tandai antrian selesai
    public function doneQueue(Request $request, $loket, $number)
    {
        $queue = Queue::where('loket', $loket)->where('number', $number)->where('status', 'called')->first();

        if ($queue) {
            $queue->update(['status' => 'done']);
        }

        return redirect()->route('queue.dashboardLoket', ['loket' => $loket]);
    }

    // Mendapatkan daftar file audio yang tersedia
    public function getAudioList()
    {
        $directory = public_path('audio');
        $files = array_diff(scandir($directory), ['..', '.']);
        $audioList = array_map(function ($file) {
            return [
                'path' => asset('audio/' . $file),
                'file' => $file,
                'ID' => pathinfo($file, PATHINFO_FILENAME),
            ];
        }, $files);

        return response()->json($audioList);
    }
}
