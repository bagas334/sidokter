<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Perusahaan;
use App\Models\Sampel;

class SampelController extends Controller
{
    public function show($id)
    {
        $sampel = Sampel::with('perusahaan')->findOrFail($id);
        return view('sampel-detail', compact('sampel'));
    }

    public function index()
    {
        $sampel = Sampel::with(['pegawai', 'kegiatan'])->get();
        return view('sampel-all', compact('sampel'));
    }

    public function create()
    {
        $kegiatan = Kegiatan::all();
        return view('sampel-create', compact('kegiatan'));
    }

    public function generate(Request $request)
    {
        // Validasi input
        $dibuatOleh = auth()->user()->id;

        // Ambil perusahaan secara random
        $perusahaan = Perusahaan::inRandomOrder()->take($request->jumlah)->get();

        // Cek apakah perusahaan mencukupi jumlah sampel yang diminta
        if ($perusahaan->count() < $request->jumlah) {
            return redirect()->back()->withErrors(['error' => 'Jumlah perusahaan tidak mencukupi untuk generate sampel.']);
        }

        // Buat satu entry untuk kegiatan
        $sampel = Sampel::create([
            'nama' => $request->nama,
            'kegiatan' => $request->kegiatan,
            'dibuat_oleh' => $dibuatOleh,
            'catatan' => $request->catatan
        ]);

        // Attach perusahaan ke sampel (tabel pivot)
        foreach ($perusahaan as $item) {
            $sampel->perusahaan()->attach($item->id);
        }

        return redirect()->route('sampel-all')->with('success', 'Sampel berhasil digenerate.');
    }
}
