<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Mitra;
use App\Models\Pegawai;
use App\Models\PenugasanMitra;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PenugasanMitraController extends Controller
{
    public function index()
    {
        $kegiatan_mitra = PenugasanMitra::with(['mitra', 'kegiatan'])->paginate(10);
        return view('penugasan-mitra-all', compact('kegiatan_mitra'));
    }

    public function show($id)
    {
        $detail_tugas = PenugasanMitra::getById($id);

        return view('penugasan-mitra-detail', compact('detail_tugas'));
    }

    public function create($id)
    {
        $kegiatan = Kegiatan::where('id', $id)->first();
        $mitra = Mitra::orderBy('pendapatan', 'asc')->get();
        return view('penugasan-mitra-create', compact('id', 'kegiatan', 'mitra'));
    }

    public function store(Request $request, $id)
    {
        $tanggal_penugasan = Carbon::now()->format('Y-m-d');

        $request->merge([
            'tanggal_penugasan' => $tanggal_penugasan,
        ]);
        $harga = Kegiatan::where('id', $request->kegiatan_id)->first()->harga_satuan;
        $mitra = Mitra::where('id', $request->petugas)->first();
        $pendapatanAwal = $mitra->pendapatan;
        $pendapatanAkhir = $pendapatanAwal + $harga * $request->target;
        if ($pendapatanAkhir > 100000) {
            return redirect()->back();
        }

        $mitra->pendapatan = $pendapatanAkhir;
        $mitra->save();
        PenugasanMitra::create($request->except('_token', '_method'));
        return redirect()->route('beban-kerja-tugas', ['id' => $id]);
    }

    public function edit($id, $petugas)
    {
        $awal = PenugasanMitra::where(['kegiatan_id' => $id, 'petugas' => $petugas])->with('kegiatan', 'mitra')->first();
        $mitra = Mitra::all();
        return view('penugasan-mitra-edit', compact('id', 'petugas', 'mitra', 'awal'));
    }

    public function update(Request $request, $id, $pegawai)
    {
        PenugasanMitra::where(['kegiatan_id' => $id, 'petugas' => $pegawai])->first()->update($request->except('_token', '_method'));
        return redirect()->route('beban-kerja-tugas', ['id' => $id]);
    }

    public function delete($penugasan, $id)
    {
        $tugas = PenugasanMitra::where('id', $id)->first();
        $mitra = Mitra::where('id', $tugas->petugas)->first();
        $kegiatan = Kegiatan::where('id', $tugas->kegiatan_id)->first();
        $mitra->pendapatan = $mitra->pendapatan - $kegiatan->harga_satuan * $tugas->target;
        $mitra->save();
        $tugas->delete();
        return redirect()->route('beban-kerja-tugas', ['id' => $penugasan]);
    }
}
