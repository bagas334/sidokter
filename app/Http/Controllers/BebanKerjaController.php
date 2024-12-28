<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Pegawai;
use App\Models\PenugasanMitra;
use App\Models\PenugasanPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BebanKerjaController extends Controller
{

    public function show($id)
    {

        $penugasanPegawai = PenugasanPegawai::with('pegawai') // Memuat relasi 'pegawai'
            ->where('kegiatan_id', $id)
            ->get();

        // Ambil data PenugasanMitra dan gunakan eager loading untuk relasi mitra
        $penugasanMitra = PenugasanMitra::with('mitra')
            ->where('kegiatan_id', $id)
            ->get();

        // Periksa jika data PenugasanPegawai tidak kosong
        if ($penugasanPegawai->isNotEmpty()) {
            // Map untuk mendapatkan nama pegawai
            $pegawai = $penugasanPegawai->map(function ($item) {
                return optional($item->pegawai)->nama; // Mengambil nama pegawai jika ada
            });
        } else {
            $pegawai = []; // Jika tidak ada data, set array kosong
        }

        // Periksa jika data PenugasanMitra tidak kosong
        if ($penugasanMitra->isNotEmpty()) {
            // Map untuk mendapatkan nama mitra
            $mitra = $penugasanMitra->map(function ($item) {
                return optional($item->mitra)->nama; // Mengambil nama mitra jika ada
            });
        } else {
            $mitra = []; // Jika tidak ada data, set array kosong
        }

        // Ambil data kegiatan
        $kegiatan = Kegiatan::find($id);

        // Hitung progres
        $totalTarget = $kegiatan->target;

        // Hitung total ditugaskan (progres)
        $totalDitugaskan = (
            DB::table('penugasan_pegawai')
            ->where('kegiatan_id', $id)
            ->selectRaw('SUM(target - terlaksana) as total')
            ->value('total')
        ) + (
            DB::table('penugasan_mitra')
            ->where('kegiatan_id', $id)
            ->selectRaw('SUM(target - terlaksana) as total')
            ->value('total')
        );

        // Hitung total tugas selesai
        $totalSelesai = (
            DB::table('penugasan_pegawai')
            ->where('kegiatan_id', $id)
            ->sum('terlaksana')
        ) + (
            DB::table('penugasan_mitra')
            ->where('kegiatan_id', $id)
            ->sum('terlaksana')
        );


        // Hitung persentase progres
        $progresDitugaskan = $totalTarget > 0 ? ($totalDitugaskan / $totalTarget) * 100 : 0;
        $progresSelesai = $totalTarget > 0 ? ($totalSelesai / $totalTarget) * 100 : 0;

        return view('penugasan-detail', compact(
            'pegawai', // Mengirim koleksi nama pegawai
            'mitra',   // Mengirim koleksi nama mitra
            'kegiatan', // Mengirim data kegiatan
            'id', // Mengirim id kegiatan
            'penugasanPegawai', // Mengirim semua data penugasan pegawai
            'penugasanMitra', // Mengirim semua data penugasan mitra
            'progresDitugaskan',
            'progresSelesai'
        ));
    }

    public function delete($id)
    {
        $kegiatan = Kegiatan::where('id', $id);
        $kegiatan->delete();
        return redirect()->route('beban-kerja-all');
    }

    public function create()
    {
        $fungsi = array("Statistik Produksi", "Statistik Sosial", "Statistik Distribusi", "Nerwilis", "IPDS");
        return view('penugasan-create', compact('fungsi'));
    }

    public function store(Request $request)
    {
        Kegiatan::create($request->except('_token', '_method'));
        return redirect()->route('beban-kerja-all');
    }

    public function showAll()
    {
        // Ambil semua data kegiatan dengan paginasi 10 per halaman
        if (auth()->check() && in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan'])) {
            $kegiatan = Kegiatan::paginate(10);
        } else if (auth()->check() && auth()->user()->jabatan == 'Organik') {
            $kegiatan = PenugasanPegawai::where('petugas', auth()->user()->id)
                ->with('kegiatan') // Memuat relasi
                ->paginate(10);
        } else {
            $kegiatan = Kegiatan::where('asal_fungsi', auth()->user()->fungsi_ketua_tim)->paginate(10);
        }



        foreach ($kegiatan as $k) {
            // Update kolom 'terlaksana' berdasarkan penugasan_pegawai dan penugasan_mitra
            DB::table('kegiatan')
                ->where('id', $k->id)
                ->update([
                    'terlaksana' => DB::raw('(
                        SELECT COALESCE(SUM(p.terlaksana), 0) 
                        FROM penugasan_pegawai p
                        WHERE p.kegiatan_id = kegiatan.id
                    ) + (
                        SELECT COALESCE(SUM(m.terlaksana), 0)
                        FROM penugasan_mitra m
                        WHERE m.kegiatan_id = kegiatan.id
                    )')
                ]);
        }
        return view('penugasan-all', compact('kegiatan'));
    }
}
