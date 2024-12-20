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
        $kegiatan = Kegiatan::where('id', $id);
        $mitra = Mitra::all();

        return view('penugasan-mitra-create', compact('id', 'kegiatan', 'mitra'));
    }

    public function store(Request $request, $id)
    {
        $tanggal_penugasan = Carbon::now()->format('Y-m-d');

        $request->merge([
            'tanggal_penugasan' => $tanggal_penugasan,
        ]);


        PenugasanMitra::create($request->except('_token', '_method'));

        return redirect()->route('beban-kerja-tugas', ['id' => $id]);
    }

    public function edit($id): View
    {
        $detail_tugas = PenugasanMitra::getById($id);
        $pilihan_pelaksana = Mitra::all(['id', 'nama']);
        $pilihan_pemberi_tugas = Pegawai::all(['id', 'nama']);
        $pilihan_status = self::getStatusKegiatan();

        return view('penugasan-mitra-edit', compact('detail_tugas', 'pilihan_pelaksana', 'pilihan_pemberi_tugas', 'pilihan_status'));
    }

    public function update(Request $request, $id)
    {
        $tanggal_penugasan_converted = DateTime::createFromFormat('d-m-Y', $request->get('tanggal_penugasan'))->format('Y-m-d');
        $request->merge([
            'tanggal_penugasan' => $tanggal_penugasan_converted,
        ]);

        PenugasanMitra::where('id', $id)->update($request->except('_token', '_method'));

        return redirect()->route('penugasan-mitra-detail', ['id' => $id]);
    }

    public function delete($penugasan, $id)
    {
        PenugasanMitra::where('id', $id)->delete();
        return redirect()->route('beban-kerja-tugas', ['id' => $penugasan]);
    }
}
