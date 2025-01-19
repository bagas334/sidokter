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
    public function index(Request $request)
    {
        $search = $request->get('search');

        $kegiatan_mitra = PenugasanMitra::with(['mitra', 'kegiatan'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('mitra', function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%");
                })
                    ->orWhereHas('kegiatan', function ($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%");
                    });
            })
            ->paginate(10);

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

        $request->validate([
            'petugas' => 'required|unique:penugasan_mitra,petugas',
            'target' => 'required|numeric',
        ]);


        $request->merge([
            'tanggal_penugasan' => $tanggal_penugasan,
        ]);

        $harga = Kegiatan::where('id', $request->kegiatan_id)->first()->harga_satuan;
        $mitra = Mitra::where('id', $request->petugas)->first();
        $pendapatanAwal = $mitra->pendapatan;
        $pendapatanAkhir = $pendapatanAwal + $harga * $request->target;

        if ($pendapatanAkhir > 4000000) {
            return redirect()->back()->with('pendapatanError', 'Pendapatan total di atas 4 juta.');
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
        $request->validate([
            'target' => 'required|numeric',
            'terlaksana' => 'numeric',
        ]);

        $penugasan_mitra = PenugasanMitra::where(['kegiatan_id' => $id, 'petugas' => $pegawai])->first();
        if ($penugasan_mitra->target < $request->terlaksana) {
            return redirect()->back()->with('terlaksanaError', 'Jumlah terlaksana melebihi target');
        }

        $harga = Kegiatan::where('id', $request->kegiatan_id)->first()->harga_satuan;
        $mitra = Mitra::where('id', $request->petugas)->first();
        $pendapatanAwal = $mitra->pendapatan;
        $pendapatanAkhir = $pendapatanAwal + $harga * $request->target;

        if ($pendapatanAkhir > 4000000) {
            return redirect()->back()->with('pendapatanError', 'Pendapatan total di atas 4 juta.');
        }

        $penugasan_mitra->update($request->except('_token', '_method'));
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
