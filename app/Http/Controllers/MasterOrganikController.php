<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function create()
    {
        $fungsi_ketua_tim = ['Nerwilis', 'IPDS', 'Statistik Produksi'];
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
}
