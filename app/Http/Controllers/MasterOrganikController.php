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
    // Deklarasi properti model
    protected $model;

    public function __construct()
    {
        // Inisialisasi model Pegawai
        $this->model = new Pegawai();
    }

    public function login()
    {
        return view('login');
    }

    /**
     * Menampilkan daftar pegawai dengan pencarian
     */
    public function index(Request $request)
    {
        // Ambil query pencarian dari input (default kosong jika tidak ada input)
        $search = $request->input('search', '');

        // Menggunakan $this->model yang sudah dideklarasikan
        $pegawai = Pegawai::query();

        // Jika ada pencarian, filter berdasarkan NIP BPS, NIP, atau Nama
        if ($search) {
            $pegawai = $pegawai->where(function ($query) use ($search) {
                $query->where('nip_bps', 'like', '%' . $search . '%')
                    ->orWhere('nip', 'like', '%' . $search . '%')
                    ->orWhere('nama', 'like', '%' . $search . '%');
            });
        }

        // Mengambil data pegawai dengan paginasi (batas 10 per halaman)
        $pegawai = $pegawai->paginate(10);

        // Mengembalikan data ke view dengan data pegawai dan query pencarian
        return view('master-organik-view', compact('pegawai', 'search'));
    }

    /**
     * Menampilkan detail pegawai dan penugasannya
     */
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

    /**
     * Menampilkan form untuk membuat data pegawai baru
     */
    public function create()
    {
        $fungsi_ketua_tim = ['Nerwilis', 'IPDS', 'Statistik Produksi', 'Statistik Distribusi', 'Statistik Sosial', 'Umum'];
        $options = ['Ketua Tim', 'Admin Kabupaten', 'Organik', 'Pimpinan'];

        return view('master-organik-create', compact('options', 'fungsi_ketua_tim'));
    }

    /**
     * Menyimpan data pegawai baru
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama' => 'required|max:100',
            'alias' => 'required|max:20',
            'nip' => 'required|numeric|unique:pegawai,nip',
            'nip_bps' => 'required|numeric|unique:pegawai,nip_bps',
            'password' => 'required',
            'jabatan' => 'required'
        ]);

        $data = $request->except('_token', '_method');
        $data['password'] = Hash::make($request->password);

        // Menyimpan data pegawai baru
        Pegawai::create($data);
        return redirect()->route('master-organik-view');
    }

    /**
     * Menampilkan form untuk mengedit data pegawai
     */
    public function edit($id)
    {
        $fungsi_ketua_tim = ['Nerwilis', 'IPDS', 'Statistik Produksi', 'Statistik Distribusi', 'Statistik Sosial', 'Umum'];
        $options = ['Ketua Tim', 'Admin Kabupaten', 'Organik', 'Pimpinan'];
        $pegawai = $this->model->find($id);
        return view('master-organik-edit', compact('pegawai', 'fungsi_ketua_tim', 'options'));
    }

    /**
     * Mengupdate data pegawai
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:100',
            'alias' => 'required|max:20',
            'nip' => 'required|numeric|unique:pegawai,nip',
            'nip_bps' => 'required|numeric|unique:pegawai,nip_bps',
            'password' => 'required',
            'jabatan' => 'required'
        ]);

        Pegawai::where('id', $id)->update($request->except('_token', '_method'));
        return redirect()->route('master-organik-view');
    }

    public function delete($id)
    {
        Pegawai::where('id', $id)->delete();

        return redirect()->route('master-organik-view');
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

        return back()->with('loginError', 'NIP BPS atau Password salah');
    }


    public function logout(Request $request)
    {
        // Logout dan invalidate session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect()->route('login');
    }
}
