<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perusahaan = Perusahaan::query();

        // Search across all columns
        if ($search) {
            $perusahaan = $perusahaan->where('idsbr', 'like', '%' . $search . '%')
                                     ->orWhere('nama_usaha', 'like', '%' . $search . '%')
                                     ->orWhere('kode_wilayah', 'like', '%' . $search . '%')
                                     ->orWhere('sls', 'like', '%' . $search . '%')
                                     ->orWhere('alamat_detail', 'like', '%' . $search . '%')
                                     ->orWhere('kode_kbli', 'like', '%' . $search . '%')
                                     ->orWhere('nama_cp', 'like', '%' . $search . '%')
                                     ->orWhere('nomor_cp', 'like', '%' . $search . '%')
                                     ->orWhere('email', 'like', '%' . $search . '%');
        }

        $perusahaan = $perusahaan->paginate(10);
        return view('perusahaan-all', compact('perusahaan'));
    }

    public function create()
    {
        return view('perusahaan-all-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'idsbr' => 'required|string|max:255|unique:perusahaan,idsbr',
            'kode_wilayah' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:255',
            'sls' => 'nullable|string|max:255',
            'alamat_detail' => 'required|string|max:500',
            'kode_kbli' => 'nullable|string|max:50',
            'nama_cp' => 'required|string|max:255',
            'nomor_cp' => 'required|string|max:20',
            'email' => 'required|email|unique:perusahaan,email',
        ]);

        Perusahaan::create($request->all());
        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('perusahaan-all-edit', compact('perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'idsbr' => 'required|string|max:255|unique:perusahaan,idsbr,' . $id,
            'kode_wilayah' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:255',
            'sls' => 'nullable|string|max:255',
            'alamat_detail' => 'required|string|max:500',
            'kode_kbli' => 'nullable|string|max:50',
            'nama_cp' => 'required|string|max:255',
            'nomor_cp' => 'required|string|max:20',
            'email' => 'required|email|unique:perusahaan,email,' . $id,
        ]);

        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update($request->all());

        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();

        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
}
