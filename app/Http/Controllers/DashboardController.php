<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Mitra;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\PenugasanPegawai;
use Carbon\Carbon; // Pastikan ini ada!

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
            // Validasi dan konversi tanggal ke format database
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

        // Eksekusi query
        $kegiatan = $query->get(); // Anda bisa mengganti get() dengan paginate() jika ingin paginasi

        // Query default berdasarkan jabatan
        if ($user && in_array($user->jabatan, ['Admin Kabupaten', 'Pimpinan'])) {
            $query = Kegiatan::query();
        } elseif ($user && $user->jabatan == 'Organik') {
            $query = PenugasanPegawai::where('petugas', $user->id)->with('kegiatan')->get();
        } else {
            $query = Kegiatan::where('asal_fungsi', $user->fungsi_ketua_tim);
        }

        // Hitung total kegiatan
        $totalKegiatan = $query->count();

        // Hitung distribusi kegiatan berdasarkan asal_fungsi
        $distribusiKegiatan = $query->selectRaw('asal_fungsi, COUNT(*) as jumlah, (COUNT(*) * 100.0 / ?) as persentase', [$totalKegiatan])
            ->groupBy('asal_fungsi')
            ->get();

        $penugasanPegawai = PenugasanPegawai::selectRaw('petugas, COUNT(*) as jumlah_kegiatan, SUM(target) as jumlah_satuan')
            ->groupBy('petugas')->with('pegawai')
            ->get();


        return view('dashboard', compact('kegiatan', 'distribusiKegiatan', 'penugasanPegawai'));
    }
}
