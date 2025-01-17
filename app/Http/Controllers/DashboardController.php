<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Mitra;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\PenugasanPegawai;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            // Mengalihkan jika user tidak terautentikasi
            return redirect()->route('login');
        }

        // Query default berdasarkan jabatan
        if (in_array($user->jabatan, ['Admin Kabupaten', 'Pimpinan'])) {
            $query = Kegiatan::query();
        } elseif ($user->jabatan == 'Organik') {
            $query = PenugasanPegawai::where('petugas', $user->id)
                ->with('kegiatan');
        } else {
            $query = Kegiatan::where('asal_fungsi', $user->fungsi_ketua_tim);
        }

        // Filter berdasarkan parameter tanggal_mulai dan tanggal_akhir
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
            $query->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalAkhir]);
        } elseif ($request->filled('tanggal_mulai')) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $query->where('tanggal_mulai', '>=', $tanggalMulai);
        } elseif ($request->filled('tanggal_akhir')) {
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
            $query->where('tanggal_mulai', '<=', $tanggalAkhir);
        }

        // Filter berdasarkan bulan (jika ada)
        if ($request->filled('bulan')) {
            $bulan = explode('-', $request->bulan);
            $query->whereYear('tanggal_mulai', $bulan[0])
                ->whereMonth('tanggal_mulai', $bulan[1]);
        }

        // Filter berdasarkan tahun (jika ada)
        if ($request->filled('tahun')) {
            $tahun = $request->tahun;
            $query->whereYear('tanggal_mulai', $tahun);
        }

        // Eksekusi query
        $kegiatan = $query->get();

        // Hitung total kegiatan
        $totalKegiatan = $query->count();

        // Hitung distribusi kegiatan berdasarkan asal_fungsi
        $distribusiKegiatan = Kegiatan::query()
            ->selectRaw(
                'asal_fungsi, COUNT(*) as jumlah, (COUNT(*) * 100.0 / ?) as persentase, MIN(tanggal_mulai) as tanggal_mulai, MAX(tanggal_akhir) as tanggal_akhir',
                [$totalKegiatan]
            )
            ->groupBy('asal_fungsi')
            ->get();

        // Hitung beban kerja per pegawai
        $bebanKerjaChart = PenugasanPegawai::query()
            ->selectRaw('petugas, COUNT(*) as jumlah_kegiatan, SUM(target) as jumlah_satuan')
            ->groupBy('petugas')
            ->with('pegawai')
            ->get()
            ->map(function ($item) {
                return [
                    'petugas' => $item->pegawai->nama,
                    'jumlah_kegiatan' => $item->jumlah_kegiatan,
                    'jumlah_satuan' => $item->jumlah_satuan,
                    'create_at' => $item->create_at
                ];
            });

        $distribusiKerjaChart = Kegiatan::query()
            ->selectRaw('asal_fungsi, COUNT(*) as jumlah')
            ->groupBy('asal_fungsi')
            ->get()
            ->map(function ($item) {
                return [
                    'asal_fungsi' => $item->asal_fungsi,
                    'jumlah' => $item->jumlah
                ];
            });

        // Menjaga penugasanPegawai tetap ada
        $penugasanPegawai = PenugasanPegawai::query()
            ->selectRaw('petugas, COUNT(*) as jumlah_kegiatan, SUM(target) as jumlah_satuan')
            ->groupBy('petugas')
            ->with('pegawai')
            ->get();

        return view('dashboard', compact('kegiatan', 'distribusiKegiatan', 'penugasanPegawai', 'bebanKerjaChart', 'distribusiKerjaChart', 'user'));
    }

    public function filter(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $kegiatanQuery = Kegiatan::query();

        if ($tanggalMulai && $tanggalAkhir) {
            $tanggalMulai = Carbon::parse($tanggalMulai)->startOfDay();
            $tanggalAkhir = Carbon::parse($tanggalAkhir)->endOfDay();
            $kegiatanQuery->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalAkhir]);
        } elseif ($tanggalMulai) {
            $tanggalMulai = Carbon::parse($tanggalMulai)->startOfDay();
            $kegiatanQuery->where('tanggal_mulai', '>=', $tanggalMulai);
        } elseif ($tanggalAkhir) {
            $tanggalAkhir = Carbon::parse($tanggalAkhir)->endOfDay();
            $kegiatanQuery->where('tanggal_mulai', '<=', $tanggalAkhir);
        }

        $penugasanPegawai = PenugasanPegawai::all();
        $distribusiKegiatan = Kegiatan::selectRaw('asal_fungsi, COUNT(*) as jumlah, (COUNT(*) * 100.0 / ?) as persentase', [count($penugasanPegawai)])
            ->groupBy('asal_fungsi')
            ->get();

        return response()->json([
            'bebanKerja' => $penugasanPegawai,
            'distribusiKegiatan' => $distribusiKegiatan
        ]);
    }
}
