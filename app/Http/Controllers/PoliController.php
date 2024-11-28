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
        return view('poli.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:polis,code',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);
    
        Poli::create([
            'name' => $request->name,
            'code' => $request->code,
            'queue_limit' => $request->queue_limit,
            'is_active' => $request->has('is_active'),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
    
        return redirect()->route('polis.index')->with('success', 'Poli berhasil ditambahkan.');
    }
    

    public function edit(Poli $poli)
    {
        return view('poli.edit', compact('poli'));
    }

    public function update(Request $request, Poli $poli)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:polis,code,' . $poli->id,
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);
    
        $poli->update([
            'name' => $request->name,
            'code' => $request->code,
            'queue_limit' => $request->queue_limit,
            'is_active' => $request->has('is_active'),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
    
        return redirect()->route('polis.index')->with('success', 'Poli berhasil diperbarui.');
    }
    

    public function destroy(Poli $poli)
    {
        $poli->delete();

        return redirect()->route('polis.index')->with('success', 'Poli berhasil dihapus.');
    }
}
