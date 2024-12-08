<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poli;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::all();
        return view('poli.index', compact('polis'));
    }

    public function create()
    {
        // Ambil semua kode poli yang sudah ada
        $existingCodes = Poli::pluck('code')->map(function($code) {
            return $code[0]; // Ambil huruf pertama dari setiap kode
        })->toArray();

        return view('poli.create', compact('existingCodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'officer' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:polis,code',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);
    
        Poli::create([
            'name' => $request->name,
            'code' => $request->code,
            'officer' => $request->officer,
            'queue_limit' => $request->queue_limit,
            'is_active' => $request->has('is_active'),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
    
        return redirect()->route('polis.index')->with('success', 'Poli berhasil ditambahkan.');
    }

    
    public function edit(Poli $poli)
{
    $existingCodes = Poli::pluck('code')->toArray(); // Ambil semua kode poli yang sudah ada

    return view('poli.edit', [
        'poli' => $poli,
        'existingCodes' => $existingCodes,
    ]);
}

public function update(Request $request, Poli $poli)
{

    // Validasi data dari form
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:10|unique:polis,code,' . $poli->id,
        'alphabet' => 'required|string|max:1', // Huruf A-Z
        'officer' => 'required|string|max:255',
        'queue_limit' => 'nullable|integer|min:0',
        'start_time' => 'nullable|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i',
        'is_active' => 'nullable|boolean',
    ]);

    // Gabungkan kode poli (alphabet + queue_limit jika ada)
    $validated['code'] = $validated['alphabet'] . '-' . ($validated['queue_limit'] ?? 0);

    // Tentukan apakah "is_active" dicentang atau tidak
    $validated['is_active'] = $request->has('is_active') ? true : false;

    // Update data poli
    try {
        $poli->update($validated);

        // Redirect ke halaman daftar poli dengan pesan sukses
        return redirect()->route('queue.selectLoket')->with('success', 'Data poli berhasil diperbarui.');
    } catch (\Exception $e) {    
        // Tangani kesalahan (jika ada)
        return redirect()->route('home')->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
    }
}

    public function destroy(Poli $poli)
    {
        $poli->delete();

        return redirect()->route('polis.index')->with('success', 'Poli berhasil dihapus.');
    }
}