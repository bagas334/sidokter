<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PenugasanPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterOrganikController extends Controller
{
    public function __construct()
    {
        $this->model = new Pegawai();
    }

    public function login()
    {
        return view('login');
    }

    public function index()
    {
        $pegawai = $this->model->paginate(10);
        return view('manajemen-user', compact('pegawai'));
    }

    public function show($id, Request $request)
    {
        $pegawai = Pegawai::where('id', $id)->first();
        $penugasan_pegawai = PenugasanPegawai::where('petugas', $id);

        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if ($tanggalMulai && $tanggalAkhir) {
            $penugasan_pegawai = $penugasan_pegawai->whereBetween('tanggal_penugasan', [$tanggalMulai, $tanggalAkhir]);
        }

        $kegiatan = $penugasan_pegawai->with('kegiatan')->get();
        $chartData = DB::table('penugasan_pegawai')
            ->select(
                DB::raw("DATE_FORMAT(kegiatan.tanggal_mulai, '%Y-%m') as bulan_tahun"), // Format Tahun-Bulan
                DB::raw('SUM(penugasan_pegawai.target) as total_target')  // Menjumlahkan 'target'
            )
            ->join('kegiatan', 'penugasan_pegawai.kegiatan_id', '=', 'kegiatan.id')  // Join dengan tabel 'kegiatan'
            ->where('penugasan_pegawai.petugas', $id);

        if ($tanggalMulai && $tanggalAkhir) {
            $chartData = $chartData->whereBetween('kegiatan.tanggal_mulai', [$tanggalMulai, $tanggalAkhir]);
        }

        $chartData = $chartData->groupBy(DB::raw("DATE_FORMAT(kegiatan.tanggal_mulai, '%Y-%m')"))
            ->orderBy(DB::raw("DATE_FORMAT(kegiatan.tanggal_mulai, '%Y-%m')"), 'asc')  // Urutkan berdasarkan tahun dan bulan
            ->get();

        // Ambil label bulan dan tahun serta data total target
        $labels = $chartData->map(function ($item) {
            // Ubah format menjadi Jan'24, Feb'24, dst
            $bulanTahun = \DateTime::createFromFormat('Y-m', $item->bulan_tahun);
            return $bulanTahun->format('M\'y');  // Format yang diinginkan: Jan'24, Feb'24
        })->toArray();

        $dataTarget = $chartData->pluck('total_target')->toArray();

        $total = $penugasan_pegawai->sum('target');
        $selesai = $penugasan_pegawai->sum('terlaksana');
        $proses = $total - $selesai;

        return view('organik-detail', compact('pegawai', 'kegiatan', 'total', 'selesai', 'proses', 'labels', 'dataTarget'));
    }

    public function create()
    {
        $fungsi_ketua_tim = ['Nerwilis', 'IPDS', 'Statistik Produksi', 'Statistik Distribusi', 'Statistik Sosial', 'Umum'];
        $options = ['Ketua Tim', 'Admin Kabupaten', 'Organik', 'Pimpinan'];

        return view('manajemen-user-create', compact('options', 'fungsi_ketua_tim'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:100',
            'alias' => 'required|max:20',
            'nip' => 'required|numeric',
            'nip_bps' => 'required|numeric',
            'password' => 'required',
            'jabatan' => 'required'
        ]);

        $data = $request->except('_token', '_method');
        $data['password'] = Hash::make($request->password);
        Pegawai::create($data);

        return redirect()->route('master-organik');
    }

    public function edit($id)
    {
        $fungsi_ketua_tim = ['Nerwilis', 'IPDS', 'Statistik Produksi', 'Statistik Distribusi', 'Statistik Sosial', 'Umum'];
        $options = ['Ketua Tim', 'Admin Kabupaten', 'Organik', 'Pimpinan'];
        $pegawai = $this->model->find($id);
        return view('master-organik-edit', compact('pegawai', 'fungsi_ketua_tim', 'options'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:100',
            'alias' => 'required|max:20',
            'nip' => 'required|numeric',
            'nip_bps' => 'required|numeric',
            'password' => 'required',
            'jabatan' => 'required'
        ]);

        Pegawai::where('id', $id)->update($request->except('_token', '_method'));
        return redirect()->route('master-organik');
    }

    public function delete($id)
    {
        Pegawai::where('id', $id)->delete();
        return redirect()->route('master-organik');
    }

    public function validateUser(Request $request)
    {
        $credentials = $request->validate([
            'nip_bps' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('beban-kerja-all');
        }

        dd('Username atau password salah');

        return back()->with('loginError', 'NIP BPS atau Password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
