<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MitraImport;

class MasterMitraController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query mitra berdasarkan search (Sobat ID atau Nama)
        $mitra = Mitra::query();
        if ($search) {
            $mitra->where('sobat_id', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%');
        }

        $mitra = $mitra->paginate(10); // Pagination
        return view('master-mitra', compact('mitra'));
    }

    public function create()
    {
        $wilayah = Wilayah::getWilayahGrouped(); // Menggunakan fungsi bawaan model Wilayah
        return view('master-mitra-create', compact('wilayah'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'sobat_id' => 'required|unique:mitra,sobat_id',
            'nama' => 'required',
            'email' => 'required|email|unique:mitra,email',
            'jenis_kelamin' => 'required|in:L,P', // Validasi jenis kelamin
        ]);

        // Proses data
        $data = $request->all();
        if (is_array($data['posisi'] ?? null)) {
            $data['posisi'] = implode(',', $data['posisi']);
        }

        Mitra::create($data);
        return redirect()->route('master-mitra')->with('success', 'Data mitra berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mitra = Mitra::findOrFail($id);

        // Pisahkan posisi menjadi array jika data ada
        $mitra->posisi = $mitra->posisi ? explode(',', $mitra->posisi) : [];

        $wilayah = Wilayah::getWilayahGrouped(); // Menggunakan fungsi bawaan model Wilayah
        return view('master-mitra-edit', compact('mitra', 'wilayah'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'sobat_id' => 'required|unique:mitra,sobat_id,' . $id,
            'nama' => 'required',
            'email' => 'required|email|unique:mitra,email,' . $id,
            'jenis_kelamin' => 'required|in:L,P', // Validasi jenis kelamin
        ]);

        // Proses data
        $data = $request->all();
        if (is_array($data['posisi'] ?? null)) {
            $data['posisi'] = implode(',', $data['posisi']);
        }

        Mitra::findOrFail($id)->update($data);
        return redirect()->route('master-mitra')->with('success', 'Data mitra berhasil diperbarui.');
    }

    public function delete($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();
        return redirect()->route('master-mitra')->with('success', 'Data mitra berhasil dihapus.');
    }

    public function showUploadForm()
    {
        return view('master-mitra-tambahfile');
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new MitraImport, $request->file('file'));
            return redirect()->route('master-mitra')->with('success', 'File berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }
}