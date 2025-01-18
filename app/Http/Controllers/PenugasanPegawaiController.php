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
        $detail_tugas = PenugasanPegawai::with(['pegawai', 'kegiatan'])->find($id);

        if (!$detail_tugas) {
            return redirect()->back()->withErrors(['error' => 'Penugasan not found']);
        }

        $kegiatan = $detail_tugas->kegiatan;
        $harga_satuan = $kegiatan ? $kegiatan->harga_satuan : 'Tidak tersedia';

        $catatan = TugasPegawai::where('penugasan_pegawai', $id)
            ->whereIn('status', ['proses', 'selesai'])
            ->pluck('catatan')
            ->toArray();

        // Pass the variables to the view
        return view('penugasan-organik-detail', compact('detail_tugas', 'kegiatan', 'harga_satuan', 'catatan'));
    }

    public function index(Request $request)
    {
        $pegawai = Pegawai::paginate(10);

        $tanggalMulai = $request->get('tanggal_mulai');
        $tanggalAkhir = $request->get('tanggal_akhir');

        $query = DB::table('penugasan_pegawai')
            ->where('petugas', auth()->user()->id);

        if ($tanggalMulai && $tanggalAkhir) {
            $query->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir]);
        } elseif ($tanggalMulai) {
            $query->where('created_at', '>=', $tanggalMulai);
        } elseif ($tanggalAkhir) {
            $query->where('finished_at', '<=', $tanggalAkhir);
        }

        $penugasan = $query->paginate(10);

        return view('penugasan-organik-all', compact('pegawai', 'penugasan'));
    }

    public function view($id, $pegawai)
    {
        if (auth()->user()->jabatan == 'Organik') {
            if (auth()->user()->id != $pegawai) {
                return redirect()->back();
            }
        }

        $penugasan_pegawai = PenugasanPegawai::with(['pegawai', 'kegiatan'])
            ->where(['kegiatan_id' => $id, 'petugas' => $pegawai])
            ->first();

        if (!$penugasan_pegawai) {
            return redirect()->back()->withErrors(['error' => 'Penugasan not found']);
        }

        $kegiatan = Kegiatan::find($id);
        $nama_kegiatan = $kegiatan ? $kegiatan->nama : 'Unknown Kegiatan';
        $harga_satuan = $kegiatan ? $kegiatan->harga_satuan : null; // Fetch harga_satuan if available
        $nama_pegawai = Pegawai::find($pegawai)->nama;

        if (auth()->user()->jabatan == 'Ketua Tim') {
            if (auth()->user()->fungsi_ketua_tim != $kegiatan->asal_fungsi) {
                return redirect()->back();
            }
        }

        $penugasan_pegawai_id = $penugasan_pegawai->id;
        $tugas_pegawai = TugasPegawai::where('penugasan_pegawai', $penugasan_pegawai_id)
            ->whereIn('status', ['proses', 'selesai'])
            ->get();

        $selesai = TugasPegawai::where('status', 'selesai')->sum('dikerjakan');
        $proses = TugasPegawai::where('status', 'proses')->sum('dikerjakan');
        $diajukan = TugasPegawai::where('status', 'diajukan')->sum('dikerjakan');


        $pengajuan_pegawai = TugasPegawai::where(['penugasan_pegawai' => $penugasan_pegawai_id, 'status' => 'diajukan'])->get();

        $catatan = TugasPegawai::where('penugasan_pegawai', $penugasan_pegawai_id)
            ->whereIn('status', ['proses', 'selesai'])
            ->pluck('catatan')
            ->toArray();

        $totalTarget = $penugasan_pegawai->target;

        $progresDitugaskan = $totalTarget > 0 ? ($proses / $totalTarget) * 100 : 0;
        $progresSelesai = $totalTarget > 0 ? ($selesai / $totalTarget) * 100 : 0;

        return view('penugasan-detail-organik', compact(
            'pengajuan_pegawai',
            'penugasan_pegawai_id',
            'id',
            'pegawai',
            'nama_pegawai',
            'nama_kegiatan',
            'harga_satuan',
            'tugas_pegawai',
            'catatan',
            'proses',
            'selesai',
            'diajukan',
            'progresDitugaskan',
            'progresSelesai'
        ));
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

        $penugasan = PenugasanPegawai::where(['kegiatan_id' => $id, 'petugas' => $pegawai])->first();

        if ($penugasan) {
            PenugasanPegawai::where(['kegiatan_id' => $id, 'petugas' => $pegawai])
                ->update($request->except('_token', '_method'));
        }

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
        $kegiatan = Kegiatan::find($id);  // Retrieve the Kegiatan for the given ID
        return view('pengumpulan-tugas-organik-create', compact('penugasan_pegawai_id', 'id', 'pegawai', 'kegiatan'));  // Pass the $kegiatan variable to the view
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

        $kegiatan = Kegiatan::find($id);
        $tugas_pegawai = TugasPegawai::find($penugasanPegawai->id);

        return view('penugasan-organik-detail', compact('kegiatan', 'tugas_pegawai', 'id', 'pegawai'));  // Pass the $kegiatan variable to the view
    }


    public function updateTugas(Request $request)
    {
        $id = $request->kegiatan_id;
        $pegawai = $request->pegawai_id;

        TugasPegawai::where('id', $request->id)->first()->update($request->except('_token', '_method', 'id', 'pegawai_id'));

        $kegiatan = Kegiatan::find($id);
        $tugas_pegawai = TugasPegawai::find($request->id);

        return view('penugasan-organik-detail', compact('kegiatan', 'tugas_pegawai', 'id', 'pegawai'));
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

        $kegiatan = Kegiatan::find($id);

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
