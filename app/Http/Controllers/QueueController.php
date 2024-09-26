<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class QueueController extends Controller
{
    // Tampilan 1 - Pilihan Loket
    public function selectLoket()
    {
        // Daftar loket, misal V, X, dan Y
        $lokets = [
            ['code' => 'V', 'name' => 'Loket V', 'image' => 'loket_v.jpg'],
            ['code' => 'X', 'name' => 'Loket X', 'image' => 'loket_x.jpg'],
            ['code' => 'Y', 'name' => 'Loket Y', 'image' => 'loket_y.jpg'],
        ];

        return view('queue.selectLoket', compact('lokets'));
    }

    // Ambil Antrian
    public function ambilAntrian($loket)
    {
        // Ambil antrian dari session
        $queues = session('queues', []);

        // Jika belum ada antrian untuk loket ini, inisialisasi
        if (!isset($queues[$loket])) {
            $queues[$loket] = [
                'waiting' => [],
                'current' => null,
            ];
        }

        // Tambah nomor antrian
        $number = count($queues[$loket]['waiting']) + 1;
        $code = $loket . '-' . $number;

        $queues[$loket]['waiting'][] = [
            'number' => $number,
            'code' => $code,
            'status' => 'waiting',
            'time' => Carbon::now()->format('H:i:s'),
        ];

        // Simpan kembali ke session
        session(['queues' => $queues]);

        // Tampilkan tiket antrian
        return view('queue.ticket', ['code' => $code]);
    }

    // Tampilan 2 - Dashboard Loket
    public function dashboardLoket($loket)
    {
        $queues = session('queues', []);
        $loketQueue = $queues[$loket] ?? ['waiting' => [], 'current' => null];

        return view('queue.dashboardLoket', [
            'loket' => $loket,
            'queue' => $loketQueue,
        ]);
    }

    // Panggil Antrian
    public function callQueue(Request $request, $loket)
    {
        $queues = session('queues', []);
        $loketQueue = $queues[$loket] ?? ['waiting' => [], 'current' => null];

        if (count($loketQueue['waiting']) > 0) {
            // Ambil antrian pertama
            $current = array_shift($loketQueue['waiting']);
            $current['status'] = 'called';

            // Set antrian saat ini
            $loketQueue['current'] = $current;

            // Simpan kembali ke queues
            $queues[$loket] = $loketQueue;
            session(['queues' => $queues]);
        }

        // Redirect ke dashboard dengan audio yang akan diputar
        return redirect()->route('queue.dashboardLoket', ['loket' => $loket])
            ->with('audioFiles', $this->generateAudioFiles($current['code']));
    }

    // Fungsi untuk mengurai kode antrian menjadi file audio
    private function generateAudioFiles($queueCode)
    {
        $audioFiles = [];

        // Misal kode antrian adalah "V-15", maka akan diurai jadi "V.wav", "antrian.wav", "15.wav"
        $parts = explode('-', $queueCode);
        if (count($parts) == 2) {
            $loket = strtolower($parts[0]); // Misalnya 'V' jadi 'v.wav'
            $number = intval($parts[1]); // Nomor antrian, misalnya '15'
            
            $audioFiles[] = asset("audio/simple_notification.wav");
            $audioFiles[] = asset("audio/antrian.wav"); // audio untuk kata "Antrian"
            $audioFiles[] = asset("audio/{$loket}.wav");

            // Mengurai angka menjadi file audio
            $audioFiles = array_merge($audioFiles, $this->parseNumberToAudio($number));
            $audioFiles[] = asset("audio/counter.wav");
            $audioFiles[] = asset("audio/{$loket}.wav");
            $audioFiles[] = asset("audio/simple_notification.wav");
        }

        return $audioFiles;
    }

    // Fungsi untuk mengurai angka menjadi file audio
    private function parseNumberToAudio($number)
    {
        $audioFiles = [];

        if ($number >= 100) {
            $hundreds = intval($number / 100) * 100;
            $audioFiles[] = asset("audio/{$hundreds}.wav");
            $number %= 100;
        }

        if ($number >= 10) {
            if ($number <= 20) {
                // Untuk angka antara 10-20
                $audioFiles[] = asset("audio/{$number}.wav");
            } else {
                $tens = intval($number / 10) * 10;
                $audioFiles[] = asset("audio/{$tens}.wav");
                $number %= 10;
            }
        }

        if ($number > 0) {
            $audioFiles[] = asset("audio/{$number}.wav");
        }

        return $audioFiles;
    }


    // Selesaikan Antrian
    public function doneQueue(Request $request, $loket, $number)
    {
        $queues = session('queues', []);
        $loketQueue = $queues[$loket] ?? ['waiting' => [], 'current' => null];

        // Hapus antrian current jika nomornya sesuai
        if ($loketQueue['current'] && $loketQueue['current']['number'] == $number) {
            $loketQueue['current'] = null;

            // Simpan kembali ke queues
            $queues[$loket] = $loketQueue;
            session(['queues' => $queues]);
        }

        return redirect()->route('queue.dashboardLoket', ['loket' => $loket]);
    }

    public function getAudioList()
    {
        $directory = public_path('audio');
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        $audioList = [];

        foreach ($scanned_directory as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($ext, ['mp3', 'wav'])) {
                $ID = pathinfo($file, PATHINFO_FILENAME);
                $audioList[] = [
                    'path' => asset('audio/' . $file),
                    'file' => $file,
                    'ID' => $ID,
                ];
            }
        }

        return response()->json($audioList);
    }
}
