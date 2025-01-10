<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Pegawai;
use App\Models\PenugasanPegawai;
use App\Models\TugasPegawai;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenugasanPegawaiController extends Controller
{
    public function show($id)
    {
        $detail_tugas = PenugasanPegawai::getById($id);
        return view('penugasan-organik-detail', compact('detail_tugas'));
    }

    public function index()
    {
        $pegawai = Pegawai::paginate(10);
        return view('penugasan-organik-all', compact('pegawai'));
    }


    public function view($id, $pegawai)
    {
        if (auth()->user()->jabatan == 'Organik') {
            if (auth()->user()->id != $pegawai) {
                return redirect()->back();
            }
        }


        $penugasan_pegawai_id = PenugasanPegawai::with(['pegawai', 'kegiatan']) // Pastikan relasi dimuat
            ->where(['kegiatan_id' => $id, 'petugas' => $pegawai])
            ->first()->id;

        $kegiatan = Kegiatan::where('id', $id)->first();

        $nama_kegiatan = $kegiatan->nama;
        $nama_pegawai = Pegawai::where('id', $pegawai)->first()->nama;

        if (auth()->user()->jabatan == 'Ketua Tim') {
            if (auth()->user()->fungsi_ketua_tim != $kegiatan->asal_fungsi) {
                return redirect()->back();
            }
        }

        $tugas_pegawai = TugasPegawai::where('penugasan_pegawai', $penugasan_pegawai_id)
            ->whereIn('status', ['proses', 'selesai'])
            ->get();

        $pengajuan_pegawai = TugasPegawai::where(['penugasan_pegawai' => $penugasan_pegawai_id, 'status' => 'diajukan'])->get();
        return view('penugasan-detail-organik', compact('pengajuan_pegawai', 'penugasan_pegawai_id', 'id', 'pegawai', 'nama_pegawai', 'nama_kegiatan', 'tugas_pegawai'));
    }

    public function create($id)
    {
        $kegiatan = Kegiatan::where('id', $id)->first();
        $pilihan_pegawai = Pegawai::select('id', 'nama')->get();
        $satuan_kegiatan = self::getSatuanKegiatan();

        return view('penugasan-organik-create', compact('pilihan_pegawai', 'kegiatan', 'satuan_kegiatan', 'id'));
    }

    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'jabatan' => 'required|max:30',
            'petugas' => 'required',
            'target' => 'required|numeric|min:1',
            'status' => 'required|string|in:Ditugaskan'
        ]);

        PenugasanPegawai::create($request->except('_token', '_method'));
        return redirect()->route('beban-kerja-tugas', ['id' => $id]);
    }

    public function update(Request $request, $id, $pegawai)
    {
        $validatedData = $request->validate([
            'jabatan' => 'required|max:30',
            'petugas' => 'required',
            'target' => 'required|numeric|min:1',
            'status' => 'required|string|in:Ditugaskan'
        ]);

        $tanggal_penugasan = Carbon::now()->format('Y-m-d');

        $request->merge([
            'tanggal_penugasan' => $tanggal_penugasan,
        ]);
        PenugasanPegawai::where(['kegiatan_id' => $id, 'petugas' => $pegawai])->update($request->except('_token', '_method'));
        return redirect()->route('beban-kerja-tugas', ['id' => $id]);
    }

    public function edit($id, $pegawai)
    {

        $tugas_pegawai = PenugasanPegawai::where(['kegiatan_id' => $id, 'petugas' => $pegawai])->first();
        return view('penugasan-organik-edit', compact('tugas_pegawai', 'id'));
    }

    public function deleteTugas($id)
    {
        TugasPegawai::where('id', $id)->delete();
        return redirect()->back();
    }

    public function createTugas($id, $pegawai)
    {
        $penugasan = PenugasanPegawai::where(['kegiatan_id' => $id, 'petugas' => $pegawai])->first();
        $penugasan_pegawai_id = $penugasan->id;
        return view('pengumpulan-tugas-organik-create', compact('penugasan_pegawai_id', 'id', 'pegawai'));
    }

    public function createPengajuan($id, $pegawai)
    {
        $penugasan = PenugasanPegawai::where(['kegiatan_id' => $id, 'petugas' => $pegawai])->first();
        $penugasan_pegawai_id = $penugasan->id;
        return view('pengajuan-tugas-organik-create', compact('penugasan_pegawai_id', 'id', 'pegawai'));
    }

    public function editTugas($tugas)
    {
        $tugas_pegawai = TugasPegawai::where('id', $tugas)->with('penugasanPegawai')->first();
        return view('pengumpulan-tugas-organik-edit', compact('tugas', 'tugas_pegawai'));
    }


    public function storeTugas(Request $request)
    {
        $id = $request->kegiatan_id;
        $pegawai = $request->pegawai_id;
        $penugasanPegawai = TugasPegawai::create($request->except('_token', '_method', 'id', 'pegawai_id'));
        return redirect()->route('penugasan-organik-detail', ['id' => $id, 'petugas' => $pegawai]);
    }

    public function updateTugas(Request $request)
    {
        $id = $request->kegiatan_id;
        $pegawai = $request->pegawai_id;
        TugasPegawai::where('id', $request->id)->first()->update($request->except('_token', '_method', 'id', 'pegawai_id'));
        return redirect()->route('penugasan-organik-detail', ['id' => $id, 'petugas' => $pegawai]);
    }

    public function delete($penugasan, $id)
    {
        PenugasanPegawai::where('id', $id)->delete();
        return redirect()->route('beban-kerja-tugas', ['id' => $penugasan]);
    }

    public function accPenugasan($id, $petugas, $tugasId)
    {
        $tugas = TugasPegawai::where('id', $tugasId)->first();
        if ($tugas->status == 'selesai') {
            $tugas->status = 'proses';
        } else {
            $tugas->status = 'selesai';
        }

        $tugas->save();

        DB::table('penugasan_pegawai')
            ->where('penugasan_pegawai.kegiatan_id', $id)
            ->update([
                'terlaksana' => DB::raw('(
                SELECT SUM(dikerjakan)
                FROM tugas_pegawai
                WHERE tugas_pegawai.penugasan_pegawai = penugasan_pegawai.id
                AND status = "selesai"
            )')
            ]);

        return redirect()->route('penugasan-organik-detail', ['petugas' => $petugas, 'id' => $id]);
    }

    public function accPengajuan($id, $petugas, $tugasId)
    {
        $tugas = TugasPegawai::where('id', $tugasId)->first();
        $tugas->status = 'proses';
        $tugas->save();

        return redirect()->route('penugasan-organik-detail', ['petugas' => $petugas, 'id' => $id]);
    }

    public function accPengajuanTabel($tugasId)
    {
        $tugas = TugasPegawai::where('id', $tugasId)->first();
        $tugas->status = 'proses';
        $tugas->save();
        return redirect()->route('pengajuan-all');
    }
}
