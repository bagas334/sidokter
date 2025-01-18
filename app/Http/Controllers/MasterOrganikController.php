<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
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
        $search = $request->input('search', '');

        $pegawai = Pegawai::query();

        if ($search) {
            $pegawai = $pegawai->where(function ($query) use ($search) {
                $query->where('nip_bps', 'like', '%' . $search . '%')
                    ->orWhere('nip', 'like', '%' . $search . '%')
                    ->orWhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('alias', 'like', '%' . $search . '%')
                    ->orWhere('jabatan', 'like', '%' . $search . '%');
            });
        }

        $pegawai = $pegawai->paginate(10);

        return view('manajemen-user', compact('pegawai', 'search'));
    }

    public function indexUser(Request $request)
    {
        $search = $request->input('search', '');

        $user = User::with('pegawai');
        // if ($search) {
        //     $user = $user->where(function ($query) use ($search) {
        //         $query->where('nip_bps', 'like', '%' . $search . '%')
        //             ->orWhere('nip', 'like', '%' . $search . '%')
        //             ->orWhere('nama', 'like', '%' . $search . '%')
        //             ->orWhere('alias', 'like', '%' . $search . '%')
        //             ->orWhere('jabatan', 'like', '%' . $search . '%');
        //     });
        // }

        $user = $user->paginate(10);

        return view('user-all', compact('user', 'search'));
    }


    /**
     * Menampilkan detail pegawai dan penugasannya
     */
    public function show($id, Request $request)
    {
        $pegawai = Pegawai::where('id', $id)->first();
        $penugasan_pegawai = PenugasanPegawai::where('petugas', $id)
            ->with('kegiatan');

        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if ($tanggalMulai && $tanggalAkhir) {
            $penugasan_pegawai = $penugasan_pegawai->where(function ($query) use ($tanggalMulai, $tanggalAkhir) {
                $query->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])
                    ->orWhere(function ($query) use ($tanggalMulai, $tanggalAkhir) {
                        $query->whereBetween('finished_at', [$tanggalMulai, $tanggalAkhir])
                            ->orWhereNull('finished_at');
                    });
            });
        }

        $penugasan_pegawai = $penugasan_pegawai->paginate(10);

        $chartData = DB::table('penugasan_pegawai')
            ->select(
                DB::raw("DATE_FORMAT(kegiatan.tanggal_mulai, '%Y-%m') as bulan_tahun"),
                DB::raw('SUM(penugasan_pegawai.target) as total_target')
            )
            ->join('kegiatan', 'penugasan_pegawai.kegiatan_id', '=', 'kegiatan.id')
            ->where('penugasan_pegawai.petugas', $id);

        if ($tanggalMulai && $tanggalAkhir) {
            $chartData = $chartData->where(function ($query) use ($tanggalMulai, $tanggalAkhir) {
                $query->whereBetween('kegiatan.tanggal_mulai', [$tanggalMulai, $tanggalAkhir])
                    ->orWhere(function ($query) use ($tanggalMulai, $tanggalAkhir) {
                        $query->whereBetween('penugasan_pegawai.finished_at', [$tanggalMulai, $tanggalAkhir])
                            ->orWhereNull('penugasan_pegawai.finished_at');
                    });
            });
        }

        $chartData = $chartData->groupBy(DB::raw("DATE_FORMAT(kegiatan.tanggal_mulai, '%Y-%m')"))
            ->orderBy(DB::raw("DATE_FORMAT(kegiatan.tanggal_mulai, '%Y-%m')"), 'asc')
            ->get();

        $labels = $chartData->map(function ($item) {
            $startDate = \DateTime::createFromFormat('Y-m', $item->bulan_tahun)->format('M\'y');
            return $startDate;
        })->toArray();

        $dataTarget = $chartData->pluck('total_target')->toArray();

        $total = $penugasan_pegawai->sum('target');
        $selesai = $penugasan_pegawai->sum('terlaksana');
        $proses = $total - $selesai;

        return view('organik-detail', compact('pegawai', 'penugasan_pegawai', 'total', 'selesai', 'proses', 'labels', 'dataTarget', 'tanggalMulai', 'tanggalAkhir'));
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

    public function createUser()
    {
        $options = Pegawai::all();
        $fungsi_ketua_tim = ['Nerwilis', 'IPDS', 'Statistik Produksi', 'Statistik Distribusi', 'Statistik Sosial', 'Umum'];
        $opsi = ['Ketua Tim', 'Admin Kabupaten', 'Organik', 'Pimpinan'];
        return view('user-create', compact('options', 'opsi', 'fungsi_ketua_tim'));
    }

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

        Pegawai::create($data);
        return redirect()->route('master-organik');
    }

    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'jabatan' => 'required',
            'password' => 'required|min:8|max:60',
        ]);

        $data = $request->except('_token', '_method');
        $data['password'] = Hash::make($request->password);

        User::create($data);
        return redirect()->route('manajemen-user');
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

    public function editUser($id)
    {
        $user = User::where('id', $id)->with('pegawai')->first();
        $fungsi_ketua_tim = ['Nerwilis', 'IPDS', 'Statistik Produksi', 'Statistik Distribusi', 'Statistik Sosial', 'Umum'];
        $opsi = ['Ketua Tim', 'Admin Kabupaten', 'Organik', 'Pimpinan'];
        return view('user-edit', compact('user', 'opsi', 'fungsi_ketua_tim'));
    }


    public function updateUser(Request $request, $id)
    {
        if ($request->password) {
            $validatedData = $request->validate([
                'email' => 'required',
                'jabatan' => 'required',
                'password' => 'required|min:8|max:60',
            ]);
            User::where('id', $id)->update($request->except('_token', '_method', 'nama'));
        } else {
            $validatedData = $request->validate([
                'email' => 'required',
                'jabatan' => 'required',
            ]);
            User::where('id', $id)->update($request->except('_token', '_method', 'nama', 'password'));
        }

        return redirect()->route('manajemen-user');
    }

    /**
     * Mengupdate data pegawai
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:100',
            'alias' => 'required|max:20',
            'nip' => 'required|numeric|unique:pegawai,nip,' . $id,
            'nip_bps' => 'required|numeric|unique:pegawai,nip_bps,' . $id,
            'jabatan' => 'required'
        ]);

        Pegawai::where('id', $id)->update($request->except('_token', '_method'));
        return redirect()->route('master-organik');
    }


    /**
     * Menghapus data pegawai
     */
    public function delete($id)
    {
        // Hapus data pegawai berdasarkan ID
        Pegawai::where('id', $id)->delete();

        return redirect()->route('manajemen-user');
    }

    public function deleteUser($id)
    {
        $user = User::where('id', $id);
        $user->delete();
        return redirect()->route('manajemen-user');
    }


    /**
     * Validasi login pengguna
     */
    public function validateUser(Request $request)
    {
        // Validasi input untuk login
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // Proses autentikasi user
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('beban-kerja-all');
        }

        return back()->with('loginError', 'Email atau Password salah');
    }

    /**
     * Logout pengguna
     */
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
