<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    public function show($id)
    {
        $pegawai = Pegawai::where('id', $id);
        return view('organik-detail', compact('pegawai'));
    }

    public function create()
    {
        $fungsi_ketua_tim = ['Nerwilis', 'IPDS', 'Statistik Produksi', 'Statistik Distribusi', 'Statistik Sosial', 'Umum'];
        $options = ['Ketua Tim', 'Admin Kabupaten', 'Organik', 'Pimpinan'];

        return view('manajemen-user-create', compact('options', 'fungsi_ketua_tim'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token', '_method');
        $data['password'] = Hash::make($request->password);
        Pegawai::create($data);

        return redirect()->route('master-organik');
    }

    public function edit($id)
    {
        $pegawai = $this->model->find($id);
        return view('master-organik-edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        //        dd($request->all());
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
}
