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
        $kegiatan_pegawai = PenugasanPegawai::with(['pegawai', 'kegiatan'])->paginate(10);
        return view('penugasan-organik-all', compact('kegiatan_pegawai'));
    }



    public function view($id, $pegawai)
    {
        $penugasan_pegawai_id = PenugasanPegawai::with(['pegawai', 'kegiatan']) // Pastikan relasi dimuat
            ->where(['kegiatan_id' => $id, 'petugas' => $pegawai])
            ->first()->id;

        $nama_kegiatan = Kegiatan::where('id', $id)->first()->nama;
        $nama_pegawai = Pegawai::where('id', $pegawai)->first()->nama;

        $tugas_pegawai = TugasPegawai::where('penugasan_pegawai', $penugasan_pegawai_id)
            ->whereIn('status', ['proses', 'selesai'])
            ->get();

        $pengajuan_pegawai = TugasPegawai::where(['penugasan_pegawai' => $penugasan_pegawai_id, 'status' => 'diajukan'])->get();


        // Kembalikan ke view dengan semua variabel yang dibutuhkan
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
        $tanggal_penugasan = Carbon::now()->format('Y-m-d');

        $request->merge([
            'tanggal_penugasan' => $tanggal_penugasan,
        ]);
        $penugasanPegawai = PenugasanPegawai::create($request->except('_token', '_method'));

        // TugasPegawai::create([
        //     'penugasan_pegawai' => $penugasanPegawai->id,
        //     'status' => 'proses'
        // ]);
        return redirect()->route('beban-kerja-tugas', ['id' => $id]);
    }

    public function update(Request $request, $id, $pegawai)
    {
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

    public function editTugas($tugasPegawai)
    {
        $tugas_pegawai = TugasPegawai::where('id', $tugasPegawai)->first();
        return view('pengumpulan-tugas-organik-edit', compact('tugas_pegawai', 'id'));
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


    public function storeTugas(Request $request)
    {
        $id = $request->kegiatan_id;
        $pegawai = $request->pegawai_id;
        $penugasanPegawai = TugasPegawai::create($request->except('_token', '_method', 'id', 'pegawai_id'));
        return redirect()->route('penugasan-organik-detail', ['id' => $id, 'petugas' => $pegawai]);
    }


    // public function update(Request $request, $id)
    // {
    //     $tanggal_penugasan_converted = DateTime::createFromFormat('d-m-Y', $request->get('tanggal_penugasan'))->format('Y-m-d');
    //     $request->merge([
    //         'tanggal_penugasan' => $tanggal_penugasan_converted,
    //     ]);
    //     PenugasanPegawai::where('id', $id)->update($request->except('_token', '_method'));

    //     return redirect()->route('penugasan-organik-detail', ['id' => $id]);
    // }

    public function delete($penugasan, $id)
    {
        PenugasanPegawai::where('id', $id)->delete();
        return redirect()->route('beban-kerja-tugas', ['id' => $penugasan]);
    }

    public function accPenugasan($id, $petugas, $tugasId)
    {
        $tugas = TugasPegawai::where('id', $tugasId)->first();
        $tugas->status = 'selesai';
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
