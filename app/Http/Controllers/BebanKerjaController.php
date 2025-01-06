<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Pegawai;
use App\Models\PenugasanMitra;
use App\Models\PenugasanPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class BebanKerjaController extends Controller
{

    public function show($id)
    {

        $penugasanPegawai = PenugasanPegawai::with('pegawai') // Memuat relasi 'pegawai'
            ->where('kegiatan_id', $id)
            ->paginate(10);

        // Ambil data PenugasanMitra dan gunakan eager loading untuk relasi mitra
        $penugasanMitra = PenugasanMitra::with('mitra')
            ->where('kegiatan_id', $id)
            ->paginate(10);

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
        $validatedData = $request->validate([
            'nama' => 'required|max:100',
            'target' => 'required|numeric|min:1',
            'asal_fungsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'satuan' => 'required',
            'harga_satuan' => 'required'
        ]);

        Kegiatan::create($request->except('_token', '_method'));
        return redirect()->route('beban-kerja-all');
    }

    public function showAll(Request $request)
    {
        $user = auth()->user();

        // Query default berdasarkan jabatan
        if ($user && in_array($user->jabatan, ['Admin Kabupaten', 'Pimpinan'])) {
            $query = Kegiatan::query();
        } elseif ($user && $user->jabatan == 'Organik') {
            $query = PenugasanPegawai::where('petugas', $user->id)->with('kegiatan');
        } else {
            $query = Kegiatan::where('asal_fungsi', $user->fungsi_ketua_tim);
        }

        // Filter berdasarkan parameter tanggal_mulai dan tanggal_akhir
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();

            $query->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalAkhir]);
        } elseif ($request->filled('tanggal_mulai')) {
            // Jika hanya tanggal mulai yang diisi
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $query->where('tanggal_mulai', '>=', $tanggalMulai);
        } elseif ($request->filled('tanggal_akhir')) {
            // Jika hanya tanggal akhir yang diisi
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
            $query->where('tanggal_mulai', '<=', $tanggalAkhir);
        }

        // Filter berdasarkan bulan (jika ada)
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_mulai', $request->bulan);
        }

        // Sorting berdasarkan parameter (sort dan order)
        if ($user && in_array($user->jabatan, ['Admin Kabupaten', 'Pimpinan'])) {
            $sort = $request->get('sort', 'tanggal_mulai'); // Default sort by 'tanggal_mulai'
            $order = $request->get('order', 'asc'); // Default order is ascending
            $query->orderBy($sort, $order);
        }
        // Perbarui kolom 'terlaksana' secara batch
        Kegiatan::query()->update([
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

        // Data tambahan untuk view
        $filterParams = $request->only('tanggal_mulai', 'tanggal_akhir', 'bulan', 'sort', 'order');

        if ($user && in_array($user->jabatan, ['Admin Kabupaten', 'Pimpinan'])) {
            $kegiatan = $query->paginate(10);
            return view('penugasan-all', compact('kegiatan', 'filterParams', 'sort', 'order'));
        } else {
            $kegiatan = $query->paginate(10);
            return view('penugasan-all', compact('kegiatan'));
        }
    }
}
